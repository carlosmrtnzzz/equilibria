@extends('layouts.base')

@section('content')

    @if (session('info'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                mostrarToast(@json(session('info')), 'info');
            });
        </script>
    @endif

    <div class="relative min-h-screen flex items-center justify-center bg-white dark:bg-white overflow-hidden">
        <img src="{{ asset('images/register-foto.webp') }}" alt="Decoración"
            class="absolute right-[-560px] top-1/2 transform -translate-y-1/2 w-[1500px] hidden md:block pointer-events-none z-0" />

        <div class="relative z-10 w-full max-w-md bg-gray-100 dark:bg-gray-800 p-8 rounded-xl shadow-lg">

            <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-gray-100 mb-6">
                Crear cuenta en Equilibria
            </h2>

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-500">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/register') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nombre</label>
                    <input type="text" name="name" id="name" required
                        class="mt-1 w-full px-4 py-2 rounded-md border bg-white dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600 focus:outline-none focus:ring focus:border-green-400" />
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                    <input type="email" name="email" id="email" required
                        class="mt-1 w-full px-4 py-2 rounded-md border bg-white dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600 focus:outline-none focus:ring focus:border-green-400" />
                </div>

                <div class="mb-4">
                    <label for="password"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">Contraseña</label>
                    <input type="password" name="password" id="password" required
                        class="mt-1 w-full px-4 py-2 rounded-md border bg-white dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600 focus:outline-none focus:ring focus:border-green-400" />
                </div>

                <div class="mb-6">
                    <label for="password_confirmation"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">Repetir contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="mt-1 w-full px-4 py-2 rounded-md border bg-white dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600 focus:outline-none focus:ring focus:border-green-400" />
                </div>

                <button type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-xl">
                    Registrarse
                </button>
            </form>

            <div class="text-center mt-4 text-sm text-gray-500 dark:text-gray-300">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="text-green-600 hover:underline">Inicia sesión</a>
            </div>
        </div>
    </div>
@endsection