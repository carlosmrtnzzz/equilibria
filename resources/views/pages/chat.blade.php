@extends('layouts.base')

@section('content')
    <div class="max-w-3xl mx-auto mt-12">
        <h2 class="text-2xl font-semibold mb-4 text-center text-emerald-700">Chat con Equilibria</h2>

        <div id="chat-box" class="border p-4 h-96 overflow-y-auto bg-white shadow rounded mb-4"></div>

        <form method="POST" action="{{ route('plan.generar') }}" class="mb-4">
            @csrf
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">
                Generar Plan Semanal
            </button>
        </form>
        <form id="chat-form" class="flex gap-2">
            @csrf
            <input type="text" name="mensaje" id="mensaje" placeholder="Escribe tu mensaje..."
                class="flex-grow border rounded px-4 py-2">
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">Enviar</button>
        </form>

    </div>
    @if (session('respuesta_chat'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const chatBox = document.getElementById('chat-box');
                chatBox.innerHTML += `<div class="mb-2 text-emerald-700"><strong>Equilibria:</strong> {{ session('respuesta_chat') }}` +
                    @if (session('pdf_url'))
                        `<br><a href='{{ session('pdf_url') }}' target='_blank' class='underline text-sm text-emerald-800 hover:text-emerald-900'>📄 Descargar Plan en PDF</a>` +
                    @endif
                    `<br><span class='text-sm text-gray-600'>También puedes verlo en <a href='{{ route('planes') }}' class='underline'>Planes</a>.</span></div>`;

                chatBox.scrollTop = chatBox.scrollHeight;
            });
        </script>
    @endif

@endsection

@push('scripts')
    <script>
        const form = document.getElementById('chat-form');
        const mensajeInput = document.getElementById('mensaje');
        const chatBox = document.getElementById('chat-box');

        document.addEventListener('DOMContentLoaded', async function () {
            const res = await fetch('/chat/historial');
            const mensajes = await res.json();

            mensajes.forEach(msg => {
                const clase = msg.role === 'user' ? 'Tú' : 'Equilibria';
                const color = msg.role === 'user' ? '' : 'text-emerald-700';
                chatBox.innerHTML += `<div class="mb-2 ${color}"><strong>${clase}:</strong> ${msg.content}</div>`;
            });

            chatBox.scrollTop = chatBox.scrollHeight;
        });

        document.getElementById('generarBtn').addEventListener('click', async function (e) {
            e.preventDefault();

            const texto = 'Genera mi plan semanal';
            chatBox.innerHTML += `<div class="mb-2"><strong>Tú:</strong> ${texto}</div>`;
            chatBox.scrollTop = chatBox.scrollHeight;

            const res = await fetch('/chat/enviar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ mensaje: texto })
            });

            const data = await res.json();
            chatBox.innerHTML += `<div class="mb-2 text-emerald-700"><strong>Equilibria:</strong> ${data.respuesta}</div>`;
            chatBox.scrollTop = chatBox.scrollHeight;
        });

    </script>

@endpush