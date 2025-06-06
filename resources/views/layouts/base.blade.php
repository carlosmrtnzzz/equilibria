<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Equilibria</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.webp') }}">

    @vite('resources/css/app.css')
    @vite('resources/js/toast-notification.js')
    @vite(['resources/js/modal-handler.js'])
    @vite('resources/js/user-dropdown.js')

    @stack('styles')
    @stack('scripts')
</head>

<body class="min-h-screen flex flex-col">
    @include('components.toast')
    <header class="w-full shadow bg-white dark:bg-gray-100 relative z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/">
                <img src="{{ asset('images/logo.webp') }}" alt="Equilibria" class="h-16">
            </a>

            <!-- Botón hamburguesa -->
            <button id="mobile-menu-toggle" class="md:hidden text-gray-700 cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Menú principal -->
            <nav id="main-nav"
                class="hidden md:flex items-center justify-center space-x-6 text-gray-800 dark:text-gray-900 font-medium">
                <a href="{{ route('/') }}" class="hover:text-emerald-600">Inicio</a>
                <a href="{{ route('chat') }}" class="hover:text-emerald-600">Chat</a>
                <a href="{{ route('planes') }}" class="hover:text-emerald-600">Planes Semanales</a>
                <a href="{{ route('logros') }}" class="hover:text-emerald-600">Logros</a>
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="/admin" class="hover:text-emerald-600">Panel de administración</a>
                    @endif
                @endauth
            </nav>

            <div class="relative md:flex hidden"> @auth
                <div id="user-button"
                    class="cursor-pointer text-gray-700 hover:text-emerald-600 flex items-center justify-center w-10 h-10 rounded-full transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5.121 17.804A9 9 0 0112 15a9 9 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div id="user-dropdown"
                    class="absolute right-0 mt-10 w-40 bg-white border border-emerald-200 rounded-md shadow-md hidden transition-all duration-200 z-50">

                    <div class="relative z-20 rounded-md overflow-hidden">
                        <a href="{{ route('perfil') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100">Perfil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-emerald-100 cursor-pointer">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                    <div class="space-x-3 hidden md:flex">
                        <a href="{{ route('login') }}"
                            class="group relative overflow-hidden bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-600 text-white px-6 py-3 rounded-2xl font-semibold shadow-xl transform hover:scale-105 hover:shadow-2xl transition-all duration-300 border border-emerald-400/20">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-emerald-400 to-teal-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <span class="relative">Login</span>
                        </a>
                        <a href="{{ route('register') }}"
                            class="group relative overflow-hidden bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-2xl font-semibold shadow-lg transform hover:scale-105 hover:shadow-xl transition-all duration-300">
                            <div
                                class="absolute inset-0 bg-gray-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <span class="relative">Registro</span>
                        </a>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Menú responsive -->
        <div id="mobile-nav"
            class="md:hidden hidden flex-col items-start bg-white border-t border-gray-200 px-6 py-4 space-y-3 text-gray-800 font-medium animate-fade-down">
            <a href="{{ route('/') }}" class="block hover:text-emerald-600">Inicio</a>
            <a href="{{ route('chat') }}" class="block hover:text-emerald-600">Chat</a>
            <a href="{{ route('planes') }}" class="block hover:text-emerald-600">Planes Semanales</a>
            <a href="{{ route('logros') }}" class="block hover:text-emerald-600">Logros</a>
            @auth
                @if(auth()->user()->is_admin)
                    <a href="/admin" class="block hover:text-emerald-600">Panel de administración</a>
                @endif
            @endauth

            @auth
                <a href="{{ route('perfil') }}" class="block hover:text-emerald-600">Perfil</a>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="block w-full text-left hover:text-emerald-600 cursor-pointer">Logout</button>
                </form>
            @else
                <div class="mt-10">
                    <a href="{{ route('login') }}"
                        class="group relative overflow-hidden bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-600 text-white px-6 py-3 rounded-2xl font-semibold shadow-xl transform hover:scale-105 hover:shadow-2xl transition-all duration-300 border border-emerald-400/20 w-full text-center mr-5">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-emerald-400 to-teal-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                        <span class="relative">Login</span>
                    </a>
                    <a href="{{ route('register') }}"
                        class="group relative overflow-hidden bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-2xl font-semibold shadow-lg transform hover:scale-105 hover:shadow-xl transition-all duration-300 w-full text-center">
                        <div
                            class="absolute inset-0 bg-gray-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                        <span class="relative">Registro</span>
                    </a>
                </div>
            @endauth
        </div>

    </header>

    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    <footer class="bg-emerald-700 text-white py-8">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 text-sm">
            <div>
                <h4 class="text-base font-semibold mb-2">Equilibria</h4>
                <p>Tu bienestar es nuestra misión. Mejora tus hábitos de forma sostenible.</p>
            </div>

            <div>
                <h4 class="text-base font-semibold mb-2">Navegación</h4>
                <ul class="space-y-1">
                    <li><a href="{{ route('manual') }}" class="hover:underline">Manual de usuario</a></li>
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

</body>

</html>