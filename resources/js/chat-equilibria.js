document.addEventListener('DOMContentLoaded', async function () {
    const chatBox = document.getElementById('chat-box');

    function renderMensaje(msg) {
        const contenedor = document.createElement('div');
        if (msg.role === 'user') {
            contenedor.className = 'mb-2 text-right';
            contenedor.innerHTML = `
                <div class="inline-block rounded-lg bg-white/90 border border-emerald-200 p-4 text-emerald-800 shadow-lg ml-auto">
                    <strong class="text-emerald-700">Tú:</strong> ${msg.content}
                </div>
            `;
        } else {
            contenedor.className = 'mb-2 text-left';
            contenedor.innerHTML = `
                <div class="inline-block rounded-lg bg-gradient-to-r from-emerald-500 to-teal-500 p-4 text-white shadow-lg">
                    <strong class="text-emerald-50">Equilibria:</strong>
                    <p class="mt-1">${msg.content}</p>
                </div>
            `;
        }
        return contenedor;
    }

    try {
        const resHistorial = await fetch('/chat/historial');
        if (!resHistorial.ok) throw new Error("No hay historial todavía");

        const mensajes = await resHistorial.json();
        mensajes.forEach(msg => {
            chatBox.appendChild(renderMensaje(msg));
        });

        chatBox.scrollTop = chatBox.scrollHeight;
    } catch (e) {
        console.warn("No se pudo cargar historial:", e.message);
    }

    try {
        const resPlan = await fetch(window.planActualUrl);
        if (!resPlan.ok) throw new Error("No hay plan actual");
        const dataPlan = await resPlan.json();

        const cambios = dataPlan.changes_left;

        if (cambios <= 0) {
            const btnCambiar = document.getElementById('abrirModalBtn');
            btnCambiar.disabled = true;
            btnCambiar.classList.add('opacity-50', 'cursor-not-allowed');
            btnCambiar.title = "Ya has agotado tus 3 cambios.";
        }
    } catch (err) {
        console.warn("No hay ningun plan generado.");
    }


    document.getElementById('generarBtn')?.addEventListener('click', async function () {
        const texto = 'Generar un plan semanal personalizado';
        chatBox.innerHTML += `
            <div class="mb-2 text-right">
                <div class="inline-block rounded-lg bg-white/90 border border-emerald-200 p-4 text-emerald-800 shadow-lg ml-auto hover:shadow-xl transition-all">
                    <strong class="text-emerald-700">Tú:</strong> ${texto}
                </div>
            </div>`;
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

            const mensajeIA = {
                role: 'assistant',
                content: `
                <div class="bg-gradient-to-r from-emerald-50 to-green-50 p-4 rounded-lg border border-emerald-200 shadow-sm">
                    <div class="space-y-3">
                    <p class="text-gray-800 font-medium">
                    ¡Tu plan semanal está listo!
                    </p>
            
                <div class="flex items-center gap-2">
                    <a href="${data.pdf_url}" 
                    target="_blank" 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Descargar PDF
                    </a>
                </div>
            
                <p class="text-xs text-gray-500">
                También puedes consultar todos tus planes en 
                <a href="${window.planesUrl}" 
                   class="text-emerald-600 hover:text-emerald-700 underline font-medium transition-colors duration-200">
                    Mi Panel de Planes
                </a>
                </p>
            </div>
        </div>
`
            };
            chatBox.appendChild(renderMensaje(mensajeIA));
            chatBox.scrollTop = chatBox.scrollHeight;
        } catch (e) {
            document.getElementById(tempId)?.remove();
            chatBox.innerHTML += `<div class="mb-2 text-left text-red-600">❌ Error generando el plan.</div>`;
        }
    });
});