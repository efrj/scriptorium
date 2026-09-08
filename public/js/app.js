/**
 * Holy Bible Yii 3 - Application JavaScript
 */

document.addEventListener('DOMContentLoaded', () => {
    initTheme();
    initFontSize();
    initBookChapterSelector();
    initVerseNavigation();
    initVersionModalPicker();
    initBookModalPicker();
});

// 1. Theme Management (Light, Sepia, Dark)
function initTheme() {
    const savedTheme = localStorage.getItem('bible_theme') || 'light';
    setTheme(savedTheme);

    const themeButtons = document.querySelectorAll('[data-theme-btn]');
    themeButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const theme = btn.getAttribute('data-theme-btn');
            setTheme(theme);
        });
    });
}

function setTheme(theme) {
    document.documentElement.setAttribute('data-bs-theme', theme);
    localStorage.setItem('bible_theme', theme);

    document.querySelectorAll('[data-theme-btn]').forEach(btn => {
        if (btn.getAttribute('data-theme-btn') === theme) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });
}

// 2. Font Size Adjustment
function initFontSize() {
    const savedSize = localStorage.getItem('bible_font_size') || '1.15';
    setFontSize(parseFloat(savedSize));

    const btnDecrease = document.getElementById('btn-font-decrease');
    const btnIncrease = document.getElementById('btn-font-increase');
    const btnReset = document.getElementById('btn-font-reset');

    if (btnDecrease) {
        btnDecrease.addEventListener('click', () => {
            let current = parseFloat(localStorage.getItem('bible_font_size') || '1.15');
            if (current > 0.85) setFontSize(current - 0.1);
        });
    }

    if (btnIncrease) {
        btnIncrease.addEventListener('click', () => {
            let current = parseFloat(localStorage.getItem('bible_font_size') || '1.15');
            if (current < 2.0) setFontSize(current + 0.1);
        });
    }

    if (btnReset) {
        btnReset.addEventListener('click', () => {
            setFontSize(1.15);
        });
    }
}

function setFontSize(remValue) {
    remValue = Math.round(remValue * 100) / 100;
    document.documentElement.style.setProperty('--reader-font-size', remValue + 'rem');
    localStorage.setItem('bible_font_size', remValue.toString());
}

// 3. Dynamic Book -> Chapter dropdown updates
function initBookChapterSelector() {
    const bookSelect = document.getElementById('select-book');
    const chapterSelect = document.getElementById('select-chapter');

    if (!bookSelect || !chapterSelect) return;

    bookSelect.addEventListener('change', async () => {
        const selectedOption = bookSelect.options[bookSelect.selectedIndex];
        const chaptersCount = parseInt(selectedOption.getAttribute('data-chapters') || '50', 10);
        
        chapterSelect.innerHTML = '';
        for (let c = 1; c <= chaptersCount; c++) {
            const opt = document.createElement('option');
            opt.value = c;
            opt.textContent = `Capítulo ${c}`;
            chapterSelect.appendChild(opt);
        }
    });
}

// 4. Verse click / copy / highlight
function initVerseNavigation() {
    const verseSelect = document.getElementById('select-verse');
    if (verseSelect) {
        verseSelect.addEventListener('change', () => {
            const vNum = verseSelect.value;
            if (vNum) {
                const target = document.getElementById('v-' + vNum);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    highlightElement(target);
                }
            }
        });
    }

    // Copy verse button
    document.querySelectorAll('.btn-copy-verse').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const text = btn.getAttribute('data-text');
            const ref = btn.getAttribute('data-ref');
            const full = `"${text}" - ${ref}`;

            navigator.clipboard.writeText(full).then(() => {
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-check text-success"></i>';
                setTimeout(() => { btn.innerHTML = originalHtml; }, 2000);
            });
        });
    });
}

function highlightElement(el) {
    document.querySelectorAll('.verse-item.highlighted').forEach(item => item.classList.remove('highlighted'));
    el.classList.add('highlighted');
}

