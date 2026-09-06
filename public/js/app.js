/**
 * Holy Bible Yii 3 - Application JavaScript
 */

document.addEventListener('DOMContentLoaded', () => {
    initTheme();
    initFontSize();
    initBookChapterSelector();
    initVerseNavigation();
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
