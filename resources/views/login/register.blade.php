@extends('layouts.base')
@section('content')
    <div
        class="relative min-h-screen flex items-center bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 overflow-hidden">
        <img src="{{ asset('images/register-foto.webp') }}" alt="Decoración"
            class="absolute right-[-560px] top-1/2 transform -translate-y-1/2 w-[1500px] hidden md:block pointer-events-none z-0" />

        <div class="relative z-10 w-full max-w-md mx-auto md:mx-0 md:ml-24 lg:ml-70 px-4 md:px-0 mt-20 mb-20">
            <div
                class="backdrop-blur-xl bg-white/80 rounded-3xl shadow-2xl border border-white/20 p-8 transition-all duration-300">
                <div class="text-center mb-8">
                    <h2
                        class="text-3xl font-bold bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 bg-clip-text text-transparent">
                        Crear cuenta en Equilibria
                    </h2>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200/50">
                        <ul class="list-disc list-inside text-red-600 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ url('/register') }}" class="space-y-4">
                    @csrf

                    <!-- Nombre field -->
                    <div class="">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-0.5">Nombre</label>
                        <input type="text" name="name" id="name" autofocus
                            class="w-full px-3 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white/70" />
                    </div>

                    <!-- Email field -->
                    <div class="">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-0.5">Email</label>
                        <input type="email" name="email" id="email"
                            class="w-full px-3 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white/70" />
                    </div>

                    <!-- Password field -->
                    <div class="relative group">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-0.5">Contraseña</label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                class="w-full px-3 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white/70"
                                data-tooltip="password-requirements" />
                            <button type="button"
                                class="absolute right-3 top-2.5 text-gray-500 hover:text-gray-700 focus:outline-none cursor-pointer"
                                id="togglePassword">
                                <!-- Icono de ojo (oculto por defecto) -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-5 h-5 hidden" id="showPassword">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <!-- Icono de ojo tachado (visible por defecto) -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-5 h-5" id="hidePassword">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>

                        <!-- Tooltip (inicialmente oculto) -->
                        <div id="password-tooltip"
                            class="absolute left-0 -bottom-32 w-64 hidden opacity-0 transform scale-95 transition-all duration-200 z-10">
                            <div class="bg-gray-900 text-white p-3 rounded-xl text-sm shadow-xl">
                                <div class="text-xs font-semibold mb-1">La contraseña debe tener:</div>
                                <ul class="text-xs space-y-1 text-gray-200">
                                    <li class="flex items-center gap-1">
                                        <span id="uppercase-check" class="text-red-400">✕</span>
                                        <span>Una mayúscula</span>
                                    </li>
                                    <li class="flex items-center gap-1">
                                        <span id="lowercase-check" class="text-red-400">✕</span>
                                        <span>Una minúscula</span>
                                    </li>
                                    <li class="flex items-center gap-1">
                                        <span id="number-check" class="text-red-400">✕</span>
                                        <span>Un número</span>
                                    </li>
                                    <li class="flex items-center gap-1">
                                        <span id="length-check" class="text-red-400">✕</span>
                                        <span>Mínimo 8 caracteres</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="absolute -top-1 left-8 w-3 h-3 bg-gray-900 transform rotate-45"></div>
                        </div>
                    </div>

                    <!-- Confirm Password field -->
                    <div class="relative group">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-0.5">Repetir
                            contraseña</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full px-3 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white/70" />
                            <button type="button"
                                class="absolute right-3 top-2.5 text-gray-500 hover:text-gray-700 focus:outline-none cursor-pointer"
                                id="toggleConfirmPassword">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-5 h-5 hidden" id="showConfirmPassword">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-5 h-5" id="hideConfirmPassword">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Botón de registro -->
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-600 text-white px-8 py-4 rounded-2xl font-semibold shadow-xl transform hover:scale-105 hover:shadow-2xl transition-all duration-300 border border-emerald-400/20 cursor-pointer">
                        <div class="relative flex items-center justify-center gap-3">
                            <span>Registrarse</span>
                        </div>
                    </button>
                </form>

                <!-- Separador con "O" -->
                <div class="relative my-5">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200/50"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 text-gray-500">O</span>
                    </div>
                </div>

                <!-- Botón de Google -->
                <a href="{{ route('google.login') }}"
                    class="w-full group relative overflow-hidden bg-white borderº border-gray-300 text-gray-700 px-6 py-4 rounded-2xl font-semibold shadow-lg transform hover:scale-105 hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-3 mb-10">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="w-5 h-5">
                        <path fill="#FFC107"
                            d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z" />
                        <path fill="#FF3D00"
                            d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z" />
                        <path fill="#4CAF50"
                            d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z" />
                        <path fill="#1976D2"
                            d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z" />
                    </svg>
                    <span>Registrarse con Google</span>
                </a>

                <!-- Link a login -->
                <div class="text-center">
                    <div
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-50 to-teal-50 px-4 py-2 rounded-full border border-emerald-200/50">
                        <span class="text-gray-600">¿Ya tienes cuenta?</span>
                        <a href="{{ route('login') }}"
                            class="text-emerald-600 font-semibold hover:text-emerald-700 transition-colors">
                            Inicia sesión
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/visual-password-validation.js'])

@endsection