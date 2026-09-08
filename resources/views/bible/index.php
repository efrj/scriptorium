<?php

declare(strict_types=1);

/** @var App\Entity\Version[] $versions */
/** @var App\Entity\Testament[] $testaments */
/** @var App\Entity\Book[] $books */
/** @var App\Entity\Version $currentVersion */
/** @var App\Entity\Book $currentBook */
/** @var int $chapter */
/** @var int $totalChapters */
/** @var App\Entity\Verse[] $verses */
/** @var int|null $highlightVerse */
/** @var array|null $prevLink */
/** @var array|null $nextLink */
/** @var Yiisoft\View\WebView $this */
/** @var Yiisoft\Router\UrlGeneratorInterface $urlGenerator */

$bookName = $currentBook->getDisplayName($currentVersion->language);
$title = "{$bookName} {$chapter} - {$currentVersion->name}";
$this->setTitle($title);
?>

<div class="container-xl">
    <!-- Top Control / Selector Bar -->
    <div class="reading-toolbar shadow-sm mb-4">
        <form method="GET" action="/bible" class="row g-2 align-items-center">
            <!-- Version Selector Modal Trigger -->
            <div class="col-12 col-md-4">
                <label class="form-label small text-muted mb-1"><i class="bi bi-translate me-1"></i>Versão /
                    Tradução:</label>
                <div class="version-picker-wrapper position-relative">
                    <input type="hidden" name="v" id="version-input-v" value="<?= $currentVersion->id ?>"
                        class="version-field-input">
                    <button type="button"
                        class="form-select form-select-sm text-start d-flex justify-content-between align-items-center w-100 version-picker-trigger"
                        data-bs-toggle="modal" data-bs-target="#versionPickerModal" data-target-input="version-input-v"
                        data-auto-submit="true" title="Clique para escolher entre as <?= count($versions) ?> versões">
                        <span class="text-truncate d-flex align-items-center gap-1.5 me-2">
                            <span
                                class="badge bg-primary text-white font-monospace version-badge-code"><?= htmlspecialchars($currentVersion->code) ?></span>
                            <span
                                class="text-truncate version-btn-name fw-medium ms-2"><?= htmlspecialchars($currentVersion->name) ?></span>
                        </span>
                        <span
                            class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill px-2 py-0.5 small version-btn-lang flex-shrink-0"><?= strtoupper($currentVersion->language) ?></span>
                    </button>
                </div>
            </div>

            <!-- Book Selector Modal Trigger -->
            <div class="col-6 col-md-3">
                <label class="form-label small text-muted mb-1"><i class="bi bi-bookmarks me-1"></i>Livro:</label>
                <div class="book-picker-wrapper position-relative">
                    <input type="hidden" name="b" id="book-input-b" value="<?= $currentBook->id ?>" class="book-field-input">
                    <button type="button"
                        class="form-select form-select-sm text-start d-flex justify-content-between align-items-center w-100 book-picker-trigger"
                        data-bs-toggle="modal" data-bs-target="#bookPickerModal" data-target-input="book-input-b"
                        data-auto-submit="true" title="Clique para escolher entre os <?= count($books) ?> livros">
                        <span class="text-truncate d-flex align-items-center gap-1.5 me-2">
                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle font-monospace book-badge-abbr"><?= htmlspecialchars($currentBook->getDisplayAbbreviation($currentVersion->language)) ?></span>
                            <span class="text-truncate book-btn-name fw-medium ms-1"><?= htmlspecialchars($currentBook->getDisplayName($currentVersion->language)) ?></span>
                        </span>
                        <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill px-2 py-0.5 small book-btn-chapters flex-shrink-0"><?= $currentBook->chaptersCount ?> caps</span>
                    </button>
                </div>
            </div>

            <!-- Chapter Selector -->
            <div class="col-3 col-md-2">
                <label class="form-label small text-muted mb-1"><i class="bi bi-hash me-1"></i>Capítulo:</label>
                <select name="c" id="select-chapter" class="form-select form-select-sm" onchange="this.form.submit()">
                    <?php for ($c = 1; $c <= $totalChapters; $c++): ?>
                        <option value="<?= $c ?>" <?= $c === $chapter ? 'selected' : '' ?>>
                            <?= $c ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <!-- Verse Jump Selector -->
            <div class="col-3 col-md-2">
                <label class="form-label small text-muted mb-1"><i class="bi bi-list-ol me-1"></i>Versículo:</label>
                <select id="select-verse" class="form-select form-select-sm">
                    <option value="">Ir para...</option>
                    <?php foreach ($verses as $v): ?>
                        <option value="<?= $v->verse ?>" <?= $highlightVerse === $v->verse ? 'selected' : '' ?>>
                            Versículo <?= $v->verse ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Compare Shortcut -->
            <div class="col-12 col-md-1 d-flex align-items-end">
                <a href="/bible/compare?b=<?= $currentBook->id ?>&c=<?= $chapter ?>&v1=<?= $currentVersion->id ?>"
                    class="btn btn-sm btn-outline-primary w-100" title="Comparar este capítulo com outras versões">
                    <i class="bi bi-columns-gap"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Chapter Header & Navigation Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <?php if ($prevLink): ?>
                <a href="/bible?v=<?= $prevLink['v'] ?>&b=<?= $prevLink['b'] ?>&c=<?= $prevLink['c'] ?>"
                    class="btn btn-outline-secondary btn-sm px-3">
                    <i class="bi bi-chevron-left me-1"></i> Anterior
                </a>
            <?php else: ?>
                <button class="btn btn-outline-secondary btn-sm px-3" disabled><i class="bi bi-chevron-left me-1"></i>
                    Anterior</button>
            <?php endif; ?>
        </div>

        <div class="text-center">
            <h2 class="h3 mb-0 fw-bold"><?= htmlspecialchars($bookName) ?> <?= $chapter ?></h2>
            <div class="text-muted small">
                <span class="badge bg-secondary"><?= htmlspecialchars($currentVersion->code) ?></span>
                <?= htmlspecialchars($currentVersion->name) ?>
            </div>
        </div>

        <div>
            <?php if ($nextLink): ?>
                <a href="/bible?v=<?= $nextLink['v'] ?>&b=<?= $nextLink['b'] ?>&c=<?= $nextLink['c'] ?>"
                    class="btn btn-outline-secondary btn-sm px-3">
                    Próximo <i class="bi bi-chevron-right ms-1"></i>
                </a>
            <?php else: ?>
                <button class="btn btn-outline-secondary btn-sm px-3" disabled>Próximo <i
                        class="bi bi-chevron-right ms-1"></i></button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Reading Content Area -->
    <div class="reader-container p-4 p-md-5 mb-5">
        <div class="bible-text-area">
            <?php if (empty($verses)): ?>
                <div class="alert alert-info text-center my-4">
                    <i class="bi bi-info-circle me-2"></i> Nenhum versículo encontrado para este capítulo nesta tradução.
                </div>
            <?php else: ?>
                <?php foreach ($verses as $verse): ?>
                    <?php
                    $isHighlighted = ($highlightVerse !== null && $highlightVerse === $verse->verse);
                    $verseRef = "{$bookName} {$chapter}:{$verse->verse} ({$currentVersion->code})";
                    ?>
                    <div class="verse-item <?= $isHighlighted ? 'highlighted' : '' ?>" id="v-<?= $verse->verse ?>">
                        <span class="verse-number"><?= $verse->verse ?></span>
                        <span class="verse-text"><?= htmlspecialchars($verse->text) ?></span>
                        <span class="verse-actions">
                            <button type="button" class="btn btn-xs btn-outline-secondary btn-copy-verse py-0 px-1"
                                title="Copiar versículo" data-text="<?= htmlspecialchars($verse->text) ?>"
                                data-ref="<?= htmlspecialchars($verseRef) ?>">
                                <i class="bi bi-clipboard"></i>
                            </button>
                            <a href="/bible/compare?b=<?= $currentBook->id ?>&c=<?= $chapter ?>&verse=<?= $verse->verse ?>"
                                class="btn btn-xs btn-outline-primary py-0 px-1 ms-1"
                                title="Comparar este versículo em até 3 versões">
                                <i class="bi bi-columns-gap"></i>
                            </a>
                        </span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <?php if ($prevLink): ?>
            <a href="/bible?v=<?= $prevLink['v'] ?>&b=<?= $prevLink['b'] ?>&c=<?= $prevLink['c'] ?>"
                class="btn btn-outline-secondary">
                <i class="bi bi-chevron-left me-1"></i> Capítulo Anterior
            </a>
        <?php else: ?>
            <span></span>
        <?php endif; ?>

        <a href="#top" class="btn btn-light border btn-sm"
            onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;">
            <i class="bi bi-arrow-up me-1"></i> Voltar ao topo
        </a>

        <?php if ($nextLink): ?>
            <a href="/bible?v=<?= $nextLink['v'] ?>&b=<?= $nextLink['b'] ?>&c=<?= $nextLink['c'] ?>"
                class="btn btn-outline-secondary">
                Próximo Capítulo <i class="bi bi-chevron-right ms-1"></i>
            </a>
        <?php endif; ?>
    </div>
</div>

<?= $this->render('bible/_version_modal', ['versions' => $versions]) ?>
<?= $this->render('bible/_book_modal', ['books' => $books, 'currentVersion' => $currentVersion]) ?>