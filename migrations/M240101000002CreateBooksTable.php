<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;

final class M240101000002CreateBooksTable implements RevertibleMigrationInterface
{
    public function up(MigrationBuilder $b): void
    {
        $b->createTable('books', [
            'id' => $b->primaryKey(),
            'testament_id' => $b->integer()->notNull(),
            'position' => $b->integer()->notNull(),
            'name' => $b->string(100)->notNull(),
            'abbreviation' => $b->string(10)->notNull(),
            'name_pt' => $b->string(100)->notNull(),
            'abbreviation_pt' => $b->string(10)->notNull(),
            'chapters_count' => $b->integer()->defaultValue(0),
        ]);
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropTable('books');
    }
}
