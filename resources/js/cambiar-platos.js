document.addEventListener('DOMContentLoaded', () => {
    const chatBox = document.getElementById('chat-box');
    const modal = document.getElementById('modalCambiarPlatos');
    const abrirModalBtn = document.getElementById('abrirModalBtn');
    const cancelarModalBtn = document.getElementById('cancelarModalBtn');
    const contenedorPlatos = document.getElementById('contenedorPlatos');
    const confirmarCambiosBtn = document.getElementById('confirmarCambiosBtn');
    let seleccionados = [];

    abrirModalBtn?.addEventListener('click', async () => {
        const res = await fetch('/chat/plan-actual');
        const data = await res.json();

        const changesLeft = data.changes_left;
        if (changesLeft <= 0) {
            alert("Ya no puedes cambiar más platos. Has agotado tus 3 intentos.");
            return;
        }

        mostrarModalConPlatos(data.meals, changesLeft);
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
        modal.classList.remove('hidden');
        modal.classList.add('flex');
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
        chatBox.innerHTML += `
            <div class="mb-2 text-left text-emerald-700">
                <strong>Equilibria:</strong> He actualizado los platos seleccionados. Te quedan <strong>${data.changes_left}</strong> intento(s).
            </div>`;
        chatBox.scrollTop = chatBox.scrollHeight;

        if (data.changes_left <= 0) {
            abrirModalBtn.disabled = true;
            abrirModalBtn.classList.add('opacity-50', 'cursor-not-allowed');
            abrirModalBtn.title = "Ya has agotado tus 3 cambios.";
        }
    }

    function mostrarErrorServidor(desdeCatch = false) {
        chatBox.innerHTML += `
            <div class="mb-2 text-left text-red-600">
                <strong>Equilibria:</strong> ${desdeCatch ? 'Error al contactar con el servidor.' : 'Hubo un error actualizando los platos.'}
            </div>`;
    }

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
});
