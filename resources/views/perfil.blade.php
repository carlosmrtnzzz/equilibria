@extends('layouts.base')

@section('content')
    <div class="w-full">

        <!-- Banner con avatar -->
        <div class="relative w-full h-64 bg-cover bg-center"
            style="background-image: url('{{ asset('images/profile-banner.jpg') }}');">
            <div class="absolute bottom-[-48px] left-1/2 transform -translate-x-1/2">
                <img src="{{ asset('images/default.jpg') }}" alt="Avatar"
                    class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover">
            </div>
        </div>

        <!-- Nombre + botón -->
        <div class="mt-20 px-4 flex flex-col md:flex-row justify-center items-center gap-4">
            <h2 class="text-2xl font-semibold text-gray-800 text-center">
                {{ Auth::user()->name }}
            </h2>

            <button id="edit-profile-btn"
                class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2 rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 20h9" />
                    <path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z" />
                </svg>
                Editar perfil
            </button>
        </div>

        @if (session('success'))
            <div id="toast-success"
                class="fixed top-28 right-[-100%] z-[9999] bg-green-100 border-l-4 border-green-500 text-green-800 px-6 py-3 rounded shadow-lg transition-all duration-500 ease-out">
                {{ session('success') }}
            </div>

            <script>
                window.addEventListener('DOMContentLoaded', () => {
                    const toast = document.getElementById('toast-success');
                    if (toast) {
                        setTimeout(() => {
                            toast.style.right = '1.25rem';
                        }, 100);

                        setTimeout(() => {
                            toast.style.opacity = '0';
                            toast.style.right = '-100%';
                            setTimeout(() => toast.remove(), 500);
                        }, 4000);
                    }
                });
            </script>
        @endif


        <!-- Datos del perfil -->
        <div class="mt-8 px-4 flex justify-center">
            <div class="bg-white shadow-md rounded-xl p-6 w-full max-w-xl text-center">
                <p class="text-gray-600"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <p class="text-gray-600 mt-2"><strong>Edad:</strong> {{ Auth::user()->age ?? 'No especificada' }}</p>
                <p class="text-gray-600 mt-2"><strong>Sexo:</strong>
                    {{ Auth::user()->gender == 'male' ? 'Hombre' : 'Mujer' }}</p>
                <p class="text-gray-600 mt-2"><strong>Peso:</strong> {{ Auth::user()->weight_kg ?? 'No especificado' }} kg
                </p>
                <p class="text-gray-600 mt-2"><strong>Altura:</strong> {{ Auth::user()->height_cm ?? 'No especificada' }} cm
                </p>
            </div>
        </div>

        <!-- Modal con blur -->
        <div id="edit-modal" class="fixed inset-0 z-50 items-center justify-center hidden bg-white/30 backdrop-blur-sm">
            <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md m-auto">
                <h3 class="text-xl font-semibold mb-4 text-emerald-700 text-center">Editar perfil</h3>

                <form method="POST" action="{{ route('perfil.actualizar') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}"
                            class="mt-1 w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700">Edad</label>
                        <input type="number" name="age" value="{{ Auth::user()->age }}"
                            class="mt-1 w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sexo</label>
                        <div class="flex gap-4 mt-1">
                            <label class="flex items-center">
                                <input type="radio" name="gender" value="male" {{ Auth::user()->gender == 'male' ? 'checked' : '' }} class="text-emerald-600">
                                <span class="ml-2">Hombre</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="gender" value="female" {{ Auth::user()->gender == 'female' ? 'checked' : '' }} class="text-emerald-600">
                                <span class="ml-2">Mujer</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="weight_kg" class="block text-sm font-medium text-gray-700">Peso (kg)</label>
                        <input type="number" name="weight_kg" value="{{ Auth::user()->weight_kg }}"
                            class="mt-1 w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <div>
                        <label for="height_cm" class="block text-sm font-medium text-gray-700">Altura (cm)</label>
                        <input type="number" name="height_cm" value="{{ Auth::user()->height_cm }}"
                            class="mt-1 w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <div class="flex justify-end gap-4 mt-6">
                        <button type="button" id="close-modal"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">Cancelar</button>
                        <button type="submit"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2 rounded-md">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        const modal = document.getElementById('edit-modal');
        const openBtn = document.getElementById('edit-profile-btn');
        const closeBtn = document.getElementById('close-modal');

        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });
    </script>
@endsection