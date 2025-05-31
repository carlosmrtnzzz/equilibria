@extends('layouts.base')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 relative overflow-hidden pt-5">
        <div
            class="absolute top-0 left-0 w-72 h-72 bg-gradient-to-r from-emerald-400/20 to-teal-400/20 rounded-full blur-3xl animate-pulse">
        </div>
        <div
            class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-r from-cyan-400/20 to-blue-400/20 rounded-full blur-3xl animate-pulse delay-1000">
        </div>

        <div class="relative">
            <!-- Banner superior -->
            <div class="relative w-full h-80 bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 pb-20">
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute top-10 left-10 w-32 h-32 bg-white/30 rounded-full blur-2xl"></div>
                    <div class="absolute top-20 right-20 w-24 h-24 bg-white/20 rounded-full blur-xl"></div>
                    <div class="absolute bottom-20 left-1/3 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                </div>

                <!-- Avatar flotante -->
                <div class="absolute bottom-[-60px] left-1/2 transform -translate-x-1/2">
                    <div class="relative">
                        <form id="photo-form" method="POST" action="{{ route('perfil.actualizar') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="hidden">
                            <div class="w-32 h-32 rounded-full bg-gradient-to-r from-white to-gray-100 p-2 shadow-2xl cursor-pointer group"
                                onclick="document.getElementById('profile_photo').click();"
                                title="Haz clic para cambiar tu foto de perfil">
                                <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('images/default.webp') }} "
                                    alt="Avatar"
                                    class="w-full h-full rounded-full object-cover border-4 border-white/50 group-hover:opacity-80 transition-opacity duration-200">
                                <div
                                    class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <span class="bg-black/60 text-white text-xs px-2 py-1 rounded">Cambiar foto</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Información del usuario -->
            <div class="relative max-w-5xl mx-auto pt-20 pb-12 px-4">
                <div class="text-center mb-12">
                    <h1
                        class="nombre-usuario text-4xl font-bold bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 bg-clip-text text-transparent mb-4 pb-4">
                        {{ ucfirst(Auth::user()->name) }}
                    </h1>
                    <button id="edit-profile-btn"
                        class="group relative overflow-hidden bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-600 text-white px-8 py-4 rounded-2xl font-semibold shadow-xl transform hover:scale-105 hover:shadow-2xl transition-all duration-300 border border-emerald-400/20 cursor-pointer">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-emerald-400 to-teal-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                        <div class="relative flex items-center justify-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 20h9M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                            </svg>
                            <span>Editar Perfil</span>
                        </div>
                    </button>
                </div>

                <!-- Tarjeta de información principal -->
                <div
                    class="backdrop-blur-xl bg-white/80 rounded-3xl shadow-2xl border border-white/20 p-8 mb-8 transform hover:scale-[1.01] transition-all duration-300">
                    <div class="text-center mb-8">
                        <div
                            class="inline-flex items-center gap-3 bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-3 rounded-2xl border border-emerald-200/50 mb-6">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-emerald-700 font-semibold">Información Personal</span>
                        </div>
                    </div>

                    <!-- Grid de información -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Email -->
                        <div
                            class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200/50 transform hover:scale-105 transition-all duration-300">
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-blue-700">Email</h3>
                                    <p class="text-blue-600 text-sm break-all">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Edad -->
                        <div
                            class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-200/50 transform hover:scale-105 transition-all duration-300">
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-purple-700">Edad</h3>
                                    <p class="edad-usuario text-purple-600 font-medium">
                                        {{ Auth::user()->age ?? 'No especificada' }} años
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Género -->
                        <div
                            class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl p-6 border border-amber-200/50 transform hover:scale-105 transition-all duration-300">
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-amber-700">Género</h3>
                                    <p class="genero-usuario text-amber-600 font-medium">
                                        {{ Auth::user()->gender == 'male' ? 'Hombre' : (Auth::user()->gender == 'female' ? 'Mujer' : 'No especificado') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Peso -->
                        <div
                            class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-200/50 transform hover:scale-105 transition-all duration-300">
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-green-700">Peso</h3>
                                    <p class="peso-usuario text-green-600 font-medium">
                                        {{ Auth::user()->weight_kg ?? 'No especificado' }}
                                        kg
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Altura -->
                        <div
                            class="bg-gradient-to-r from-teal-50 to-cyan-50 rounded-2xl p-6 border border-teal-200/50 transform hover:scale-105 transition-all duration-300">
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2M7 4h10M7 4l-2 16h14L17 4M9 9v6m6-6v6">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-teal-700">Altura</h3>
                                    <p class="altura-usuario text-teal-600 font-medium">
                                        {{ Auth::user()->height_cm ?? 'No especificada' }}
                                        cm
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- IMC (si tenemos peso y altura) -->
                        @if(Auth::user()->weight_kg && Auth::user()->height_cm)
                            @php
                                $altura_m = Auth::user()->height_cm / 100;
                                $imc = round(Auth::user()->weight_kg / ($altura_m * $altura_m), 1);
                                $categoria = $imc < 18.5 ? 'Bajo peso' : ($imc < 25 ? 'Normal' : ($imc < 30 ? 'Sobrepeso' : 'Obesidad'));
                                $color = $imc < 18.5 ? 'from-blue-50 to-indigo-50 border-blue-200/50' : ($imc < 25 ? 'from-green-50 to-emerald-50 border-green-200/50' : ($imc < 30 ? 'from-yellow-50 to-orange-50 border-yellow-200/50' : 'from-red-50 to-pink-50 border-red-200/50'));
                                $iconColor = $imc < 18.5 ? 'from-blue-500 to-indigo-500' : ($imc < 25 ? 'from-green-500 to-emerald-500' : ($imc < 30 ? 'from-yellow-500 to-orange-500' : 'from-red-500 to-pink-500'));
                                $textColor = $imc < 18.5 ? 'text-blue-700' : ($imc < 25 ? 'text-green-700' : ($imc < 30 ? 'text-yellow-700' : 'text-red-700'));
                            @endphp
                            <div id="imc-box"
                                class="imc-usuario bg-gradient-to-r {{ $color }} rounded-2xl p-6 border transform hover:scale-105 transition-all duration-300">
                                <div class="flex items-center gap-3 mb-3">
                                    <div id="imc-icon"
                                        class="w-10 h-10 bg-gradient-to-r {{ $iconColor }} rounded-xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 00-2-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="imc-titulo font-semibold {{ $textColor }}">IMC</h3>
                                        <p class="imc-valor {{ $textColor }} font-medium">{{ $imc }} - {{ $categoria }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="text-center">
                    <div
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-50 to-teal-50 px-4 py-2 rounded-full border border-emerald-200/50 mb-15 mt-5">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-emerald-700 text-sm font-medium">Mantén tu perfil actualizado para mejores
                            recomendaciones</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de edición -->
    <div id="edit-modal"
        class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm items-center justify-center p-3 animate-fadeIn mt-20">

        <div
            class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl w-full max-w-2xl max-h-[85vh] overflow-hidden border border-white/20 transform animate-slideUp">
            <!-- Header del modal -->
            <div class="bg-gradient-to-r from-emerald-500 to-teal-500 p-6 text-center">
                <div class="flex items-center justify-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 20h9M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white">Editar Perfil</h2>
                </div>
                <p class="text-white/90">Actualiza tu información personal</p>
            </div>

            <!-- Contenido del modal -->
            <div class="p-5 overflow-y-auto max-h-[60vh]">
                <form id="perfil-form" method="POST" action="{{ route('perfil.actualizar') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Nombre -->
                    <div class="bg-gradient-to-r from-gray-50 to-white rounded-2xl p-3 border border-gray-200/50">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nombre completo</label>
                        <input id="name" type="text" name="name" value="{{ ucfirst(Auth::user()->name) }}"
                            autocomplete="name"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white/70">
                        <div id="name-error" class="text-red-500 text-xs mt-1 hidden"></div>
                    </div>

                    <!-- Edad -->
                    <div class="bg-gradient-to-r from-gray-50 to-white rounded-2xl p-3 border border-gray-200/50">
                        <label for="age" class="block text-sm font-semibold text-gray-700 mb-2">Edad</label>
                        <input id="age" type="number" name="age" value="{{ Auth::user()->age }}" min="1" max="120"
                            autocomplete="off"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white/70">
                    </div>

                    <!-- Género -->
                    <div class="bg-gradient-to-r from-gray-50 to-white rounded-2xl p-3 border border-gray-200/50">
                        <span class="block text-sm font-semibold text-gray-700 mb-3">Género</span>
                        <div class="grid grid-cols-2 gap-3">
                            <label for="gender-male"
                                class="group flex items-center gap-3 p-3 rounded-xl hover:bg-emerald-50 transition-all duration-200 cursor-pointer border border-gray-200 hover:border-emerald-300">
                                <input id="gender-male" type="radio" name="gender" value="male" {{ Auth::user()->gender == 'male' ? 'checked' : '' }}
                                    class="w-5 h-5 text-emerald-600 bg-white border-2 border-gray-300 focus:ring-emerald-500 focus:ring-2 transition-all duration-200">
                                <span class="text-gray-700 group-hover:text-emerald-700 font-medium">Hombre</span>
                            </label>
                            <label for="gender-female"
                                class="group flex items-center gap-3 p-3 rounded-xl hover:bg-emerald-50 transition-all duration-200 cursor-pointer border border-gray-200 hover:border-emerald-300">
                                <input id="gender-female" type="radio" name="gender" value="female" {{ Auth::user()->gender == 'female' ? 'checked' : '' }}
                                    class="w-5 h-5 text-emerald-600 bg-white border-2 border-gray-300 focus:ring-emerald-500 focus:ring-2 transition-all duration-200">
                                <span class="text-gray-700 group-hover:text-emerald-700 font-medium">Mujer</span>
                            </label>
                        </div>
                    </div>

                    <!-- Peso y Altura -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gradient-to-r from-gray-50 to-white rounded-2xl p-4 border border-gray-200/50">
                            <label for="weight_kg" class="block text-sm font-semibold text-gray-700 mb-2">Peso (kg)</label>
                            <input id="weight_kg" type="number" name="weight_kg" value="{{ Auth::user()->weight_kg }}"
                                min="1" max="500" step="0.1" autocomplete="off"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white/70">
                        </div>
                        <div class="bg-gradient-to-r from-gray-50 to-white rounded-2xl p-4 border border-gray-200/50">
                            <label for="height_cm" class="block text-sm font-semibold text-gray-700 mb-2">Altura
                                (cm)</label>
                            <input id="height_cm" type="number" name="height_cm" value="{{ Auth::user()->height_cm }}"
                                min="1" max="300" autocomplete="off"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white/70">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer del modal -->
            <div class="bg-gray-50/80 backdrop-blur-sm p-3.5 flex justify-end gap-3 border-t border-gray-200/50">
                <button type="button" id="close-modal"
                    class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 cursor-pointer">
                    Cancelar
                </button>
                <button type="submit" form="perfil-form"
                    class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white rounded-xl font-medium shadow-lg transition-all duration-300 transform hover:scale-105 cursor-pointer">
                    Guardar Cambios
                </button>
            </div>
        </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/js/perfil.js')

@endsection