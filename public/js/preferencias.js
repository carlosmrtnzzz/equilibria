document.addEventListener('DOMContentLoaded', () => {
    const abrirIntoleranciasBtn = document.getElementById('abrirIntrolerancias');
    const modalIntolerancias = document.getElementById('modalIntolerancias');
    const cancelarPreferenciasBtn = document.getElementById('cancelarPreferenciasBtn');
    const formPreferencias = document.getElementById('formPreferencias');

    abrirIntoleranciasBtn.addEventListener('click', async () => {
        try {
            const res = await fetch('/preferences');
            const data = await res.json();

            document.getElementById('is_celiac').checked = data?.is_celiac ?? false;
            document.getElementById('is_lactose_intolerant').checked = data?.is_lactose_intolerant ?? false;
            document.getElementById('is_fructose_intolerant').checked = data?.is_fructose_intolerant ?? false;
            document.getElementById('is_histamine_intolerant').checked = data?.is_histamine_intolerant ?? false;
            document.getElementById('is_sorbitol_intolerant').checked = data?.is_sorbitol_intolerant ?? false;
            document.getElementById('is_casein_intolerant').checked = data?.is_casein_intolerant ?? false;
            document.getElementById('is_egg_intolerant').checked = data?.is_egg_intolerant ?? false;

            modalIntolerancias.classList.remove('hidden');
        } catch (e) {
            console.error('Error al cargar preferencias:', e);
            mostrarToast('Error al cargar tus preferencias.');
        }
    });

    cancelarPreferenciasBtn.addEventListener('click', () => {
        modalIntolerancias.classList.add('hidden');
    });

    formPreferencias.addEventListener('submit', async (e) => {
        e.preventDefault();

        const payload = {
            is_celiac: document.getElementById('is_celiac').checked,
            is_lactose_intolerant: document.getElementById('is_lactose_intolerant').checked,
            is_fructose_intolerant: document.getElementById('is_fructose_intolerant').checked,
            is_histamine_intolerant: document.getElementById('is_histamine_intolerant').checked,
            is_sorbitol_intolerant: document.getElementById('is_sorbitol_intolerant').checked,
            is_casein_intolerant: document.getElementById('is_casein_intolerant').checked,
            is_egg_intolerant: document.getElementById('is_egg_intolerant').checked
        };

        try {
            const res = await fetch('/preferences', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            });

            const data = await res.json();
            if (data.success) {
                mostrarToast('Preferencias guardadas correctamente.');
                modalIntolerancias.classList.add('hidden');
            } else {
                mostrarToast('No se pudieron guardar las preferencias.');
            }
        } catch (e) {
            console.error('Error guardando preferencias:', e);
            mostrarToast('Error al guardar las preferencias.');
        }
    });
});
