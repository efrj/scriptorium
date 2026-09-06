<?php

declare(strict_types=1);

use App\Command\ImportBibleCommand;

return [
    'yiisoft/yii-console' => [
        'commands' => [
            'bible/import' => ImportBibleCommand::class,
        ],
    ],
];
