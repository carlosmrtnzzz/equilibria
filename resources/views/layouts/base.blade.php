<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Equilibria</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body class="min-h-screen flex flex-col">
    <header class="w-full shadow bg-white dark:bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Equilibria" class="h-16">
            </a>

            <nav class="flex items-center space-x-6 text-gray-800 dark:text-gray-900 font-medium">
                <a href="{{ route('/') }}" class="hover:text-emerald-600">Inicio</a>
                <a href="{{ route('chat') }}" class="hover:text-emerald-600">Chat</a>
                <a href="{{ route('planes') }}" class="hover:text-emerald-600">Planes Semanales</a>
                <a href="{{ route('logros') }}" class="hover:text-emerald-600">Logros</a>
            </nav>

            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('perfil') }}" class="text-gray-700 hover:text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5.121 17.804A9 9 0 0112 15a9 9 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 rounded-md bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white hover:bg-gray-400 dark:hover:bg-gray-700 cursor-pointer">
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

    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    <footer class="bg-emerald-700 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 text-sm">
            <div>
                <h4 class="text-base font-semibold mb-2">Equilibria</h4>
                <p>Tu bienestar es nuestra misión. Mejora tus hábitos de forma sostenible.</p>
            </div>

            <div>
                <h4 class="text-base font-semibold mb-2">Navegación</h4>
                <ul class="space-y-1">
                    <li><a href="{{ route('/') }}" class="hover:underline">Inicio</a></li>
                    <li><a href="{{ route('planes') }}" class="hover:underline">Planes Semanales</a></li>
                    <li><a href="{{ route('chat') }}" class="hover:underline">Chat</a></li>
                    <li><a href="{{ route('logros') }}" class="hover:underline">Logros</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-base font-semibold mb-2">Contacto</h4>
                <ul class="space-y-1">
                    <li>Email: <a href="mailto:info@equilibria.com" class="hover:underline">info@equilibria.com</a></li>
                    <li>Twitter: <a href="#" class="hover:underline">@EquilibriaApp</a></li>
                    <li>GitHub: <a href="#" class="hover:underline">github.com/Equilibria</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-emerald-500 mt-6 pt-4 text-center text-xs text-emerald-100">
            &copy; {{ date('Y') }} Equilibria. Todos los derechos reservados.
        </div>
    </footer>



    @stack('scripts')
</body>

</html>