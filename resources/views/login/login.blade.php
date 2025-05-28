@extends('layouts.base')

@section('content')
    <div class="relative min-h-screen flex items-center justify-center bg-white dark:bg-white overflow-hidden">
        <img src="{{ asset('images/login-foto.webp') }}" alt="Decoración"
            class="absolute right-[-560px] top-1/2 transform -translate-y-1/2 w-[1500px] hidden md:block pointer-events-none z-0" />

        <div class="relative z-10 w-full max-w-md bg-gray-100 dark:bg-gray-800 p-8 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-gray-100 mb-6">
                Iniciar sesión en Equilibria
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

            <form method="POST" action="{{ url('/login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                    <input type="email" name="email" id="email" required autofocus
                        class="mt-1 w-full px-4 py-2 rounded-md border bg-white dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600 focus:outline-none focus:ring focus:border-green-400" />
                </div>

                <div class="mb-6">
                    <label for="password"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">Contraseña</label>
                    <input type="password" name="password" id="password" required
                        class="mt-1 w-full px-4 py-2 rounded-md border bg-white dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600 focus:outline-none focus:ring focus:border-green-400" />
                </div>

                <div class="flex items-center justify-between mb-4">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-xl w-full">
                        Entrar
                    </button>
                </div>
            </form>

            <div class="text-center mt-4 text-sm text-gray-500 dark:text-gray-300">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}" class="text-green-600 hover:underline">Regístrate</a>
            </div>
        </div>
    </div>
@endsection