import './bootstrap';
import 'flowbite';
import "flag-icons/css/flag-icons.min.css";
import Sortable from 'sortablejs';

window.Sortable = Sortable;

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Helper funkcija za validnu font-family vrednost
function fontStack(font) {
    // Ako već ima sans-serif ili serif, koristi kako jeste (ali makni navodnike)
    if (font.includes('serif')) return font.replace(/["']/g, '');
    // Ako ima razmak, okruži sa navodnicima i dodaj sans-serif fallback
    if (font.includes(' ')) return `'${font}', sans-serif`;
    // Ako nema razmaka, samo dodaj sans-serif
    return `${font}, sans-serif`;
}

window.palettes = {};
window.fontPalettes = {};
window.activePalette = localStorage.getItem('palette') || 'default';
window.activeMode = localStorage.getItem('color-theme') || 'light';
window.activeFontPalette = localStorage.getItem('font-palette') || 'default';
let selectedPalette = window.activePalette;
let selectedMode = window.activeMode;
let selectedFontPalette = window.activeFontPalette;

// ---------- pallets ----------

document.addEventListener('DOMContentLoaded', () => {
    const darkIcons = document.querySelectorAll('#theme-toggle-dark-icon, #theme-toggle-dark-icon-mobile');
    const lightIcons = document.querySelectorAll('#theme-toggle-light-icon, #theme-toggle-light-icon-mobile');
    const toggleButtons = document.querySelectorAll('#theme-toggle, #theme-toggle-mobile');

    const isDark = localStorage.getItem('color-theme') === 'dark' ||
        (!localStorage.getItem('color-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);

    document.documentElement.classList.toggle('dark', isDark);
    darkIcons.forEach(icon => icon.classList.toggle('hidden', isDark));
    lightIcons.forEach(icon => icon.classList.toggle('hidden', !isDark));

    const toggleTheme = () => {
        const isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('color-theme', isDark ? 'dark' : 'light');
        darkIcons.forEach(icon => icon.classList.toggle('hidden', isDark));
        lightIcons.forEach(icon => icon.classList.toggle('hidden', !isDark));
        if (window.setPaletteMode) {
            setPaletteMode(isDark ? 'dark' : 'light');
        }
    };
    toggleButtons.forEach(button => button.addEventListener('click', toggleTheme));

    fetch('/themes/palettes.json')
        .then(res => res.json())
        .then(data => {
            window.palettes = data.palettes;
            applyPalette();
            renderPaletteList();
            renderPalettePreview();
            setupSidebarPreviewTheme();
        });

    const titleFontsPromise = fetch('/tipography/title.json').then(res => res.json());
    const descFontsPromise = fetch('/tipography/description.json').then(res => res.json());

    Promise.all([titleFontsPromise, descFontsPromise])
        .then(([titleFonts, descFonts]) => {
            window.fontPalettes = {
                title: titleFonts.fonts,
                desc: descFonts.fonts
            };
            renderFontPreview?.();
        });
});

window.setPalette = function(paletteName) {
    window.activePalette = paletteName;
    localStorage.setItem('palette', paletteName);
    applyPalette();
    renderPaletteList();
    renderPalettePreview();
};
window.setPaletteMode = function(mode) {
    window.activeMode = mode;
    localStorage.setItem('color-theme', mode);
    applyPalette();
};

function applyPalette() {
    if (!palettes[activePalette] || !palettes[activePalette][activeMode]) return;
    const theme = palettes[activePalette][activeMode];
    for (const [key, value] of Object.entries(theme)) {
        document.documentElement.style.setProperty(`--${key.replace(/[A-Z]/g, m => '-' + m.toLowerCase())}`, value);
    }
    const isDark = activeMode === 'dark';
    const darkIcons = document.querySelectorAll('#theme-toggle-dark-icon, #theme-toggle-dark-icon-mobile');
    const lightIcons = document.querySelectorAll('#theme-toggle-light-icon, #theme-toggle-light-icon-mobile');
    darkIcons.forEach(icon => icon.classList.toggle('hidden', isDark));
    lightIcons.forEach(icon => icon.classList.toggle('hidden', !isDark));
}

window.renderPaletteList = function() {
    const list = document.getElementById('palette-list');
    if (!list) return;
    list.innerHTML = '';
    Object.entries(palettes).forEach(([key, palette]) => {
        const light = palette.light || {};
        const colors = [
            light.primaryBg || '#fff',
            light.accent || '#22c55e',
            light.primaryText || '#1f2937',
            light.secondaryText || '#64748b'
        ];
        const card = document.createElement('div');
        card.className = 'flex items-center justify-between p-4 mb-3 rounded-xl shadow border cursor-pointer transition-all duration-150 ' +
            (key === selectedPalette ? 'border-2 border-green-500 bg-gray-100 dark:bg-gray-700' : 'border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800');
        card.onclick = () => {
            selectedPalette = key;
            renderPaletteList();
            renderPalettePreview();
            document.getElementById('palette-save-btn').disabled = (selectedPalette === activePalette && selectedMode === activeMode);
        };
        const name = document.createElement('span');
        name.className = 'font-semibold text-lg';
        name.textContent = palette.label || key;
        const colorsWrap = document.createElement('span');
        colorsWrap.className = 'flex flex-row gap-2 ml-3';
        colors.forEach(c => {
            const circle = document.createElement('span');
            circle.style.width = "24px";
            circle.style.height = "24px";
            circle.style.borderRadius = "50%";
            circle.style.background = c;
            circle.style.display = "inline-block";
            circle.style.border = "1.5px solid #cbd5e1";
            colorsWrap.appendChild(circle);
        });
        card.appendChild(name);
        card.appendChild(colorsWrap);
        list.appendChild(card);
    });
    document.getElementById('palette-save-btn').disabled = (selectedPalette === activePalette && selectedMode === activeMode);
}

window.renderPalettePreview = function() {
    const preview = document.getElementById('palette-preview');
    if (!preview) return;
    const theme = palettes[selectedPalette]?.[selectedMode];
    preview.innerHTML = `
      <div style="
        background: ${theme.primaryBg}; 
        color: ${theme.primaryText}; 
        border-bottom: 2px solid ${theme.accent};
        border-radius: 1.5rem 1.5rem 0 0;
        padding: 28px 24px 12px 24px;
        ">
        <div class="font-bold text-xl mb-1" style="color:${theme.primaryText};font-family:var(--font-title);">Naslov teme</div>
        <div class="mb-3 text-base" style="color:${theme.secondaryText};font-family:var(--font-body);">
            Ovo je prikaz vaše teme. Ovde će biti prikazani naslovi, tekstovi i akcione boje.
        </div>
        <button class="rounded-xl px-4 py-2 font-semibold" style="background:${theme.accent};color:#fff;">
            Akcija
        </button>
      </div>
      <div class="w-full" style="height:32px; background:${theme.secondaryText};"></div>
    `;
};

function setupSidebarPreviewTheme() {
    const btnLight = document.getElementById('sidebar-preview-light');
    const btnDark = document.getElementById('sidebar-preview-dark');
    if (btnLight) btnLight.onclick = () => {
        selectedMode = 'light';
        renderPaletteList();
        renderPalettePreview();
        document.getElementById('palette-save-btn').disabled = (selectedPalette === activePalette && selectedMode === activeMode);
    };
    if (btnDark) btnDark.onclick = () => {
        selectedMode = 'dark';
        renderPaletteList();
        renderPalettePreview();
        document.getElementById('palette-save-btn').disabled = (selectedPalette === activePalette && selectedMode === activeMode);
    };
}

document.addEventListener('DOMContentLoaded', () => {
    let saveBtn = document.getElementById('palette-save-btn');
    if (saveBtn) {
        saveBtn.onclick = function() {
            if (selectedPalette !== activePalette || selectedMode !== activeMode) {
                window.activePalette = selectedPalette;
                window.activeMode = selectedMode;
                localStorage.setItem('palette', window.activePalette);
                localStorage.setItem('color-theme', window.activeMode);
                applyPalette();
                renderPaletteList();
                renderPalettePreview();
                setupSidebarPreviewTheme();
            }
        };
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const backBtn = document.getElementById('sidebar-back-btn');
    if (backBtn) {
        backBtn.addEventListener('click', () => {
            document.getElementById('color-sidebar').classList.add('-translate-x-full');
        });
    }
});

// ---------- tipography ----------
window.selectedTitleFont = localStorage.getItem('font-title') || 'Inter';
window.selectedDescFont = localStorage.getItem('font-desc') || 'Inter';
let tempTitleFont = window.selectedTitleFont;
let tempDescFont = window.selectedDescFont;

let saveBtn = null;

function updateFontSaveBtnState() {
    if (!saveBtn) saveBtn = document.getElementById('font-save-btn');
    if (!saveBtn) return;
    if (tempTitleFont === window.selectedTitleFont && tempDescFont === window.selectedDescFont) {
        saveBtn.disabled = true;
        saveBtn.classList.add('opacity-60', 'cursor-not-allowed');
    } else {
        saveBtn.disabled = false;
        saveBtn.classList.remove('opacity-60', 'cursor-not-allowed');
    }
}

function renderTitleFontsList(fonts) {
    const list = document.getElementById('title-fonts-list');
    if (!list) return;
    list.innerHTML = '';
    fonts.forEach(font => {
        const card = document.createElement('div');
        card.className =
            'flex items-center p-2 rounded-lg border mb-2 cursor-pointer transition-all text-lg font-bold ' +
            (tempTitleFont === font.family
                ? 'border-green-500 bg-gray-100 dark:bg-gray-700'
                : 'border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800');
        card.style.fontFamily = font.family;
        card.textContent = font.label;
        card.onclick = () => {
            tempTitleFont = font.family;
            renderTitleFontsList(fonts);
            renderFontPreview();
            updateFontSaveBtnState();
        };
        list.appendChild(card);
    });
    updateFontSaveBtnState();
}

function renderDescFontsList(fonts) {
    const list = document.getElementById('desc-fonts-list');
    if (!list) return;
    list.innerHTML = '';
    fonts.forEach(font => {
        const card = document.createElement('div');
        card.className =
            'flex items-center p-2 rounded-lg border mb-2 cursor-pointer transition-all text-base ' +
            (tempDescFont === font.family
                ? 'border-green-500 bg-gray-100 dark:bg-gray-700'
                : 'border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800');
        card.style.fontFamily = font.family;
        card.textContent = font.label;
        card.onclick = () => {
            tempDescFont = font.family;
            renderDescFontsList(fonts);
            renderFontPreview();
            updateFontSaveBtnState();
        };
        list.appendChild(card);
    });
    updateFontSaveBtnState();
}

window.renderFontPreview = function () {
    const previewTitle = document.getElementById('preview-title');
    const previewDesc = document.getElementById('preview-desc');
    if (previewTitle) previewTitle.style.fontFamily = tempTitleFont;
    if (previewDesc) previewDesc.style.fontFamily = tempDescFont;
};

document.addEventListener('DOMContentLoaded', async () => {
    const [titleFonts, descFonts] = await Promise.all([
        fetch('/tipography/title.json').then(res => res.json()),
        fetch('/tipography/description.json').then(res => res.json())
    ]);
    window.titleFonts = titleFonts.fonts;
    window.descFonts = descFonts.fonts;
    renderTitleFontsList(window.titleFonts);
    renderDescFontsList(window.descFonts);
    renderFontPreview();

    saveBtn = document.getElementById('font-save-btn');
    updateFontSaveBtnState();

    if (saveBtn) {
        saveBtn.onclick = function () {
            if (tempTitleFont !== window.selectedTitleFont || tempDescFont !== window.selectedDescFont) {
                window.selectedTitleFont = tempTitleFont;
                window.selectedDescFont = tempDescFont;
                localStorage.setItem('font-title', window.selectedTitleFont);
                localStorage.setItem('font-desc', window.selectedDescFont);
                document.documentElement.style.setProperty('--font-title', fontStack(window.selectedTitleFont));
                document.documentElement.style.setProperty('--font-body', fontStack(window.selectedDescFont));
                updateFontSaveBtnState();
            }
        };
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const titleFont = localStorage.getItem('font-title') || 'Inter';
    const descFont = localStorage.getItem('font-desc') || 'Inter';
    document.documentElement.style.setProperty('--font-title', fontStack(titleFont));
    document.documentElement.style.setProperty('--font-body', fontStack(descFont));
});