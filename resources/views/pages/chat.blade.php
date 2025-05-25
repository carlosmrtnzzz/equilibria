@extends('layouts.base')

@section('content')
    <div class="max-w-4xl mx-auto mt-12">
        <h2 class="text-2xl font-semibold mb-7 text-center text-emerald-700">Chat con Equilibria</h2>

        <div id="chat-box" class="border p-4 h-96 overflow-y-auto bg-white shadow rounded mb-4"></div>

        <div class="mb-4 flex gap-2">
            <button type="button" id="generarBtn"
                class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700 cursor-pointer">
                Generar Plan Semanal
            </button>
            <button type="button" id="abrirModalBtn"
                class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 cursor-pointer">
                Cambiar Plato
            </button>
        </div>
    </div>
@endsection

<div id="modalCambiarPlatos" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[80vh] p-6 overflow-y-auto">
        <h2 class="text-xl font-bold mb-4 text-gray-800 text-center">Selecciona hasta 3 platos para reemplazar</h2>
        <div id="contenedorPlatos" class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        </div>
        <div class="flex justify-end gap-2">
            <button id="cancelarModalBtn" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                Cancelar
            </button>
            <button id="confirmarCambiosBtn" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">
                Actualizar
            </button>
        </div>
    </div>
</div>

<div id="toast-success"
    class="fixed top-28 right-[-100%] z-[9999] bg-green-100 border-l-4 border-green-500 text-green-800 px-6 py-3 rounded shadow-lg transition-all duration-500 ease-out">
</div>

@push('scripts')
    <script>
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

        const chatBox = document.getElementById('chat-box');

        document.addEventListener('DOMContentLoaded', async function () {
            try {
                const resHistorial = await fetch('/chat/historial');
                const mensajes = await resHistorial.json();

                mensajes.forEach(msg => {
                    const clase = msg.role === 'user' ? 'text-right' : 'text-left text-emerald-700';
                    const nombre = msg.role === 'user' ? 'Tú' : 'Equilibria';
                    const contenedor = document.createElement('div');
                    contenedor.className = `mb-2 ${clase}`;
                    contenedor.innerHTML = `<strong>${nombre}:</strong> ${msg.content}`;
                    chatBox.appendChild(contenedor);
                });

                chatBox.scrollTop = chatBox.scrollHeight;

                const resPlan = await fetch('/chat/plan-actual');
                const dataPlan = await resPlan.json();
                const cambios = dataPlan.changes_left;

                if (cambios <= 0) {
                    const btnCambiar = document.getElementById('abrirModalBtn');
                    btnCambiar.disabled = true;
                    btnCambiar.classList.add('opacity-50', 'cursor-not-allowed');
                    btnCambiar.title = "Ya has agotado tus 3 cambios.";
                }
            } catch (e) {
                console.error("Error inicializando chat:", e);
            }
        });

        document.getElementById('generarBtn').addEventListener('click', async function () {
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
                const res = await fetch("{{ route('plan.generar') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
                                                                            <br><span class="text-sm text-gray-600">También puedes verlo en <a href="{{ route('planes') }}" class="underline">Planes</a>.</span>
                                                                        </div>`;
                chatBox.scrollTop = chatBox.scrollHeight;
            } catch (e) {
                document.getElementById(tempId)?.remove();
                chatBox.innerHTML += `<div class="mb-2 text-left text-red-600">❌ Error generando el plan.</div>`;
                console.error(e);
            }
        });
    </script>

    <script>
        const modal = document.getElementById('modalCambiarPlatos');
        const abrirModalBtn = document.getElementById('abrirModalBtn');
        const cancelarModalBtn = document.getElementById('cancelarModalBtn');
        const contenedorPlatos = document.getElementById('contenedorPlatos');
        const confirmarCambiosBtn = document.getElementById('confirmarCambiosBtn');
        let seleccionados = [];

        abrirModalBtn.addEventListener('click', async () => {
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

            const aviso = document.createElement('div');
            aviso.className = 'col-span-2 text-sm text-gray-600 mb-2';
            aviso.innerText = `Puedes cambiar hasta ${changesLeft} plato(s).`;
            contenedorPlatos.appendChild(aviso);

            const meals = data.meals;
            let idCounter = 0;

            Object.entries(meals).forEach(([dia, comidas]) => {
                Object.entries(comidas).forEach(([tipo, plato]) => {
                    const id = `plato-${idCounter++}`;
                    const div = document.createElement('div');
                    div.className = 'plato-caja';
                    div.textContent = `${capitalize(dia)} - ${capitalize(tipo)}: ${plato}`;
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

        cancelarModalBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        confirmarCambiosBtn.addEventListener('click', async () => {
            if (seleccionados.length === 0) {
                alert('Selecciona al menos 1 plato.');
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
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ platos })
                });

                const data = await res.json();
                document.getElementById(tempId)?.remove();

                if (data.success) {
                    chatBox.innerHTML += `
                                                                <div class="mb-2 text-left text-emerald-700">
                                                                    <strong>Equilibria:</strong> He actualizado los platos seleccionados. Te quedan <strong>${data.changes_left}</strong> intento(s).
                                                                </div>`;
                    chatBox.scrollTop = chatBox.scrollHeight;

                    if (data.changes_left > 0) {
                        abrirModalBtn.click();
                    } else {
                        modal.classList.add('hidden');
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
    </script>
@endpush