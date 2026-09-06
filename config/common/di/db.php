<?php

declare(strict_types=1);

use App\Repository\BibleRepository;
use App\Repository\BibleRepositoryInterface;
use Yiisoft\Db\Connection\ConnectionInterface;
use Yiisoft\Db\Pgsql\Connection as PgsqlConnection;
use Yiisoft\Db\Pgsql\Driver as PgsqlDriver;
use Yiisoft\Db\Sqlite\Connection as SqliteConnection;
use Yiisoft\Db\Sqlite\Driver as SqliteDriver;
use Yiisoft\Db\Mysql\Connection as MysqlConnection;
use Yiisoft\Db\Mysql\Driver as MysqlDriver;

/** @var array $params */

return [
    PDO::class => static function () use ($params) {
        $db = $params['db'];
        $driver = $db['driver'] ?? 'pgsql';

        if ($driver === 'pgsql') {
            $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s;', $db['host'], $db['port'], $db['database']);
            try {
                $pdo = new PDO($dsn, $db['username'], $db['password']);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                return $pdo;
            } catch (Throwable $e) {
                // Fallback to SQLite if PostgreSQL is not yet running/connected
                if (!empty($db['sqlitePath'])) {
                    $dir = dirname($db['sqlitePath']);
                    if (!is_dir($dir)) {
                        @mkdir($dir, 0777, true);
                    }
                    $pdo = new PDO('sqlite:' . $db['sqlitePath']);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                    return $pdo;
                }
                throw $e;
            }
        } elseif ($driver === 'mysql') {
            $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $db['host'], $db['port'], $db['database']);
            $pdo = new PDO($dsn, $db['username'], $db['password']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } else {
            $path = $db['sqlitePath'] ?? (dirname(__DIR__, 2) . '/data/bible.sqlite');
            $dir = dirname($path);
            if (!is_dir($dir)) {
                @mkdir($dir, 0777, true);
            }
            $pdo = new PDO('sqlite:' . $path);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        }
    },

    BibleRepositoryInterface::class => BibleRepository::class,
];
