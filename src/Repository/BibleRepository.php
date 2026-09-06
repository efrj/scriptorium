<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Testament;
use App\Entity\Verse;
use App\Entity\Version;
use PDO;

final class BibleRepository implements BibleRepositoryInterface
{
    /** @var Version[]|null */
    private ?array $cachedVersions = null;

    /** @var Book[]|null */
    private ?array $cachedBooks = null;

    /** @var Testament[]|null */
    private ?array $cachedTestaments = null;

    /**
     * Summary of __construct
     * @param PDO $pdo
     */
    public function __construct(
        private readonly PDO $pdo,
    ) {
    }

    /**
     * Summary of getVersions
     * @return Version[]
     */
    public function getVersions(): array
    {
        if ($this->cachedVersions !== null) {
            return $this->cachedVersions;
        }

        $stmt = $this->pdo->query('SELECT id, code, name, language FROM versions ORDER BY id ASC');
        $rows = $stmt->fetchAll();
        $this->cachedVersions = array_map(fn($row) => Version::fromArray($row), $rows);

        return $this->cachedVersions;
    }

    /**
     * Summary of getVersionById
     * @param int $id
     * @return Version|null
     */
    public function getVersionById(int $id): ?Version
    {
        foreach ($this->getVersions() as $version) {
            if ($version->id === $id) {
                return $version;
            }
        }
        return null;
    }

    /**
     * Summary of getTestaments
     * @return Testament[]
     */
    public function getTestaments(): array
    {
        if ($this->cachedTestaments !== null) {
            return $this->cachedTestaments;
        }

        $stmt = $this->pdo->query('SELECT id, name, name_pt FROM testaments ORDER BY id ASC');
        $rows = $stmt->fetchAll();
        $this->cachedTestaments = array_map(fn($row) => Testament::fromArray($row), $rows);

        return $this->cachedTestaments;
    }

    /**
     * Summary of getBooks
     * @return Book[]
     */
    public function getBooks(): array
    {
        if ($this->cachedBooks !== null) {
            return $this->cachedBooks;
        }

        $stmt = $this->pdo->query('SELECT id, testament_id, position, name, abbreviation, name_pt, abbreviation_pt, chapters_count FROM books ORDER BY position ASC');
        $rows = $stmt->fetchAll();
        $this->cachedBooks = array_map(fn($row) => Book::fromArray($row), $rows);

        return $this->cachedBooks;
    }

    /**
     * Summary of getBookById
     * @param int $id
     * @return Book|null
     */
    public function getBookById(int $id): ?Book
    {
        foreach ($this->getBooks() as $book) {
            if ($book->id === $id) {
                return $book;
            }
        }
        return null;
    }

    /**
     * Summary of getChaptersCount
     * @param int $bookId
     * @return int
     */
    public function getChaptersCount(int $bookId): int
    {
        $book = $this->getBookById($bookId);
        if ($book !== null && $book->chaptersCount > 0) {
            return $book->chaptersCount;
        }

        $stmt = $this->pdo->prepare('SELECT MAX(chapter) as max_c FROM verses WHERE book_id = ?');
        $stmt->execute([$bookId]);
        $row = $stmt->fetch();
        return (int) ($row['max_c'] ?? 1);
    }

