@extends('layouts.base')

@section('content')
    <div class="relative min-h-screen flex items-center justify-center bg-white dark:bg-white overflow-hidden px-6 py-12">
        <img src="{{ asset('images/user-form.webp') }}" alt="Decoración"
            class="absolute right-[-420px] top-1/2 transform -translate-y-1/2 w-[1350px] hidden md:block pointer-events-none z-0" />

        <div class="relative z-10 w-full max-w-5xl flex flex-col md:flex-row gap-8 items-center justify-between">

            <div class="w-full md:w-1/2 bg-green-50 p-8 rounded-2xl shadow-lg">
                <h2 class="text-2xl font-bold text-center text-emerald-700 mb-6">Rellena tus datos</h2>

                <form method="POST" action="{{ route('guardar.datos') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="birth_date" class="block text-sm font-medium text-gray-700">Fecha de nacimiento</label>
                        <input type="date" name="birth_date" required
                            class="mt-1 w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sexo</label>
                        <div class="flex gap-4">
                            <label class="flex items-center">
                                <input type="radio" name="gender" value="male" checked class="text-emerald-600">
                                <span class="ml-2">Hombre</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="gender" value="female" class="text-emerald-600">
                                <span class="ml-2">Mujer</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700">Peso (kg)</label>
                        <input type="number" name="weight" required
                            class="mt-1 w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" />
                    </div>

                    <div>
                        <label for="height" class="block text-sm font-medium text-gray-700">Altura (cm)</label>
                        <input type="number" name="height" required
                            class="mt-1 w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" />
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded-xl transition">
                            Comenzar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection