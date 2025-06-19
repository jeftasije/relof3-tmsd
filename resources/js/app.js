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
    };

    toggleButtons.forEach(button => button.addEventListener('click', toggleTheme));
});
