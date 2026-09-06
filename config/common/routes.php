<?php

declare(strict_types=1);

use App\Controller\BibleController;
use App\Controller\SiteController;
use Yiisoft\Router\Group;
use Yiisoft\Router\Route;

return [
    Group::create()
        ->routes(
            Route::get('/')
                ->action([SiteController::class, 'index'])
                ->name('home'),

            Route::get('/bible')
                ->action([BibleController::class, 'index'])
                ->name('bible.index'),

            Route::get('/bible/compare')
                ->action([BibleController::class, 'compare'])
                ->name('bible.compare'),

            Route::get('/bible/search')
                ->action([BibleController::class, 'search'])
                ->name('bible.search'),

            Route::get('/api/chapters')
                ->action([BibleController::class, 'apiChapters'])
                ->name('api.chapters'),
        ),
];
