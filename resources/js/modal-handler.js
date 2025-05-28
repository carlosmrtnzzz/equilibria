document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('edit-modal');
    const openBtn = document.getElementById('edit-profile-btn');
    const closeBtn = document.getElementById('close-modal');

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('flex')) {
            modal.classList.replace('flex', 'hidden');
        }
    });

    if (!modal || !openBtn || !closeBtn) return;

    openBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    });

    closeBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });
});
