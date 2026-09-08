<?php

declare(strict_types=1);

/** @var App\Entity\Version[] $versions */

$langGroups = [
    'pt' => [
        'title' => 'Português',
        'badge' => 'bg-primary text-white',
        'versions' => [],
    ],
    'en' => [
        'title' => 'English',
        'badge' => 'bg-primary-subtle text-primary border border-primary-subtle',
        'versions' => [],
    ],
    'es' => [
        'title' => 'Español',
        'badge' => 'bg-warning-subtle text-warning-emphasis border border-warning-subtle',
        'versions' => [],
    ],
    'other' => [
        'title' => 'Outros Idiomas Globais',
        'badge' => 'bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle',
        'versions' => [],
    ],
];

foreach ($versions as $v) {
    $lang = strtolower($v->language);
    if ($lang === 'pt') {
        $langGroups['pt']['versions'][] = $v;
    } elseif ($lang === 'en') {
        $langGroups['en']['versions'][] = $v;
    } elseif ($lang === 'es') {
        $langGroups['es']['versions'][] = $v;
    } else {
        $langGroups['other']['versions'][] = $v;
    }
}
?>
<!-- Version Picker Modal with Search, Tabs, and Styled Radio Cards -->
<div class="modal fade" id="versionPickerModal" tabindex="-1" aria-labelledby="versionPickerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar-icon bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 38px; height: 38px;">
                        <i class="bi bi-translate fs-5"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="versionPickerModalLabel">Selecionar Tradução / Versão
                        </h5>
                        <p class="small text-muted mb-0">Escolha entre as <?= count($versions) ?> versões disponíveis
                            organizadas por idioma</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-header bg-body-tertiary px-3 py-2 border-bottom flex-column align-items-stretch gap-2">
                <!-- Quick Search Input -->
                <div class="input-group">
                    <span class="input-group-text bg-body border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="search" id="modalVersionSearch" class="form-control border-start-0 ps-1"
                        placeholder="Buscar por sigla, nome ou idioma (ex: NVI, ACF, King James, Italiano)..."
                        autocomplete="off">
                    <button class="btn btn-outline-secondary d-none" id="modalVersionClearSearch" type="button"
                        title="Limpar busca"><i class="bi bi-x-lg"></i></button>
                </div>

                <!-- Language Filter Tabs / Pills -->
                <div class="d-flex gap-1 overflow-x-auto pb-1 language-filter-pills" role="tablist">
                    <button type="button"
                        class="btn btn-sm btn-outline-primary active rounded-pill px-3 py-1 flex-shrink-0"
                        data-lang-filter="all">Todas <span
                            class="badge text-bg-primary-subtle text-primary ms-1"><?= count($versions) ?></span></button>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 flex-shrink-0"
                        data-lang-filter="pt">Português <span
                            class="badge text-bg-secondary ms-1"><?= count($langGroups['pt']['versions']) ?></span></button>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 flex-shrink-0"
                        data-lang-filter="en">English <span
                            class="badge text-bg-secondary ms-1"><?= count($langGroups['en']['versions']) ?></span></button>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 flex-shrink-0"
                        data-lang-filter="es">Español <span
                            class="badge text-bg-secondary ms-1"><?= count($langGroups['es']['versions']) ?></span></button>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 flex-shrink-0"
                        data-lang-filter="other">Outros Idiomas <span
                            class="badge text-bg-secondary ms-1"><?= count($langGroups['other']['versions']) ?></span></button>
                </div>
            </div>

            <div class="modal-body p-3" id="modalVersionListBody">
                <div class="list-group gap-1" role="radiogroup" id="modalVersionListGroup">
                    <?php foreach ($langGroups as $groupKey => $groupInfo): ?>
                        <div class="version-group-section mb-3" data-group-section="<?= $groupKey ?>">
                            <div
                                class="version-group-header d-flex align-items-center justify-content-between px-1 pt-1 pb-1 mb-2 border-bottom">
                                <span class="d-flex align-items-center gap-2">
                                    <span
                                        class="badge <?= $groupInfo['badge'] ?> px-2 py-1"><?= htmlspecialchars($groupInfo['title']) ?></span>
                                    <span class="text-muted small fw-normal">(<?= count($groupInfo['versions']) ?>
                                        versões)</span>
                                </span>
                            </div>

                            <?php foreach ($groupInfo['versions'] as $v): ?>
                                <?php
                                $lang = strtolower($v->language);
                                $groupType = in_array($lang, ['pt', 'en', 'es'], true) ? $lang : 'other';
                                $searchHaystack = mb_strtolower("{$v->code} {$v->name} {$v->language} " . $v->getLanguageName(), 'UTF-8');
                                ?>
                                <label
                                    class="version-option-card list-group-item list-group-item-action d-flex align-items-center justify-content-between p-2.5 rounded-3 border cursor-pointer user-select-none mb-1.5"
                                    data-version-id="<?= $v->id ?>" data-version-code="<?= htmlspecialchars($v->code) ?>"
                                    data-version-name="<?= htmlspecialchars($v->name) ?>"
                                    data-version-lang="<?= htmlspecialchars(strtoupper($v->language)) ?>"
                                    data-lang="<?= $lang ?>" data-group="<?= $groupType ?>"
                                    data-search="<?= htmlspecialchars($searchHaystack) ?>">
                                    <div class="d-flex align-items-center gap-2.5 overflow-hidden flex-grow-1">
                                        <div class="form-check m-0 p-0 d-flex align-items-center pe-2">
                                            <input class="form-check-input version-radio-input fs-5 m-0 cursor-pointer"
                                                type="radio" name="modal_version_radio" value="<?= $v->id ?>"
                                                id="modal_v_radio_<?= $v->id ?>">
                                        </div>
                                        <span
                                            class="badge bg-primary-subtle text-primary border border-primary-subtle font-monospace fw-bold px-2 py-1 fs-6 flex-shrink-0 version-pill-code">
                                            <?= htmlspecialchars($v->code) ?>
                                        </span>
                                        <div class="text-truncate ms-3">
                                            <div class="fw-semibold text-truncate text-body version-card-title">
                                                <?= htmlspecialchars($v->name) ?></div>
                                            <div class="small text-muted text-truncate version-card-subtitle">
                                                <?= htmlspecialchars($v->getLanguageName()) ?>
                                                <?php if (in_array($v->id, [9, 73], true)): ?>
                                                    &bull; <span
                                                        class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle py-0 px-1">73
                                                        livros</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 ms-2 flex-shrink-0">
                                        <span
                                            class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill px-2.5 py-1 text-uppercase fw-medium">
                                            <?= htmlspecialchars($v->language) ?>
                                        </span>
                                        <i class="bi bi-check-circle-fill text-primary fs-5 check-icon-active d-none"></i>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="no-version-found-msg" class="alert alert-warning text-center my-4 d-none">
                    <i class="bi bi-search fs-3 d-block mb-2"></i>
                    Nenhuma versão encontrada com o termo pesquisado.
                </div>
            </div>

            <div class="modal-footer border-top bg-body-tertiary py-2 px-3 justify-content-between">
                <span class="small text-muted" id="versionCounterInfo"><?= count($versions) ?> versões
                    disponíveis</span>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-sm btn-primary px-3" id="modalConfirmVersionBtn">
                        <i class="bi bi-check2 me-1"></i> Selecionar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>