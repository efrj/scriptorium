<?php

declare(strict_types=1);

namespace App\Web\NotFound;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Yiisoft\Http\Status;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Yii\View\Renderer\WebViewRenderer;

final readonly class NotFoundHandler implements RequestHandlerInterface
{
    /**
     * Summary of __construct
     * @param UrlGeneratorInterface $urlGenerator
     * @param CurrentRoute $currentRoute
     * @param WebViewRenderer $viewRenderer
     */
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private CurrentRoute $currentRoute,
        private WebViewRenderer $viewRenderer,
    ) {
    }

    /**
     * Summary of handle
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->viewRenderer
            ->render(__DIR__ . '/template', [
                'urlGenerator' => $this->urlGenerator,
                'currentRoute' => $this->currentRoute,
            ])
            ->withStatus(Status::NOT_FOUND);
    }
}
