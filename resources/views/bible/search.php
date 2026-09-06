<?php

declare(strict_types=1);

/** @var App\Entity\Version[] $versions */
/** @var App\Entity\Version $currentVersion */
/** @var string $query */
/** @var array<int, array{verse: App\Entity\Verse, book: App\Entity\Book, version: App\Entity\Version}> $results */
/** @var Yiisoft\View\WebView $this */
/** @var Yiisoft\Router\UrlGeneratorInterface $urlGenerator */

$this->setTitle('Buscar nas Escrituras');
?>

<div class="container-xl">
    <!-- Search Form -->
    <div class="reading-toolbar shadow-sm mb-4">
        <form method="GET" action="/bible/search" class="row g-2 align-items-center">
            <div class="col-12 col-md-4">
                <label class="form-label small text-muted mb-1"><i class="bi bi-translate me-1"></i>Versão / Tradução:</label>
                <select name="v" class="form-select form-select-sm">
                    <?php foreach ($versions as $v): ?>
                        <option value="<?= $v->id ?>" <?= $v->id === $currentVersion->id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($v->getFullTitle()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-12 col-md-6">
                <label class="form-label small text-muted mb-1"><i class="bi bi-search me-1"></i>Termo ou Frase:</label>
                <input type="text" name="q" class="form-control form-control-sm" placeholder="Ex: No princípio, Amor, Jesus, Fé..." value="<?= htmlspecialchars($query) ?>" required autofocus>
            </div>

            <div class="col-12 col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-sm btn-primary w-100">
                    <i class="bi bi-search me-1"></i> Pesquisar
                </button>
            </div>
        </form>
    </div>

    <!-- Search Results -->
    <?php if ($query !== ''): ?>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="h5 mb-0">Resultados da busca por: <span class="text-primary">"<?= htmlspecialchars($query) ?>"</span></h4>
            <span class="badge bg-secondary"><?= count($results) ?> versículos encontrados</span>
        </div>

        <?php if (empty($results)): ?>
            <div class="alert alert-warning text-center my-4 py-4">
                <i class="bi bi-exclamation-triangle fs-3 d-block mb-2"></i>
                Nenhum versículo encontrado contendo "<strong><?= htmlspecialchars($query) ?></strong>" na versão <?= htmlspecialchars($currentVersion->name) ?>.
            </div>
        <?php else: ?>
            <div class="reader-container p-4 mb-5">
                <?php foreach ($results as $item): ?>
                    <?php 
                        $verse = $item['verse'];
                        $book = $item['book'];
                        $bookName = $book->getDisplayName($currentVersion->language);
                        $highlightedText = preg_replace('/(' . preg_quote($query, '/') . ')/iu', '<mark class="bg-warning-subtle fw-semibold px-1 rounded">$1</mark>', htmlspecialchars($verse->text));
                    ?>
                    <div class="verse-compare-row">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <a href="/bible?v=<?= $currentVersion->id ?>&b=<?= $book->id ?>&c=<?= $verse->chapter ?>&verse=<?= $verse->verse ?>" class="fw-bold text-decoration-none">
                                <i class="bi bi-book me-1"></i> <?= htmlspecialchars($bookName) ?> <?= $verse->chapter ?>:<?= $verse->verse ?>
                            </a>
                            <a href="/bible/compare?b=<?= $book->id ?>&c=<?= $verse->chapter ?>&verse=<?= $verse->verse ?>" class="btn btn-xs btn-outline-primary py-0 px-2 small" title="Comparar em outras versões">
                                <i class="bi bi-columns-gap me-1"></i> Comparar
                            </a>
                        </div>
                        <div class="bible-text-area fs-6">
                            <?= $highlightedText ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="text-center text-muted py-5">
            <i class="bi bi-search display-3 text-secondary opacity-50 d-block mb-3"></i>
            <p class="lead">Digite uma palavra ou frase para buscar em toda a Bíblia.</p>
        </div>
    <?php endif; ?>
</div>
