<?php

declare(strict_types=1);

namespace App\Command;

use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

final class ImportBibleCommand extends Command
{
    protected static $defaultName = 'bible/import';
    protected static $defaultDescription = 'Imports and seeds all consolidated Bible versions into configured database.';

    /**
     * Summary of __construct
     * @param PDO $pdo
     */
    public function __construct(
        private readonly PDO $pdo,
    ) {
        parent::__construct();
    }

    /**
     * Summary of configure
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('bible/import')
            ->setDescription('Imports consolidated Holy Bible translations into database.')
            ->addOption('sqlite', null, InputOption::VALUE_NONE, 'Force import directly into local SQLite database (data/bible.sqlite)')
            ->addOption('sql-file', 'f', InputOption::VALUE_OPTIONAL, 'Path to SQL dump file or directory', dirname(__DIR__, 2) . '/resources/sql')
            ->addOption('from-sqlite', null, InputOption::VALUE_OPTIONAL, 'Copy data from an existing SQLite database file');
    }

    /**
     * Summary of execute
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Scriptorium - Database Importer & Seeder');

        // Determine target PDO
        $forceSqlite = (bool)$input->getOption('sqlite');
        if ($forceSqlite) {
            $sqlitePath = dirname(__DIR__, 2) . '/data/bible.sqlite';
            $dir = dirname($sqlitePath);
            if (!is_dir($dir)) {
                @mkdir($dir, 0777, true);
            }
            $targetPdo = new PDO('sqlite:' . $sqlitePath);
            $targetPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $targetPdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $io->info("Target: SQLite ($sqlitePath)");
        } else {
            $targetPdo = $this->pdo;
            $driverName = (string)$targetPdo->getAttribute(PDO::ATTR_DRIVER_NAME);
            $io->info("Target: Configured Database ($driverName)");
        }

        $sqliteSourceFile = $input->getOption('from-sqlite');
        if ($sqliteSourceFile && file_exists($sqliteSourceFile)) {
            $io->info("Seeding data from SQLite source: $sqliteSourceFile");
            try {
                $srcDb = new PDO('sqlite:' . $sqliteSourceFile);
                $srcDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Check or create tables in target
                $this->ensureTables($targetPdo);

                // Clear target tables
                $targetPdo->exec('DELETE FROM verses;');
                $targetPdo->exec('DELETE FROM versions;');
                $targetPdo->exec('DELETE FROM books;');
                $targetPdo->exec('DELETE FROM testaments;');

                // 1. Testaments
                $stmt = $srcDb->query('SELECT id, name, name_pt FROM testaments ORDER BY id');
                $insert = $targetPdo->prepare('INSERT INTO testaments (id, name, name_pt) VALUES (?, ?, ?)');
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $insert->execute([(int)$row['id'], $row['name'], $row['name_pt']]);
                }
                $io->writeln(' ✔ Testaments imported.');

                // 2. Books
                $stmt = $srcDb->query('SELECT id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count FROM books ORDER BY id');
                $insert = $targetPdo->prepare('INSERT INTO books (id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $insert->execute([
                        (int)$row['id'], (int)$row['testament_id'], (int)$row['position'],
                        $row['name'], $row['abbreviation'], $row['name_pt'], $row['abbreviation_pt'],
                        (int)$row['chapters_count']
                    ]);
                }
                $io->writeln(' ✔ 73 Books imported.');

                // 3. Versions
                $stmt = $srcDb->query('SELECT id, code, name, language FROM versions ORDER BY id');
                $insert = $targetPdo->prepare('INSERT INTO versions (id, code, name, language) VALUES (?, ?, ?, ?)');
                $vCount = 0;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $insert->execute([(int)$row['id'], $row['code'], $row['name'], $row['language']]);
                    $vCount++;
                }
                $io->writeln(" ✔ $vCount Versions imported.");

                // 4. Verses
                $io->writeln(' Importing 2,068,000+ verses in batches...');
                $stmt = $srcDb->query('SELECT id, version_id, book_id, chapter, verse, text FROM verses ORDER BY id');
                $insert = $targetPdo->prepare('INSERT INTO verses (id, version_id, book_id, chapter, verse, text) VALUES (?, ?, ?, ?, ?, ?)');
                
                $targetPdo->beginTransaction();
                $count = 0;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $insert->execute([
                        (int)$row['id'], (int)$row['version_id'], (int)$row['book_id'],
                        (int)$row['chapter'], (int)$row['verse'], $row['text']
                    ]);
                    $count++;
                    if ($count % 5000 === 0) {
                        $targetPdo->commit();
                        $targetPdo->beginTransaction();
                        $io->write(" Imported $count verses...\r");
                    }
                }
                $targetPdo->commit();

                $io->success("\nBible data imported successfully! Total verses: $count");
                return Command::SUCCESS;
            } catch (Throwable $e) {
                if ($targetPdo->inTransaction()) {
                    $targetPdo->rollBack();
                }
                $io->error('Import failed: ' . $e->getMessage());
                return Command::FAILURE;
            }
        }

        $sqlPath = $input->getOption('sql-file');
        if (!file_exists($sqlPath)) {
            $io->error("SQL path not found: $sqlPath");
            return Command::FAILURE;
        }

        $isSqlite = ($targetPdo->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite');
        if ($isSqlite) {
            $targetPdo->exec('PRAGMA synchronous = OFF;');
            $targetPdo->exec('PRAGMA journal_mode = MEMORY;');
        }

        if (is_dir($sqlPath)) {
            $files = array_values(array_filter((array)glob($sqlPath . '/*.sql'), 'is_file'));
            sort($files);
            $io->info(sprintf("Importing %d modular SQL dumps from: %s", count($files), $sqlPath));
            
            $progressBar = $io->createProgressBar(count($files));
            $progressBar->start();

            foreach ($files as $file) {
                $sql = file_get_contents($file);
                if ($isSqlite) {
                    $targetPdo->beginTransaction();
                    $targetPdo->exec($sql);
                    $targetPdo->commit();
                } else {
                    $targetPdo->exec($sql);
                }
                $progressBar->advance();
            }
            $progressBar->finish();
            $io->newLine(2);
            $io->success('All SQL dumps executed successfully!');
        } else {
            $io->info("Importing from SQL dump: $sqlPath");
            $sql = file_get_contents($sqlPath);
            if ($isSqlite) {
                $targetPdo->beginTransaction();
                $targetPdo->exec($sql);
                $targetPdo->commit();
            } else {
                $targetPdo->exec($sql);
            }
            $io->success('SQL Dump executed successfully!');
        }

        return Command::SUCCESS;
    }

    /**
     * Summary of ensureTables
     * @param PDO $targetPdo
     * @return void
     */
    private function ensureTables(PDO $targetPdo): void
    {
        $sql = <<<SQL
CREATE TABLE IF NOT EXISTS testaments (
    id INTEGER PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    name_pt VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS books (
    id INTEGER PRIMARY KEY,
    testament_id INTEGER NOT NULL,
    position INTEGER NOT NULL,
    name VARCHAR(100) NOT NULL,
    abbreviation VARCHAR(10) NOT NULL,
    name_pt VARCHAR(100) NOT NULL,
    abbreviation_pt VARCHAR(10) NOT NULL,
    chapters_count INTEGER DEFAULT 0
);

CREATE TABLE IF NOT EXISTS versions (
    id INTEGER PRIMARY KEY,
    code VARCHAR(20) NOT NULL,
    name VARCHAR(150) NOT NULL,
    language VARCHAR(10) NOT NULL
);

CREATE TABLE IF NOT EXISTS verses (
    id INTEGER PRIMARY KEY,
    version_id INTEGER NOT NULL,
    book_id INTEGER NOT NULL,
    chapter INTEGER NOT NULL,
    verse INTEGER NOT NULL,
    text TEXT NOT NULL
);
SQL;
        $targetPdo->exec($sql);
    }
}
