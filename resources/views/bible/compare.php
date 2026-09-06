<?php

declare(strict_types=1);

/** @var App\Entity\Version[] $versions */
/** @var App\Entity\Testament[] $testaments */
/** @var App\Entity\Book[] $books */
/** @var array<int, App\Entity\Version> $selectedVersions */
/** @var int[] $selectedVersionIds */
/** @var App\Entity\Book $currentBook */
/** @var int $chapter */
/** @var int $totalChapters */
/** @var int|null $highlightVerse */
/** @var array<int, array<int, App\Entity\Verse|null>> $comparedVerses */
/** @var array<int, App\Entity\Verse[]> $columnsData */
/** @var int $numColumns */
/** @var string $viewMode */
/** @var int $v1 */
/** @var int $v2 */
/** @var int $v3 */
/** @var Yiisoft\View\WebView $this */
/** @var Yiisoft\Router\UrlGeneratorInterface $urlGenerator */

$this->setTitle("Comparar {$currentBook->getDisplayName()} {$chapter} em {$numColumns} versões");

$colWidthClass = match($numColumns) {
    1 => 'col-12',
    2 => 'col-12 col-lg-6',
    default => 'col-12 col-lg-4',
};
?>

<div class="container-fluid px-lg-4">
    <!-- Comparison Control Form -->
    <div class="reading-toolbar shadow-sm mb-4">
        <form method="GET" action="/bible/compare" class="row g-2 align-items-center">
            <!-- Columns count selector -->
            <div class="col-6 col-md-2">
                <label class="form-label small text-muted mb-1"><i class="bi bi-layout-three-columns me-1"></i>Qtd. Versões:</label>
                <select name="cols" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="1" <?= $numColumns === 1 ? 'selected' : '' ?>>1 Versão</option>
                    <option value="2" <?= $numColumns === 2 ? 'selected' : '' ?>>2 Versões</option>
                    <option value="3" <?= $numColumns === 3 ? 'selected' : '' ?>>3 Versões</option>
                </select>
            </div>

            <!-- Version 1 Selector -->
            <div class="col-6 col-md-2">
                <label class="form-label small text-muted mb-1"><i class="bi bi-1-circle me-1"></i>Versão 1:</label>
                <select name="v1" class="form-select form-select-sm" onchange="this.form.submit()">
                    <?php foreach ($versions as $v): ?>
                        <option value="<?= $v->id ?>" <?= $v->id === $v1 ? 'selected' : '' ?>>
                            [<?= $v->code ?>] <?= htmlspecialchars($v->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Version 2 Selector -->
            <?php if ($numColumns >= 2): ?>
                <div class="col-6 col-md-2">
                    <label class="form-label small text-muted mb-1"><i class="bi bi-2-circle me-1"></i>Versão 2:</label>
                    <select name="v2" class="form-select form-select-sm" onchange="this.form.submit()">
                        <?php foreach ($versions as $v): ?>
                            <option value="<?= $v->id ?>" <?= $v->id === $v2 ? 'selected' : '' ?>>
                                [<?= $v->code ?>] <?= htmlspecialchars($v->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

            <!-- Version 3 Selector -->
            <?php if ($numColumns >= 3): ?>
                <div class="col-6 col-md-2">
                    <label class="form-label small text-muted mb-1"><i class="bi bi-3-circle me-1"></i>Versão 3:</label>
                    <select name="v3" class="form-select form-select-sm" onchange="this.form.submit()">
                        <?php foreach ($versions as $v): ?>
                            <option value="<?= $v->id ?>" <?= $v->id === $v3 ? 'selected' : '' ?>>
                                [<?= $v->code ?>] <?= htmlspecialchars($v->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

            <!-- Book Selector -->
            <div class="col-6 col-md-2">
                <label class="form-label small text-muted mb-1"><i class="bi bi-bookmarks me-1"></i>Livro:</label>
                <select name="b" id="select-book" class="form-select form-select-sm" onchange="this.form.submit()">
                    <optgroup label="Antigo Testamento">
                        <?php foreach ($books as $b): ?>
                            <?php if ($b->testamentId === 1 && $b->id <= 39): ?>
                                <option value="<?= $b->id ?>" data-chapters="<?= $b->chaptersCount ?>" <?= $b->id === $currentBook->id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($b->getDisplayName()) ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </optgroup>
                    <optgroup label="Deuterocanônicos (Bíblia Católica)">
                        <?php foreach ($books as $b): ?>
                            <?php if ($b->id >= 67 && $b->id <= 73): ?>
                                <option value="<?= $b->id ?>" data-chapters="<?= $b->chaptersCount ?>" <?= $b->id === $currentBook->id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($b->getDisplayName()) ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </optgroup>
                    <optgroup label="Novo Testamento">
                        <?php foreach ($books as $b): ?>
                            <?php if ($b->testamentId === 2): ?>
                                <option value="<?= $b->id ?>" data-chapters="<?= $b->chaptersCount ?>" <?= $b->id === $currentBook->id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($b->getDisplayName()) ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </optgroup>
                </select>
            </div>

            <!-- Chapter Selector -->
            <div class="col-3 col-md-1">
                <label class="form-label small text-muted mb-1"><i class="bi bi-hash me-1"></i>Cap.:</label>
                <select name="c" id="select-chapter" class="form-select form-select-sm" onchange="this.form.submit()">
                    <?php for ($c = 1; $c <= $totalChapters; $c++): ?>
                        <option value="<?= $c ?>" <?= $c === $chapter ? 'selected' : '' ?>>
                            <?= $c ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <!-- View Mode (Columns vs Row-by-Row) -->
            <div class="col-3 col-md-1">
                <label class="form-label small text-muted mb-1"><i class="bi bi-eye me-1"></i>Modo:</label>
                <select name="mode" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="columns" <?= $viewMode === 'columns' ? 'selected' : '' ?>>Colunas</option>
                    <option value="verses" <?= $viewMode === 'verses' ? 'selected' : '' ?>>Linhas</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Title Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="h4 mb-1 fw-bold">
                <?= htmlspecialchars($currentBook->getDisplayName()) ?> <?= $chapter ?>
                <span class="text-muted fw-normal fs-6"> - Comparação de <?= $numColumns ?> <?= $numColumns === 1 ? 'Versão' : 'Versões' ?></span>
            </h3>
        </div>

        <div class="d-flex gap-2">
            <?php if ($chapter > 1): ?>
                <a href="/bible/compare?cols=<?= $numColumns ?>&v1=<?= $v1 ?>&v2=<?= $v2 ?>&v3=<?= $v3 ?>&b=<?= $currentBook->id ?>&c=<?= $chapter - 1 ?>&mode=<?= $viewMode ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-chevron-left me-1"></i> Cap. <?= $chapter - 1 ?>
                </a>
            <?php endif; ?>

            <?php if ($chapter < $totalChapters): ?>
                <a href="/bible/compare?cols=<?= $numColumns ?>&v1=<?= $v1 ?>&v2=<?= $v2 ?>&v3=<?= $v3 ?>&b=<?= $currentBook->id ?>&c=<?= $chapter + 1 ?>&mode=<?= $viewMode ?>" class="btn btn-outline-secondary btn-sm">
                    Cap. <?= $chapter + 1 ?> <i class="bi bi-chevron-right ms-1"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($viewMode === 'columns'): ?>
        <!-- MODE 1: Side-by-Side Parallel Columns -->
        <div class="row g-3 mb-5">
            <?php foreach ($selectedVersionIds as $idx => $vId): ?>
                <?php 
                    $verObj = $selectedVersions[$vId] ?? null;
                    $colVerses = $columnsData[$vId] ?? [];
                ?>
                <div class="<?= $colWidthClass ?>">
                    <div class="compare-col shadow-sm">
                        <div class="compare-header d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-primary badge-version me-1"><?= htmlspecialchars($verObj ? $verObj->code : "V$vId") ?></span>
                                <strong class="small"><?= htmlspecialchars($verObj ? $verObj->name : '') ?></strong>
                            </div>
                            <span class="badge bg-light text-dark border"><?= strtoupper($verObj->language ?? 'PT') ?></span>
                        </div>
                        <div class="compare-body bible-text-area">
                            <?php if (empty($colVerses)): ?>
                                <p class="text-muted small my-3">Nenhum versículo disponível nesta tradução para este capítulo.</p>
                            <?php else: ?>
                                <?php foreach ($colVerses as $v): ?>
                                    <?php 
                                        $isHighlighted = ($highlightVerse !== null && $highlightVerse === $v->verse);
                                        $ref = "{$currentBook->getDisplayName($verObj->language)} {$chapter}:{$v->verse} ({$verObj->code})";
                                    ?>
                                    <div class="verse-item <?= $isHighlighted ? 'highlighted' : '' ?>" id="col-<?= $vId ?>-v-<?= $v->verse ?>">
                                        <span class="verse-number"><?= $v->verse ?></span>
                                        <span class="verse-text"><?= htmlspecialchars($v->text) ?></span>
                                        <span class="verse-actions">
                                            <button type="button" class="btn btn-xs btn-outline-secondary btn-copy-verse py-0 px-1" data-text="<?= htmlspecialchars($v->text) ?>" data-ref="<?= htmlspecialchars($ref) ?>" title="Copiar">
                                                <i class="bi bi-clipboard"></i>
                                            </button>
                                        </span>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <!-- MODE 2: Verse-by-Verse Row Comparison -->
        <div class="reader-container p-4 mb-5">
            <?php if (empty($comparedVerses)): ?>
                <div class="alert alert-info text-center">Nenhum versículo encontrado.</div>
            <?php else: ?>
                <?php foreach ($comparedVerses as $verseNum => $vMap): ?>
                    <?php $isHighlighted = ($highlightVerse !== null && $highlightVerse === $verseNum); ?>
                    <div class="verse-compare-row <?= $isHighlighted ? 'highlighted' : '' ?>" id="v-<?= $verseNum ?>">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-dark fs-6 me-2"><?= $currentBook->getDisplayName() ?> <?= $chapter ?>:<?= $verseNum ?></span>
                        </div>
                        <div class="row g-2">
                            <?php foreach ($selectedVersionIds as $vId): ?>
                                <?php 
                                    $verObj = $selectedVersions[$vId] ?? null;
                                    $vObj = $vMap[$vId] ?? null;
                                    $vText = $vObj ? $vObj->text : '—';
                                ?>
                                <div class="<?= $colWidthClass ?>">
                                    <div class="p-2 border rounded bg-light-subtle h-100">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="badge bg-secondary badge-version"><?= htmlspecialchars($verObj ? $verObj->code : "V$vId") ?></span>
                                            <small class="text-muted"><?= htmlspecialchars($verObj ? $verObj->name : '') ?></small>
                                        </div>
                                        <div class="bible-text-area fs-6">
                                            <?= htmlspecialchars($vText) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
