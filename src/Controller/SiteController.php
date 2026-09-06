<?php

declare(strict_types=1);

namespace App\Controller;

use HttpSoft\Message\Response;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\Router\UrlGeneratorInterface;

final class SiteController
{
    /**
     * Summary of __construct
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    /**
     * Summary of index
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $url = $this->urlGenerator->generate('bible.index');
        $response = new Response(302);
        return $response->withHeader('Location', $url);
    }
}
