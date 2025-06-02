document.addEventListener('DOMContentLoaded', () => {
    const chatBox = document.getElementById('chat-box');
    const modal = document.getElementById('modalCambiarPlatos');
    const abrirModalBtn = document.getElementById('abrirModalBtn');
    const cancelarModalBtn = document.getElementById('cancelarModalBtn');
    const contenedorPlatos = document.getElementById('contenedorPlatos');
    const confirmarCambiosBtn = document.getElementById('confirmarCambiosBtn');
    let seleccionados = [];

    abrirModalBtn?.addEventListener('click', async () => {
        // Mostrar la modal al instante
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Mostrar loader/spinner mientras se cargan los platos
        contenedorPlatos.innerHTML = `
            <div class="col-span-full flex justify-center items-center py-10">
                <svg class="animate-spin h-6 w-6 text-emerald-500 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
                <span class="text-gray-500">Cargando platos...</span>
            </div>
        `;

        try {
            const res = await fetch('/chat/plan-actual');
            const data = await res.json();

            if (!data.meals || Object.keys(data.meals).length === 0) {
                contenedorPlatos.innerHTML = `
                    <div class="col-span-full text-center text-gray-600">
                        Aún no hay platos. Genera un plan primero para poder hacer cambios.
                    </div>`;
                return;
            }

            const changesLeft = data.changes_left;
            if (changesLeft <= 0) {
                mostrarToast("Ya no puedes cambiar más platos. Has agotado tus 3 cambios.", "error");
                modal.classList.add('hidden');
                return;
            }

            mostrarModalConPlatos(data.meals, changesLeft);
        } catch (e) {
            contenedorPlatos.innerHTML = `
                <div class="col-span-full text-center text-red-500">
                    Error al conectar con el servidor. Inténtalo de nuevo más tarde.
                </div>`;
        }
    });

    cancelarModalBtn?.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    confirmarCambiosBtn?.addEventListener('click', async () => {
        if (seleccionados.length === 0) {
            mostrarToast('Selecciona al menos 1 plato.', 'error');
            return;
        }

        const platos = seleccionados.map(p => ({ dia: p.dia, tipo: p.tipo }));
        const tempId = 'cambio-spinner';

        chatBox.innerHTML += crearSpinnerHTML(tempId);
        chatBox.scrollTop = chatBox.scrollHeight;

        try {
            const res = await fetch('/plan/reemplazar-platos', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ platos })
            });

            const data = await res.json();
            document.getElementById(tempId)?.remove();

            if (data.success) {
                manejarExito(data);
            } else {
                mostrarErrorServidor();
            }

            if (data.logros?.length) {
                data.logros.forEach(msg => mostrarToast(msg));
            }

        } catch {
            document.getElementById(tempId)?.remove();
            modal.classList.add('hidden');
            mostrarErrorServidor(true);
        }
    });

    function mostrarModalConPlatos(meals, changesLeft) {
        contenedorPlatos.innerHTML = '';
        seleccionados = [];

        let idCounter = 0;
        Object.entries(meals).forEach(([dia, comidas]) => {
            Object.entries(comidas).forEach(([tipo, plato]) => {
                const id = `plato-${idCounter++}`;
                const div = crearPlatoCaja(dia, tipo, plato, id, changesLeft);
                contenedorPlatos.appendChild(div);
            });
        });
    }

    function crearPlatoCaja(dia, tipo, plato, id, changesLeft) {
        const div = document.createElement('div');
        div.className = 'plato-caja';
        div.innerHTML = `<strong>${capitalize(dia)}</strong> - (${capitalize(tipo)}): ${plato}`;
        div.dataset.dia = dia;
        div.dataset.tipo = tipo;
        div.dataset.plato = plato;
        div.id = id;

        div.addEventListener('click', () => {
            if (div.classList.contains('seleccionado')) {
                div.classList.remove('seleccionado');
                seleccionados = seleccionados.filter(p => p.id !== id);
            } else if (seleccionados.length < changesLeft) {
                div.classList.add('seleccionado');
                seleccionados.push({ dia, tipo, plato, id });
            }
        });

        return div;
    }

    function crearSpinnerHTML(id) {
        return `
            <div id="${id}" class="mb-2 text-left flex items-center gap-2 text-gray-500 italic">
                <div class="dot-spinner">
                    ${'<div class="dot-spinner__dot"></div>'.repeat(8)}
                </div>
                Actualizando platos seleccionados...
            </div>`;
    }

    function manejarExito(data) {
        modal.classList.add('hidden');

        const div = document.createElement('div');
        div.className = 'mb-2 text-left';
        div.innerHTML = `
        <div class="inline-block rounded-lg bg-gradient-to-r from-emerald-500 to-teal-500 p-4 text-white shadow-lg">
            <strong class="text-emerald-50">Equilibria:</strong>
            <p class="mt-1">He actualizado los platos seleccionados. Te queda(n) <strong>${data.changes_left}</strong> cambio(s).</p>
        </div>
    `;
        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;

        if (data.changes_left <= 0) {
            abrirModalBtn.disabled = true;
            abrirModalBtn.classList.add('opacity-50', 'cursor-not-allowed');
            abrirModalBtn.title = "Ya has agotado tus 3 cambios.";
        }
    }


    function mostrarErrorServidor(desdeCatch = false) {
        const div = document.createElement('div');
        div.className = 'mb-2 text-left';
        div.innerHTML = `
        <div class="inline-block rounded-lg bg-red-100 border border-red-300 p-4 text-red-800 shadow-lg">
            <strong class="text-red-700">Equilibria:</strong>
            <p class="mt-1">${desdeCatch ? 'Error al contactar con el servidor.' : 'Hubo un error actualizando los platos.'}</p>
        </div>
    `;
        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }


    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
});
