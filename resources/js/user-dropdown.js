document.addEventListener('DOMContentLoaded', () => {
    const userBtn = document.getElementById('user-button');
    const dropdown = document.getElementById('user-dropdown');

    // Mostrar dropdown por click o hover
    if (userBtn && dropdown) {
        userBtn.addEventListener('click', () => dropdown.classList.toggle('hidden'));
        userBtn.addEventListener('mouseenter', () => dropdown.classList.remove('hidden'));
        dropdown.addEventListener('mouseleave', () => dropdown.classList.add('hidden'));
    }

    const toggle = document.getElementById('mobile-menu-toggle');
    const mobileNav = document.getElementById('mobile-nav');

    if (toggle && mobileNav) {
        toggle.addEventListener('click', () => {
            mobileNav.classList.toggle('hidden');
        });
    }
});
