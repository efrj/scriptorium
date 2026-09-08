<?php

declare(strict_types=1);

/** @var App\Entity\Book[] $books */
/** @var App\Entity\Version|null $currentVersion */

$lang = $currentVersion ? $currentVersion->language : 'pt';

$bookGroups = [
    'at' => [
        'title' => 'Antigo Testamento',
        'badge' => 'bg-warning-subtle text-warning-emphasis border border-warning-subtle',
        'books' => [],
    ],
    'nt' => [
        'title' => 'Novo Testamento',
        'badge' => 'bg-primary-subtle text-primary border border-primary-subtle',
        'books' => [],
    ],
    'dc' => [
        'title' => 'Deuterocanônicos (Bíblia Católica)',
        'badge' => 'bg-info-subtle text-info-emphasis border border-info-subtle',
        'books' => [],
    ],
];

foreach ($books as $b) {
    if ($b->id >= 67 && $b->id <= 73) {
        $bookGroups['dc']['books'][] = $b;
    } elseif ($b->testamentId === 1 && $b->id <= 39) {
        $bookGroups['at']['books'][] = $b;
    } else {
        $bookGroups['nt']['books'][] = $b;
    }
}

$totalBooksCount = count($books);
?>
<!-- Book Picker Modal with Search, Tabs, and Grid of Styled Cards -->
<div class="modal fade" id="bookPickerModal" tabindex="-1" aria-labelledby="bookPickerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar-icon bg-warning-subtle text-warning-emphasis rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="bi bi-bookmarks fs-5"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="bookPickerModalLabel">Selecionar Livro da Bíblia</h5>
                        <p class="small text-muted mb-0">Escolha entre os <?= $totalBooksCount ?> livros disponíveis (Antigo Testamento, Novo Testamento e Deuterocanônicos)</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            
            <div class="modal-header bg-body-tertiary px-3 py-2 border-bottom flex-column align-items-stretch gap-2">
                <!-- Quick Search Input -->
                <div class="input-group">
                    <span class="input-group-text bg-body border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="search" id="modalBookSearch" class="form-control border-start-0 ps-1" placeholder="Buscar por livro ou sigla (ex: Gn, Gênesis, Salmos, Mateus, Rm, Apocalipse)..." autocomplete="off">
                    <button class="btn btn-outline-secondary d-none" id="modalBookClearSearch" type="button" title="Limpar busca"><i class="bi bi-x-lg"></i></button>
                </div>
                
                <!-- Testament / Category Filter Tabs -->
                <div class="d-flex gap-1 overflow-x-auto pb-1 book-filter-pills" role="tablist">
                    <button type="button" class="btn btn-sm btn-outline-warning active rounded-pill px-3 py-1 flex-shrink-0" data-book-filter="all">
                        Todos <span class="badge text-bg-warning-subtle text-warning-emphasis ms-1"><?= $totalBooksCount ?></span>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-3 py-1 flex-shrink-0" data-book-filter="at">
                        Antigo Testamento <span class="badge text-bg-secondary ms-1"><?= count($bookGroups['at']['books']) ?></span>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-3 py-1 flex-shrink-0" data-book-filter="nt">
                        Novo Testamento <span class="badge text-bg-secondary ms-1"><?= count($bookGroups['nt']['books']) ?></span>
                    </button>
                    <?php if (!empty($bookGroups['dc']['books'])): ?>
                        <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-3 py-1 flex-shrink-0" data-book-filter="dc">
                            Deuterocanônicos <span class="badge text-bg-secondary ms-1"><?= count($bookGroups['dc']['books']) ?></span>
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="modal-body p-3" id="modalBookListBody">
                <div id="modalBookListContainer">
                    <?php foreach ($bookGroups as $groupKey => $groupInfo): ?>
                        <?php if (empty($groupInfo['books'])) continue; ?>
                        <div class="book-group-section mb-4" data-group-section="<?= $groupKey ?>">
                            <div class="book-group-header d-flex align-items-center justify-content-between px-1 pb-2 mb-2 border-bottom">
                                <span class="d-flex align-items-center gap-2">
                                    <span class="badge <?= $groupInfo['badge'] ?> px-2.5 py-1 fs-6 fw-semibold"><?= htmlspecialchars($groupInfo['title']) ?></span>
                                    <span class="text-muted small fw-normal">(<?= count($groupInfo['books']) ?> livros)</span>
                                </span>
                            </div>
                            
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-2">
                                <?php foreach ($groupInfo['books'] as $b): ?>
                                    <?php 
                                        $dispName = $b->getDisplayName($lang);
                                        $dispAbbr = $b->getDisplayAbbreviation($lang);
                                        $searchHaystack = mb_strtolower("{$dispName} {$b->name} {$b->namePt} {$dispAbbr} {$b->abbreviation} {$b->abbreviationPt} {$b->chaptersCount} caps capitulos {$groupInfo['title']}", 'UTF-8');
                                    ?>
                                    <div class="col book-col-item">
                                        <label class="book-option-card card h-100 p-2.5 rounded-3 border cursor-pointer user-select-none d-flex flex-row align-items-center justify-content-between" 
                                               data-book-id="<?= $b->id ?>" 
                                               data-book-name="<?= htmlspecialchars($dispName) ?>"
                                               data-book-abbr="<?= htmlspecialchars($dispAbbr) ?>"
                                               data-book-chapters="<?= $b->chaptersCount ?>"
                                               data-group="<?= $groupKey ?>"
                                               data-search="<?= htmlspecialchars($searchHaystack) ?>">
                                            <div class="d-flex align-items-center gap-2 overflow-hidden flex-grow-1">
                                                <div class="form-check m-0 p-0 d-flex align-items-center pe-1">
                                                    <input class="form-check-input book-radio-input fs-6 m-0 cursor-pointer" type="radio" name="modal_book_radio" value="<?= $b->id ?>" id="modal_b_radio_<?= $b->id ?>">
                                                </div>
                                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle font-monospace fw-bold px-1.5 py-1 fs-6 flex-shrink-0 book-pill-code">
                                                    <?= htmlspecialchars($dispAbbr) ?>
                                                </span>
                                                <div class="text-truncate">
                                                    <div class="fw-semibold text-truncate text-body book-card-title small"><?= htmlspecialchars($dispName) ?></div>
                                                    <div class="text-muted text-truncate book-card-subtitle" style="font-size: 0.75rem;">
                                                        <?= $b->chaptersCount ?> <?= $b->chaptersCount === 1 ? 'capítulo' : 'capítulos' ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ms-1 flex-shrink-0">
                                                <i class="bi bi-check-circle-fill text-warning fs-5 check-icon-active d-none"></i>
                                            </div>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div id="no-book-found-msg" class="alert alert-warning text-center my-4 d-none">
                    <i class="bi bi-search fs-3 d-block mb-2"></i>
                    Nenhum livro encontrado com o termo pesquisado.
                </div>
            </div>

            <div class="modal-footer border-top bg-body-tertiary py-2 px-3 justify-content-between">
                <span class="small text-muted" id="bookCounterInfo"><?= $totalBooksCount ?> livros disponíveis</span>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-sm btn-warning px-3 fw-semibold text-dark" id="modalConfirmBookBtn">
                        <i class="bi bi-check2 me-1"></i> Selecionar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
