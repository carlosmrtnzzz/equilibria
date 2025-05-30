document.addEventListener('DOMContentLoaded', () => {
    const abrirIntoleranciasBtn = document.getElementById('abrirIntrolerancias');
    const modalIntolerancias = document.getElementById('modalIntolerancias');
    const cancelarPreferenciasBtn = document.getElementById('cancelarPreferenciasBtn');
    const formPreferencias = document.getElementById('formPreferencias');
    const contenedorChecks = document.getElementById('contenedorChecks');

    abrirIntoleranciasBtn.addEventListener('click', async () => {
        // Mostrar la modal al instante
        modalIntolerancias.classList.remove('hidden');
        modalIntolerancias.classList.add('flex');

        // Mostrar loader/spinner mientras se cargan las preferencias
        if (contenedorChecks) {
            contenedorChecks.innerHTML = `
                <div class="flex justify-center items-center py-10">
                    <svg class="animate-spin h-6 w-6 text-purple-500 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    <span class="text-gray-500">Cargando preferencias...</span>
                </div>
            `;
        }

        try {
            const res = await fetch('/preferences');
            const data = await res.json();

            // Rellenar los checkboxs cuando llegan los datos
            if (contenedorChecks) {
                contenedorChecks.innerHTML = `
                    <label><input type="checkbox" id="is_celiac"> Celiaquía</label>
                    <label><input type="checkbox" id="is_lactose_intolerant"> Intolerancia a la lactosa</label>
                    <label><input type="checkbox" id="is_fructose_intolerant"> Intolerancia a la fructosa</label>
                    <label><input type="checkbox" id="is_histamine_intolerant"> Intolerancia a la histamina</label>
                    <label><input type="checkbox" id="is_sorbitol_intolerant"> Intolerancia al sorbitol</label>
                    <label><input type="checkbox" id="is_casein_intolerant"> Intolerancia a la caseína</label>
                    <label><input type="checkbox" id="is_egg_intolerant"> Intolerancia al huevo</label>
                `;
            }

            document.getElementById('is_celiac').checked = data?.is_celiac ?? false;
            document.getElementById('is_lactose_intolerant').checked = data?.is_lactose_intolerant ?? false;
            document.getElementById('is_fructose_intolerant').checked = data?.is_fructose_intolerant ?? false;
            document.getElementById('is_histamine_intolerant').checked = data?.is_histamine_intolerant ?? false;
            document.getElementById('is_sorbitol_intolerant').checked = data?.is_sorbitol_intolerant ?? false;
            document.getElementById('is_casein_intolerant').checked = data?.is_casein_intolerant ?? false;
            document.getElementById('is_egg_intolerant').checked = data?.is_egg_intolerant ?? false;

        } catch (e) {
            if (contenedorChecks) {
                contenedorChecks.innerHTML = `<div class="text-center text-red-500">Error al cargar tus preferencias.</div>`;
            }
            mostrarToast('Error al cargar tus preferencias.');
        }
    });

    cancelarPreferenciasBtn.addEventListener('click', () => {
        modalIntolerancias.classList.remove('flex');
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
                mostrarToast('No se pudieron guardar las preferencias.', 'info');
            }
        } catch (e) {
            mostrarToast('Error al guardar las preferencias.', 'error');
        }
    });
});
