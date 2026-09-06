<?php

declare(strict_types=1);

use App\Environment;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Definitions\Reference;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Router\UrlGeneratorInterface;

return [
    'application' => require __DIR__ . '/application.php',

    'yiisoft/aliases' => [
        'aliases' => require __DIR__ . '/aliases.php',
    ],

    'db' => [
        'driver' => Environment::get('DB_DRIVER', 'pgsql'),
        'host' => Environment::get('DB_HOST', '127.0.0.1'),
        'port' => Environment::get('DB_PORT', '5432'),
        'database' => Environment::get('DB_NAME', 'holybible'),
        'username' => Environment::get('DB_USER', 'postgres'),
        'password' => Environment::get('DB_PASSWORD', 'postgres'),
        'sqlitePath' => dirname(__DIR__, 2) . '/data/bible.sqlite',
    ],

    'yiisoft/view' => [
        'basePath' => '@resources/views',
        'parameters' => [
            'aliases' => Reference::to(Aliases::class),
            'urlGenerator' => Reference::to(UrlGeneratorInterface::class),
            'currentRoute' => Reference::to(CurrentRoute::class),
        ],
    ],

    'yiisoft/yii-view-renderer' => [
        'viewPath' => '@resources/views',
        'layout' => '@resources/views/layout/main.php',
        'injections' => [],
    ],
];
