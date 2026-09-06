<?php

declare(strict_types=1);

/** @var Yiisoft\Router\UrlGeneratorInterface $urlGenerator */
/** @var Yiisoft\View\WebView $this */

$this->setTitle('404 - Página Não Encontrada / Page Not Found');
?>

<div class="container text-center py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1 fw-bold text-primary">404</h1>
            <h2 class="mb-4">Página Não Encontrada / Page Not Found</h2>
            <p class="lead text-muted mb-4">A página ou passagem bíblica solicitada não pôde ser encontrada.</p>
            <a href="<?= $urlGenerator->generate('bible.index') ?>" class="btn btn-primary px-4 py-2">
                <i class="bi bi-book me-2"></i>Ir para a Bíblia / Go to Bible
            </a>
        </div>
    </div>
</div>
