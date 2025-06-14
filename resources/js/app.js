import './bootstrap';
import 'flowbite';
import "flag-icons/css/flag-icons.min.css";

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const darkIcons = document.querySelectorAll('#theme-toggle-dark-icon, #theme-toggle-dark-icon-mobile');
    const lightIcons = document.querySelectorAll('#theme-toggle-light-icon, #theme-toggle-light-icon-mobile');
    const toggleButtons = document.querySelectorAll('#theme-toggle, #theme-toggle-mobile');

    // Initialize theme
    const isDark = localStorage.getItem('color-theme') === 'dark' || 
                   (!localStorage.getItem('color-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);
    
    document.documentElement.classList.toggle('dark', isDark);
    darkIcons.forEach(icon => icon.classList.toggle('hidden', isDark));
    lightIcons.forEach(icon => icon.classList.toggle('hidden', !isDark));

    // Toggle theme
    const toggleTheme = () => {
        const isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('color-theme', isDark ? 'dark' : 'light');
        darkIcons.forEach(icon => icon.classList.toggle('hidden', isDark));
        lightIcons.forEach(icon => icon.classList.toggle('hidden', !isDark));
    };

    toggleButtons.forEach(button => button.addEventListener('click', toggleTheme));
});




document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('[data-collapse-toggle]');
    let activeCollapse = null;

    buttons.forEach(button => {
        const targetId = button.getAttribute('data-collapse-toggle');
        const target = document.getElementById(targetId);
        const arrow = button.querySelector('svg');

        if (target && arrow) {
            button.addEventListener('click', () => {
                // Zatvori sve prethodne collapse sekcije
                if (activeCollapse && activeCollapse !== target) {
                    activeCollapse.classList.add('hidden');
                    const prevButton = document.querySelector(`[data-collapse-toggle="${activeCollapse.id}"]`);
                    if (prevButton) {
                        prevButton.querySelector('svg').classList.remove('rotate-180');
                    }
                }

                // Toggle trenutne sekcije
                const isOpen = !target.classList.contains('hidden');
                target.classList.toggle('hidden');
                arrow.classList.toggle('rotate-180');

                // Ažuriraj aktivnu sekciju
                activeCollapse = isOpen ? null : target;
            });
        }
    });
});



