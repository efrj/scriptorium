<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;

final class M240101000003CreateVersionsTable implements RevertibleMigrationInterface
{
    public function up(MigrationBuilder $b): void
    {
        $b->createTable('versions', [
            'id' => $b->primaryKey(),
            'code' => $b->string(20)->notNull(),
            'name' => $b->string(150)->notNull(),
            'language' => $b->string(10)->notNull(),
        ]);
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropTable('versions');
    }
}
