<?php

declare(strict_types=1);

/** @var Yiisoft\View\WebView $this */
/** @var Yiisoft\Router\UrlGeneratorInterface $urlGenerator */
/** @var string $content */

$currentUrl = (string)($_SERVER['REQUEST_URI'] ?? '');
?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->getTitle() ? $this->getTitle() . ' - Scriptorium' : 'Scriptorium' ?></title>
    
    <!-- Google Fonts: Inter & Merriweather -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Merriweather:ital,wght@0,300;0,400;0,700;1,300;1,400&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="/css/style.css" rel="stylesheet">
</head>
<body>

    <!-- Main Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-bible sticky-top">
        <div class="container-fluid px-lg-4">
            <a class="navbar-brand d-flex align-items-center gap-2" href="/bible">
                <i class="bi bi-book-half fs-4"></i>
                <span>Scriptorium</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($currentUrl, '/bible/compare') === false && strpos($currentUrl, '/bible/search') === false ? 'active' : '' ?>" href="/bible">
                            <i class="bi bi-book me-1"></i> Leitor
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($currentUrl, '/bible/compare') !== false ? 'active' : '' ?>" href="/bible/compare">
                            <i class="bi bi-columns-gap me-1"></i> Comparador (até 3 versões)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($currentUrl, '/bible/search') !== false ? 'active' : '' ?>" href="/bible/search">
                            <i class="bi bi-search me-1"></i> Buscar
                        </a>
                    </li>
                </ul>

                <!-- Theme & Font Size Controls -->
                <div class="d-flex align-items-center gap-2 mt-2 mt-lg-0">
                    <!-- Font size adjuster -->
                    <div class="btn-group btn-group-sm" role="group" title="Tamanho da Fonte">
                        <button type="button" class="btn btn-outline-light" id="btn-font-decrease" title="Diminuir Fonte">A-</button>
                        <button type="button" class="btn btn-outline-light" id="btn-font-reset" title="Tamanho Padrão">A</button>
                        <button type="button" class="btn btn-outline-light" id="btn-font-increase" title="Aumentar Fonte">A+</button>
                    </div>

                    <!-- Theme toggle dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light dropdown-toggle d-flex align-items-center gap-1" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-palette"></i> Tema
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><button class="dropdown-item d-flex align-items-center gap-2" data-theme-btn="light"><i class="bi bi-sun"></i> Claro</button></li>
                            <li><button class="dropdown-item d-flex align-items-center gap-2" data-theme-btn="sepia"><i class="bi bi-book"></i> Sépia (Leitura)</button></li>
                            <li><button class="dropdown-item d-flex align-items-center gap-2" data-theme-btn="dark"><i class="bi bi-moon-stars"></i> Noturno</button></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="main-content py-4">
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="py-4 mt-auto">
        <div class="container text-center text-muted small">
            <p class="mb-1"><strong>Scriptorium</strong> &bull; Plataforma de Leitura e Estudos Bíblicos</p>
            <p class="mb-0">72 traduções e versões das Sagradas Escrituras com leitura paralela e comparativa.</p>
        </div>
    </footer>

    <!-- Bootstrap 5.3 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/app.js"></script>
</body>
</html>
