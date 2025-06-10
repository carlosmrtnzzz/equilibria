<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')Equilibria</title>
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
                                Cerrar sesión
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
                            <span class="relative">Inicio de sesión</span>
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

            <div class="flex flex-col items-start">
                <h4 class="text-base font-semibold mb-2">Redes Sociales</h4>
                <ul class="example-2 pl-0">
                    <li class="icon-content">
                        <a href="https://www.linkedin.com/in/carlos-mart%C3%ADnez-jim%C3%A9nez-132318331/"
                            aria-label="LinkedIn" data-social="linkedin" target="_blank">
                            <div class="filled"></div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-linkedin" viewBox="0 0 16 16">
                                <path
                                    d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z" />
                            </svg>
                        </a>
                        <div class="tooltip">LinkedIn</div>
                    </li>
                    <li class="icon-content">
                        <a href="https://github.com/carlosmrtnzzz/equilibria.git" aria-label="GitHub"
                            data-social="github" target="_blank">
                            <div class="filled"></div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-github" viewBox="0 0 16 16">
                                <path
                                    d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8" />
                            </svg>
                        </a>
                        <div class="tooltip">GitHub</div>
                    </li>
                    <li class="icon-content">
                        <a href="#" aria-label="Instagram" data-social="instagram">
                            <div class="filled"></div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-instagram" viewBox="0 0 16 16">
                                <path
                                    d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                            </svg>
                        </a>
                        <div class="tooltip">Instagram</div>
                    </li>
                    <li class="icon-content">
                        <a href="#" aria-label="YouTube" data-social="youtube">
                            <div class="filled"></div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-youtube" viewBox="0 0 16 16">
                                <path
                                    d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.01 2.01 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.01 2.01 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31 31 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.01 2.01 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A100 100 0 0 1 7.858 2zM6.4 5.209v4.818l4.157-2.408z" />
                            </svg>
                        </a>
                        <div class="tooltip">YouTube</div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-emerald-500 mt-6 pt-4 text-center text-xs text-emerald-100">
            &copy; {{ date('Y') }} Equilibria. Todos los derechos reservados.
        </div>
    </footer>

</body>

</html>