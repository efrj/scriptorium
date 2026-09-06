<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;

final class M240101000001CreateTestamentsTable implements RevertibleMigrationInterface
{
    public function up(MigrationBuilder $b): void
    {
        $b->createTable('testaments', [
            'id' => $b->primaryKey(),
            'name' => $b->string(50)->notNull(),
            'name_pt' => $b->string(50)->notNull(),
        ]);
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropTable('testaments');
    }
}