    /**
     * Summary of getVersesCount
     * @param int $versionId
     * @param int $bookId
     * @param int $chapter
     * @return int
     */
    public function getVersesCount(int $versionId, int $bookId, int $chapter): int
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) as cnt FROM verses WHERE version_id = ? AND book_id = ? AND chapter = ?');
        $stmt->execute([$versionId, $bookId, $chapter]);
        $row = $stmt->fetch();
        return (int) ($row['cnt'] ?? 0);
    }

    /**
     * Summary of getVerses
     * @param int $versionId
     * @param int $bookId
     * @param int $chapter
     * @return Verse[]
     */
    public function getVerses(int $versionId, int $bookId, int $chapter): array
    {
        $stmt = $this->pdo->prepare('SELECT id, version_id, book_id, chapter, verse, text FROM verses WHERE version_id = ? AND book_id = ? AND chapter = ? ORDER BY verse ASC');
        $stmt->execute([$versionId, $bookId, $chapter]);
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => Verse::fromArray($row), $rows);
    }

    /**
     * Summary of getVerse
     * @param int $versionId
     * @param int $bookId
     * @param int $chapter
     * @param int $verse
     * @return Verse|null
     */
    public function getVerse(int $versionId, int $bookId, int $chapter, int $verse): ?Verse
    {
        $stmt = $this->pdo->prepare('SELECT id, version_id, book_id, chapter, verse, text FROM verses WHERE version_id = ? AND book_id = ? AND chapter = ? AND verse = ? LIMIT 1');
        $stmt->execute([$versionId, $bookId, $chapter, $verse]);
        $row = $stmt->fetch();

        return $row ? Verse::fromArray($row) : null;
    }

    /**
     * Summary of compareChapter
     * @param int[] $versionIds
     * @param int $bookId
     * @param int $chapter
     * @return array<int, array<int, Verse|null>>
     */
    public function compareChapter(array $versionIds, int $bookId, int $chapter): array
    {
        if (empty($versionIds)) {
            return [];
        }

        $inClause = implode(',', array_fill(0, count($versionIds), '?'));
        $params = array_merge($versionIds, [$bookId, $chapter]);

        $sql = "SELECT id, version_id, book_id, chapter, verse, text FROM verses WHERE version_id IN ($inClause) AND book_id = ? AND chapter = ? ORDER BY verse ASC, version_id ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();

        $grouped = [];
        foreach ($rows as $row) {
            $verseObj = Verse::fromArray($row);
            $grouped[$verseObj->verse][$verseObj->versionId] = $verseObj;
        }

        // Fill missing translations with null
        foreach ($grouped as $verseNum => $vMap) {
            foreach ($versionIds as $vId) {
                if (!isset($grouped[$verseNum][$vId])) {
                    $grouped[$verseNum][$vId] = null;
                }
            }
        }

        ksort($grouped);
        return $grouped;
    }

    /**
     * Summary of getColumnsVerses
     * @param array<int, array{versionId: int, bookId: int, chapter: int}> $columnsConfig
     * @return array<int, Verse[]>
     */
    public function getColumnsVerses(array $columnsConfig): array
    {
        $result = [];
        foreach ($columnsConfig as $idx => $cfg) {
            $versionId = (int) ($cfg['versionId'] ?? 1);
            $bookId = (int) ($cfg['bookId'] ?? 1);
            $chapter = (int) ($cfg['chapter'] ?? 1);
            $result[$idx] = $this->getVerses($versionId, $bookId, $chapter);
        }
        return $result;
    }

    /**
     * Summary of search
     * @param int $versionId
     * @param string $query
     * @param int $limit
     * @return array<int, array{verse: Verse, book: Book, version: Version}>
     */
    public function search(int $versionId, string $query, int $limit = 50): array
    {
        $query = trim($query);
        if ($query === '') {
            return [];
        }

        $stmt = $this->pdo->prepare('SELECT id, version_id, book_id, chapter, verse, text FROM verses WHERE version_id = ? AND text LIKE ? ORDER BY book_id ASC, chapter ASC, verse ASC LIMIT ?');
        $stmt->bindValue(1, $versionId, PDO::PARAM_INT);
        $stmt->bindValue(2, '%' . $query . '%', PDO::PARAM_STR);
        $stmt->bindValue(3, $limit, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        $results = [];
        $books = [];
        foreach ($this->getBooks() as $b) {
            $books[$b->id] = $b;
        }
        $version = $this->getVersionById($versionId) ?? new Version($versionId, 'UNKNOWN', 'Unknown', 'pt');

        foreach ($rows as $row) {
            $verse = Verse::fromArray($row);
            $book = $books[$verse->bookId] ?? new Book($verse->bookId, 1, 1, 'Book ' . $verse->bookId, 'B' . $verse->bookId);
            $results[] = [
                'verse' => $verse,
                'book' => $book,
                'version' => $version,
            ];
        }

        return $results;
    }
}