// 5. Modal Version Picker with Live Search, Tabs, and Radio Selection
function initVersionModalPicker() {
    const modalEl = document.getElementById('versionPickerModal');
    if (!modalEl) return;

    const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
    const searchInput = document.getElementById('modalVersionSearch');
    const clearSearchBtn = document.getElementById('modalVersionClearSearch');
    const listBody = document.getElementById('modalVersionListBody');
    const optionCards = document.querySelectorAll('.version-option-card');
    const filterPills = document.querySelectorAll('[data-lang-filter]');
    const noResultMsg = document.getElementById('no-version-found-msg');
    const counterInfo = document.getElementById('versionCounterInfo');
    const confirmBtn = document.getElementById('modalConfirmVersionBtn');

    let currentTargetInputId = null;
    let currentTriggerBtn = null;
    let shouldAutoSubmit = true;
    let selectedVersionId = null;
    let activeLangFilter = 'all';

    // When any trigger button is clicked
    document.querySelectorAll('.version-picker-trigger').forEach(btn => {
        btn.addEventListener('click', () => {
            currentTriggerBtn = btn;
            currentTargetInputId = btn.getAttribute('data-target-input');
            shouldAutoSubmit = btn.getAttribute('data-auto-submit') === 'true';

            const targetInput = document.getElementById(currentTargetInputId);
            selectedVersionId = targetInput ? targetInput.value : null;

            updateSelectedRadio(selectedVersionId);
        });
    });

    function updateSelectedRadio(versionId) {
        optionCards.forEach(card => {
            const cardVersionId = card.getAttribute('data-version-id');
            const radio = card.querySelector('.version-radio-input');
            const isSelected = cardVersionId === String(versionId);

            if (isSelected) {
                card.classList.add('selected');
                if (radio) radio.checked = true;
            } else {
                card.classList.remove('selected');
                if (radio) radio.checked = false;
            }
        });
    }

    // Modal Lifecycle events
    modalEl.addEventListener('show.bs.modal', () => {
        if (searchInput) {
            searchInput.value = '';
        }
        if (clearSearchBtn) {
            clearSearchBtn.classList.add('d-none');
        }
        activeLangFilter = 'all';
        filterPills.forEach(pill => {
            if (pill.getAttribute('data-lang-filter') === 'all') {
                pill.classList.add('active');
            } else {
                pill.classList.remove('active');
            }
        });
        filterList();
    });

    modalEl.addEventListener('shown.bs.modal', () => {
        if (searchInput) {
            searchInput.focus();
        }
        // Scroll selected item into view
        const selectedCard = document.querySelector('.version-option-card.selected');
        if (selectedCard && listBody) {
            selectedCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    // Filter cards by search keyword + language pill
    function filterList() {
        const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
        let visibleCount = 0;

        optionCards.forEach(card => {
            const group = card.getAttribute('data-group');
            const lang = card.getAttribute('data-lang');
            const searchData = card.getAttribute('data-search') || '';

            const matchesLang = (activeLangFilter === 'all') ||
                                (activeLangFilter === 'pt' && lang === 'pt') ||
                                (activeLangFilter === 'en' && lang === 'en') ||
                                (activeLangFilter === 'es' && lang === 'es') ||
                                (activeLangFilter === 'other' && group === 'other');

            const matchesSearch = !query || searchData.includes(query);

            if (matchesLang && matchesSearch) {
                card.classList.remove('d-none');
                visibleCount++;
            } else {
                card.classList.add('d-none');
            }
        });

        // Toggle visibility of group sections based on visible cards
        const groupSections = document.querySelectorAll('.version-group-section');
        groupSections.forEach(section => {
            const visibleInGroup = section.querySelectorAll('.version-option-card:not(.d-none)').length;
            if (visibleInGroup === 0) {
                section.classList.add('d-none');
            } else {
                section.classList.remove('d-none');
            }
        });

        if (noResultMsg) {
            if (visibleCount === 0) {
                noResultMsg.classList.remove('d-none');
            } else {
                noResultMsg.classList.add('d-none');
            }
        }

        if (counterInfo) {
            counterInfo.textContent = `${visibleCount} versão(ões) listada(s)`;
        }

        if (clearSearchBtn) {
            if (query.length > 0) {
                clearSearchBtn.classList.remove('d-none');
            } else {
                clearSearchBtn.classList.add('d-none');
            }
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterList);
        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                const firstVisible = document.querySelector('.version-option-card:not(.d-none)');
                if (firstVisible) {
                    selectCardAndApply(firstVisible);
                }
            }
        });
    }

    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', () => {
            if (searchInput) {
                searchInput.value = '';
                searchInput.focus();
                filterList();
            }
        });
    }

    // Language pills filter
    filterPills.forEach(pill => {
        pill.addEventListener('click', () => {
            filterPills.forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
            activeLangFilter = pill.getAttribute('data-lang-filter');
            filterList();
        });
    });

    // Selecting a card
    function selectCardAndApply(card) {
        const vId = card.getAttribute('data-version-id');
        const vCode = card.getAttribute('data-version-code');
        const vName = card.getAttribute('data-version-name');
        const vLang = card.getAttribute('data-version-lang');

        selectedVersionId = vId;
        updateSelectedRadio(vId);

        if (currentTargetInputId) {
            const targetInput = document.getElementById(currentTargetInputId);
            if (targetInput) {
                targetInput.value = vId;
            }
        }

        if (currentTriggerBtn) {
            const codeBadge = currentTriggerBtn.querySelector('.version-badge-code');
            const nameSpan = currentTriggerBtn.querySelector('.version-btn-name');
            const langBadge = currentTriggerBtn.querySelector('.version-btn-lang');

            if (codeBadge) codeBadge.textContent = vCode;
            if (nameSpan) nameSpan.textContent = vName;
            if (langBadge) langBadge.textContent = vLang;
        }

        modalInstance.hide();

        if (shouldAutoSubmit && currentTargetInputId) {
            const targetInput = document.getElementById(currentTargetInputId);
            if (targetInput && targetInput.form) {
                targetInput.form.submit();
            }
        }
    }

    optionCards.forEach(card => {
        card.addEventListener('click', () => {
            selectCardAndApply(card);
        });
    });

    if (confirmBtn) {
        confirmBtn.addEventListener('click', () => {
            const selectedCard = document.querySelector('.version-option-card.selected');
            if (selectedCard) {
                selectCardAndApply(selectedCard);
            } else {
                modalInstance.hide();
            }
        });
    }
}

