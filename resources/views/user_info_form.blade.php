@extends('layouts.base')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 px-8 py-12">

        <div class="w-full md:w-1/2 bg-green-50 p-8 rounded-2xl shadow-md">
            <h2 class="text-2xl font-semibold text-center text-emerald-700 mb-6">Rellena tus datos</h2>

            <form method="POST" action="{{ route('guardar.datos') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700">Fecha de nacimiento</label>
                    <input type="date" name="birth_date"
                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                        required>
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
                    <input type="number" name="weight"
                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                        required>
                </div>

                <div>
                    <label for="height" class="block text-sm font-medium text-gray-700">Altura (cm)</label>
                    <input type="number" name="height"
                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                        required>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded-md transition">
                        Comenzar
                    </button>
                </div>
            </form>
        </div>
        <div class="w-full md:w-1/2">
            <img src="{{ asset('assets/images/user-form.png') }}" alt="Imagen deporte" class="w-full rounded-xl shadow-md">
        </div>
    </div>
@endsection