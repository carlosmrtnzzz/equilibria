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

        modal.classList.remove('hidden');
        contenedorPlatos.innerHTML = '';
        seleccionados = [];
        const meals = data.meals;
        let idCounter = 0;

        Object.entries(meals).forEach(([dia, comidas]) => {
            Object.entries(comidas).forEach(([tipo, plato]) => {
                const id = `plato-${idCounter++}`;
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

                contenedorPlatos.appendChild(div);
            });
        });
    });

    cancelarModalBtn?.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    confirmarCambiosBtn?.addEventListener('click', async () => {
        if (seleccionados.length === 0) {
            mostrarToast('Selecciona al menos 1 plato.');
            return;
        }

        const platos = seleccionados.map(p => ({
            dia: p.dia,
            tipo: p.tipo
        }));

        const tempId = 'cambio-spinner';
        chatBox.innerHTML += `
            <div id="${tempId}" class="mb-2 text-left flex items-center gap-2 text-gray-500 italic">
            <div class="dot-spinner">
            <div class="dot-spinner__dot"></div><div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div><div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div><div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div><div class="dot-spinner__dot"></div>
            </div>
            Actualizando platos seleccionados...
            </div>`;
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
            } else {
                modal.classList.add('hidden');
                chatBox.innerHTML += `
                    <div class="mb-2 text-left text-red-600">
                    <strong>Equilibria:</strong> Hubo un error actualizando los platos.
                    </div>`;
            }

            if (data.logros && data.logros.length > 0) {
                data.logros.forEach(msg => mostrarToast(msg));
            }

        } catch (e) {
            console.error(e);
            document.getElementById(tempId)?.remove();
            modal.classList.add('hidden');
            chatBox.innerHTML += `
                <div class="mb-2 text-left text-red-600">
                <strong>Equilibria:</strong> Error al contactar con el servidor.
                </div>`;
        }
    });

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
});

function mostrarToast(mensaje) {
    const toast = document.getElementById('toast-success');
    toast.textContent = mensaje;
    toast.style.right = '1.25rem';
    toast.style.opacity = '1';

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.right = '-100%';
        setTimeout(() => toast.textContent = '', 500);
    }, 4000);
}