// 6. Modal Book Picker with Live Search, Tabs, and Radio Selection
function initBookModalPicker() {
    const modalEl = document.getElementById('bookPickerModal');
    if (!modalEl) return;

    const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
    const searchInput = document.getElementById('modalBookSearch');
    const clearSearchBtn = document.getElementById('modalBookClearSearch');
    const listBody = document.getElementById('modalBookListBody');
    const optionCards = document.querySelectorAll('.book-option-card');
    const filterPills = document.querySelectorAll('[data-book-filter]');
    const noResultMsg = document.getElementById('no-book-found-msg');
    const counterInfo = document.getElementById('bookCounterInfo');
    const confirmBtn = document.getElementById('modalConfirmBookBtn');

    let currentTargetInputId = null;
    let currentTriggerBtn = null;
    let shouldAutoSubmit = true;
    let selectedBookId = null;
    let activeCategoryFilter = 'all';

    // When any book trigger button is clicked
    document.querySelectorAll('.book-picker-trigger').forEach(btn => {
        btn.addEventListener('click', () => {
            currentTriggerBtn = btn;
            currentTargetInputId = btn.getAttribute('data-target-input');
            shouldAutoSubmit = btn.getAttribute('data-auto-submit') === 'true';

            const targetInput = document.getElementById(currentTargetInputId);
            selectedBookId = targetInput ? targetInput.value : null;

            updateSelectedRadio(selectedBookId);
        });
    });

    function updateSelectedRadio(bookId) {
        optionCards.forEach(card => {
            const cardBookId = card.getAttribute('data-book-id');
            const radio = card.querySelector('.book-radio-input');
            const isSelected = cardBookId === String(bookId);

            if (isSelected) {
                card.classList.add('selected');
                if (radio) radio.checked = true;
            } else {
                card.classList.remove('selected');
                if (radio) radio.checked = false;
            }
        });
    }

    // Modal Lifecycle events
    modalEl.addEventListener('show.bs.modal', () => {
        if (searchInput) {
            searchInput.value = '';
        }
        if (clearSearchBtn) {
            clearSearchBtn.classList.add('d-none');
        }
        activeCategoryFilter = 'all';
        filterPills.forEach(pill => {
            if (pill.getAttribute('data-book-filter') === 'all') {
                pill.classList.add('active');
            } else {
                pill.classList.remove('active');
            }
        });
        filterBookList();
    });

    modalEl.addEventListener('shown.bs.modal', () => {
        if (searchInput) {
            searchInput.focus();
        }
        const selectedCard = document.querySelector('.book-option-card.selected');
        if (selectedCard && listBody) {
            selectedCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    // Filter cards by search keyword + category pill
    function filterBookList() {
        const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
        let visibleCount = 0;

        optionCards.forEach(card => {
            const group = card.getAttribute('data-group');
            const searchData = card.getAttribute('data-search') || '';

            const matchesCategory = (activeCategoryFilter === 'all') || (activeCategoryFilter === group);
            const matchesSearch = !query || searchData.includes(query);

            const colItem = card.closest('.book-col-item') || card;

            if (matchesCategory && matchesSearch) {
                colItem.classList.remove('d-none');
                visibleCount++;
            } else {
                colItem.classList.add('d-none');
            }
        });

        // Toggle visibility of group sections based on visible cards
        const groupSections = document.querySelectorAll('.book-group-section');
        groupSections.forEach(section => {
            const visibleInGroup = section.querySelectorAll('.book-col-item:not(.d-none)').length;
            if (visibleInGroup === 0) {
                section.classList.add('d-none');
            } else {
                section.classList.remove('d-none');
            }
        });

        if (noResultMsg) {
            if (visibleCount === 0) {
                noResultMsg.classList.remove('d-none');
            } else {
                noResultMsg.classList.add('d-none');
            }
        }

        if (counterInfo) {
            counterInfo.textContent = `${visibleCount} livro(s) listado(s)`;
        }

        if (clearSearchBtn) {
            if (query.length > 0) {
                clearSearchBtn.classList.remove('d-none');
            } else {
                clearSearchBtn.classList.add('d-none');
            }
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterBookList);
        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                const firstVisible = document.querySelector('.book-col-item:not(.d-none) .book-option-card');
                if (firstVisible) {
                    selectBookAndApply(firstVisible);
                }
            }
        });
    }

    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', () => {
            if (searchInput) {
                searchInput.value = '';
                searchInput.focus();
                filterBookList();
            }
        });
    }

    // Category pills filter
    filterPills.forEach(pill => {
        pill.addEventListener('click', () => {
            filterPills.forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
            activeCategoryFilter = pill.getAttribute('data-book-filter');
            filterBookList();
        });
    });

    // Selecting a book card
    function selectBookAndApply(card) {
        const bId = card.getAttribute('data-book-id');
        const bName = card.getAttribute('data-book-name');
        const bAbbr = card.getAttribute('data-book-abbr');
        const bChapters = parseInt(card.getAttribute('data-book-chapters') || '50', 10);

        selectedBookId = bId;
        updateSelectedRadio(bId);

        if (currentTargetInputId) {
            const targetInput = document.getElementById(currentTargetInputId);
            if (targetInput) {
                targetInput.value = bId;
            }
        }

        if (currentTriggerBtn) {
            const abbrBadge = currentTriggerBtn.querySelector('.book-badge-abbr');
            const nameSpan = currentTriggerBtn.querySelector('.book-btn-name');
            const chapBadge = currentTriggerBtn.querySelector('.book-btn-chapters');

            if (abbrBadge) abbrBadge.textContent = bAbbr;
            if (nameSpan) nameSpan.textContent = bName;
            if (chapBadge) chapBadge.textContent = `${bChapters} caps`;
        }

        // Adjust chapter selector if present
        const chapterSelect = document.getElementById('select-chapter');
        if (chapterSelect) {
            const currentChapVal = parseInt(chapterSelect.value || '1', 10);
            chapterSelect.innerHTML = '';
            for (let c = 1; c <= bChapters; c++) {
                const opt = document.createElement('option');
                opt.value = c;
                opt.textContent = `Capítulo ${c}`;
                chapterSelect.appendChild(opt);
            }
            if (currentChapVal <= bChapters) {
                chapterSelect.value = currentChapVal;
            } else {
                chapterSelect.value = 1;
            }
        }

        modalInstance.hide();

        if (shouldAutoSubmit && currentTargetInputId) {
            const targetInput = document.getElementById(currentTargetInputId);
            if (targetInput && targetInput.form) {
                targetInput.form.submit();
            }
        }
    }

    optionCards.forEach(card => {
        card.addEventListener('click', () => {
            selectBookAndApply(card);
        });
    });

    if (confirmBtn) {
        confirmBtn.addEventListener('click', () => {
            const selectedCard = document.querySelector('.book-option-card.selected');
            if (selectedCard) {
                selectBookAndApply(selectedCard);
            } else {
                modalInstance.hide();
            }
        });
    }
}
