<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;

final class M240101000004CreateVersesTable implements RevertibleMigrationInterface
{
    public function up(MigrationBuilder $b): void
    {
        $b->createTable('verses', [
            'id' => $b->primaryKey(),
            'version_id' => $b->integer()->notNull(),
            'book_id' => $b->integer()->notNull(),
            'chapter' => $b->integer()->notNull(),
            'verse' => $b->integer()->notNull(),
            'text' => $b->text()->notNull(),
        ]);

        $b->createIndex('idx_verses_lookup', 'verses', ['version_id', 'book_id', 'chapter', 'verse']);
        $b->createIndex('idx_verses_version_book', 'verses', ['version_id', 'book_id']);
        $b->createIndex('idx_verses_book_chap', 'verses', ['book_id', 'chapter', 'verse']);
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropTable('verses');
    }
}
