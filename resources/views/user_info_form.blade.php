@extends('layouts.base')

@section('content')
    <div
        class="relative min-h-screen flex items-center bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 overflow-hidden">
        <img src="{{ asset('images/user-form.webp') }}" alt="Decoración"
            class="absolute right-[-560px] top-1/2 transform -translate-y-1/2 w-[1500px] hidden md:block pointer-events-none z-0" />

        <div class="relative z-10 w-full max-w-md mx-auto md:mx-0 md:ml-24 lg:ml-70 px-4 md:px-0">
            <div
                class="backdrop-blur-xl bg-white/80 rounded-3xl shadow-2xl border border-white/20 p-8 transition-all duration-300">
                <div class="text-center mb-8">
                    <h2
                        class="text-3xl font-bold bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 bg-clip-text text-transparent">
                        Completa tu perfil
                    </h2>
                </div>

                <form method="POST" action="{{ route('guardar.datos') }}" class="space-y-4">
                    @csrf

                    <!-- Fecha de nacimiento -->
                    <div class="">
                        <label for="birth_date" class="block text-sm font-semibold text-gray-700 mb-0.5">Fecha de
                            nacimiento</label>
                        <input type="date" id="birth_date" name="birth_date"
                            class="w-full px-3 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white/70" />
                    </div>

                    <!-- Sexo -->
                    <div class="">
                        <span class="block text-sm font-semibold text-gray-700 mb-2">Sexo</span>
                        <div class="flex gap-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" id="gender_male" name="gender" value="male" checked
                                    class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500">
                                <span class="ml-2 text-gray-700">Hombre</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" id="gender_female" name="gender" value="female"
                                    class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500">
                                <span class="ml-2 text-gray-700">Mujer</span>
                            </label>
                        </div>
                    </div>

                    <!-- Peso -->
                    <div class="">
                        <label for="weight" class="block text-sm font-semibold text-gray-700 mb-0.5">Peso (kg)</label>
                        <input type="number" name="weight" id="weight"
                            class="w-full px-3 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white/70" />
                    </div>

                    <!-- Altura -->
                    <div class="">
                        <label for="height" class="block text-sm font-semibold text-gray-700 mb-0.5">Altura (cm)</label>
                        <input type="number" name="height" id="height"
                            class="w-full px-3 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white/70" />
                    </div>

                    <!-- Botón de envío -->
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-600 text-white px-8 py-4 rounded-2xl font-semibold shadow-xl transform hover:scale-105 hover:shadow-2xl transition-all duration-300 border border-emerald-400/20 cursor-pointer">
                        <div class="relative flex items-center justify-center gap-3">
                            <span>Comenzar</span>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection