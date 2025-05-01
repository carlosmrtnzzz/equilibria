<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Equilibria</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    @stack('styles')
</head>

<body>
    <header class="w-full shadow bg-white dark:bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-green-600 dark:text-green-400">Equilibria</a>

            <div class="flex space-x-4">
                @auth
                    <a href="{{ route('/') }}"
                        class="px-4 py-2 rounded-md bg-emerald-600 text-white hover:bg-emerald-700">
                        Inicio
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 rounded-md bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white hover:bg-gray-400 dark:hover:bg-gray-700">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-md bg-green-500 text-white hover:bg-green-600">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 rounded-md bg-gray-200 text-gray-900 hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                        Registro
                    </a>
                @endauth
            </div>
        </div>
    </header>

    @yield('content')

    <footer class="bg-emerald-700 text-center text-sm py-4 border-t dark:border-gray-700">
        &copy; {{ date('Y') }} Equilibria. All rights reserved.
    </footer>

    @stack('scripts')
</body>

</html>