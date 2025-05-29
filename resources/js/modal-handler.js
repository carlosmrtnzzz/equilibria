document.addEventListener('DOMContentLoaded', () => {
    // Modal de edición de perfil
    const modal = document.getElementById('edit-modal');
    const openBtn = document.getElementById('edit-profile-btn');
    const closeBtn = document.getElementById('close-modal');

    if (modal && openBtn && closeBtn) {
        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('flex')) {
                modal.classList.replace('flex', 'hidden');
            }
        });
    }

    // Modal Cambiar Platos
    const btnActualizar = document.getElementById('confirmarCambiosBtn');
    const modalCambiarPlatos = document.getElementById('modalCambiarPlatos');
    if (btnActualizar && modalCambiarPlatos) {
        btnActualizar.addEventListener('click', function () {
            modalCambiarPlatos.classList.add('hidden');
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !modalCambiarPlatos.classList.contains('hidden')) {
                modalCambiarPlatos.classList.add('hidden');
            }
        });
    }

    // Modal Intolerancias
    const formPreferencias = document.getElementById('formPreferencias');
    const modalIntolerancias = document.getElementById('modalIntolerancias');
    if (formPreferencias && modalIntolerancias) {
        formPreferencias.addEventListener('submit', function (e) {
            setTimeout(() => {
                modalIntolerancias.classList.add('hidden');
            }, 200);
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !modalIntolerancias.classList.contains('hidden')) {
                modalIntolerancias.classList.add('hidden');
            }
        });
    }
});