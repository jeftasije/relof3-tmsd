import './bootstrap';
import 'flowbite';
import "flag-icons/css/flag-icons.min.css";
import Sortable from 'sortablejs';

window.Sortable = Sortable;

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

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

    // --- PALETTES LOGIKA ---
    fetch('/themes/palettes.json')
        .then(res => res.json())
        .then(data => {
            window.palettes = data.palettes;
            if (!window.activePalette) window.activePalette = localStorage.getItem('palette') || 'default';
            if (!window.activeMode) window.activeMode = localStorage.getItem('color-theme') || 'light';
            applyPalette();
            renderPaletteList();
        });
});

window.activePalette = localStorage.getItem('palette') || 'default';
window.activeMode = localStorage.getItem('color-theme') || 'light';
window.palettes = {};

window.setPalette = function(paletteName) {
    activePalette = paletteName;
    localStorage.setItem('palette', paletteName);
    applyPalette();
    renderPaletteList();
};

window.setPaletteMode = function(mode) {
    activeMode = mode;
    localStorage.setItem('color-theme', mode);
    applyPalette();
};

function applyPalette() {
    if (!palettes[activePalette] || !palettes[activePalette][activeMode]) return;
    const theme = palettes[activePalette][activeMode];
    for (const [key, value] of Object.entries(theme)) {
        document.documentElement.style.setProperty(`--${key.replace(/[A-Z]/g, m => '-' + m.toLowerCase())}`, value);
    }
}

window.renderPaletteList = function() {
    const list = document.getElementById('palette-list');
    if (!list) return;
    list.innerHTML = '';
    Object.entries(palettes).forEach(([key, palette]) => {
        const light = palette.light || {};
        const dark = palette.dark || {};
        const mode = (window.activeMode === 'dark') ? dark : light;
        const colors = [
            mode.primaryBg || '#fff',
            mode.accent || '#22c55e',
            mode.primaryText || '#1f2937'
        ];
        const card = document.createElement('div');
        card.className = 'palette-card' + (key === activePalette ? ' selected' : '');
        card.onclick = () => setPalette(key);
        card.innerHTML = `
            <div class="palette-circles">
                ${colors.map(c => `<span class="palette-circle" style="background:${c}"></span>`).join('')}
            </div>
            <span class="palette-label">${palette.label || key}</span>
        `;
        list.appendChild(card);
    });
};
