document.addEventListener('DOMContentLoaded', async function () {
    const chatBox = document.getElementById('chat-box');

    try {
        const resHistorial = await fetch('/chat/historial');
        const mensajes = await resHistorial.json();

        if (Array.isArray(mensajes) && mensajes.length > 0) {
            mensajes.forEach(msg => {
                const clase = msg.role === 'user' ? 'text-right' : 'text-left text-emerald-700';
                const nombre = msg.role === 'user' ? 'Tú' : 'Equilibria';
                const contenedor = document.createElement('div');
                contenedor.className = `mb-2 ${clase}`;
                contenedor.innerHTML = `<strong>${nombre}:</strong> ${msg.content}`;
                chatBox.appendChild(contenedor);
            });
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    } catch (e) {
        console.error("Error cargando historial:", e);
    }

    // 2. Cargar cambios restantes
    try {
        const resPlan = await fetch('/chat/plan-actual');
        const dataPlan = await resPlan.json();
        const cambios = dataPlan.changes_left;

        if (cambios <= 0) {
            const btnCambiar = document.getElementById('abrirModalBtn');
            if (btnCambiar) {
                btnCambiar.disabled = true;
                btnCambiar.classList.add('opacity-50', 'cursor-not-allowed');
                btnCambiar.title = "Ya has agotado tus 3 cambios.";
            }
        }
    } catch (e) {
        console.error("Error verificando cambios disponibles:", e);
    }

    document.getElementById('generarBtn')?.addEventListener('click', async function () {
        const texto = 'Generar un plan semanal personalizado';
        chatBox.innerHTML += `<div class="mb-2 text-right"><strong>Tú:</strong> ${texto}</div>`;
        chatBox.scrollTop = chatBox.scrollHeight;

        const tempId = 'temp-msg';
        chatBox.innerHTML += `
            <div id="${tempId}" class="mb-2 text-left flex items-center gap-2 text-gray-500 italic">
            <div class="dot-spinner">
            <div class="dot-spinner__dot"></div><div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div><div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div><div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div><div class="dot-spinner__dot"></div>
            </div>
            Generando tu plan semanal...
            </div>`;
        chatBox.scrollTop = chatBox.scrollHeight;

        try {
            const res = await fetch(window.generarPlanUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await res.json();
            if (data.logros && data.logros.length > 0) {
                data.logros.forEach(msg => mostrarToast(msg));
            }

            document.getElementById(tempId)?.remove();

            chatBox.innerHTML += `
            <div class="mb-2 text-left text-emerald-700">
            <strong>Equilibria:</strong> ${data.mensaje}
            <br><a href="${data.pdf_url}" target="_blank" class="underline text-sm text-emerald-800 hover:text-emerald-900">📄 Descargar Plan en PDF</a>
            <br><span class="text-sm text-gray-600">También puedes verlo en <a href="${window.planesUrl}" class="underline">Planes</a>.</span>
            </div>`;
            chatBox.scrollTop = chatBox.scrollHeight;
        } catch (e) {
            document.getElementById(tempId)?.remove();
            chatBox.innerHTML += `<div class="mb-2 text-left text-red-600">❌ Error generando el plan.</div>`;
        }
    });
});