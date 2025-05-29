@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
@endpush

@vite(['resources/js/home-scroll-animation.js'])

@extends('layouts.base')

@section('content')
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="scroll-container">
        <video autoplay loop muted class="background-video"
            aria-label="Animación de bienvenida de Equilibria, fondo motivacional">
            <source src="{{ asset('videos/equilibria-home.webm') }}" type="video/mp4">
            <track kind="subtitles" src="{{ asset('videos/equilibria-home-es.vtt') }}" srclang="es" label="Español">
            <track kind="subtitles" src="{{ asset('videos/equilibria-home-en.vtt') }}" srclang="en" label="English">
            <track kind="descriptions" src="{{ asset('videos/equilibria-home-desc.vtt') }}" srclang="es"
                label="Descripción en español">
            Tu navegador no soporta el elemento vídeo.
        </video>
        <div class="mask">
            <h2>EQUILIBRIA</h2>
        </div>

    </div>

    <main>
        @yield('content')
        <div class="flex flex-col md:flex-row items-center justify-between px-8 py-16 max-w-7xl mx-auto mt-35 mb-35">
            <div class="w-full md:w-1/2 relative z-10">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8 relative">
                    <span
                        class="absolute text-gray-300 text-6xl md:text-8xl top-[-40px] left-0 font-extrabold z-[-1] opacity-30">EQUILIBRIO</span>
                    COMER BIEN + HACER EJERCICIO
                </h1>

                <ul class="space-y-4 text-lg text-gray-700">
                    <li class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="3"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Bajar de peso
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="3"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Mantener tus hábitos
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="3"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Comer lo que quieras
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="3"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Planes semanales gratuitos
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="3"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Elección de comida
                    </li>
                </ul>
            </div>

            <div class="w-full md:w-1/2 mt-12 md:mt-0 flex justify-center">
                <video autoplay loop muted class="w-full h-auto"
                    aria-label="Vídeo motivacional de personas corriendo y comiendo sano">
                    <source src="{{ asset('videos/running.mp4') }}" type="video/mp4">
                    <track kind="subtitles" src="{{ asset('videos/running-es.vtt') }}" srclang="es" label="Español">
                    <track kind="subtitles" src="{{ asset('videos/running-en.vtt') }}" srclang="en" label="English">
                    <track kind="descriptions" src="{{ asset('videos/running-desc.vtt') }}" srclang="es"
                        label="Descripción en español">
                    Tu navegador no soporta el elemento vídeo.
                </video>
            </div>
        </div>
    </main>
    <!-- Sección adicional con características -->
    <div class="max-w-7xl mx-auto px-8 mt-24 mb-24 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div
            class="group backdrop-blur-xl bg-white/60 rounded-3xl p-6 shadow-xl border border-white/20 transform hover:scale-105 hover:bg-white/70 transition-all duration-300">
            <div
                class="w-16 h-16 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-2xl flex items-center justify-center mb-4 mx-auto shadow-lg group-hover:rotate-12 transition-all duration-300">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                    </path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 text-center mb-3">Planes Personalizados</h3>
            <p class="text-gray-600 text-center">Cada plan se adapta a tus necesidades específicas y preferencias
                alimentarias.</p>
        </div>

        <div
            class="group backdrop-blur-xl bg-white/60 rounded-3xl p-6 shadow-xl border border-white/20 transform hover:scale-105 hover:bg-white/70 transition-all duration-300">
            <div
                class="w-16 h-16 bg-gradient-to-r from-amber-500 to-orange-500 rounded-2xl flex items-center justify-center mb-4 mx-auto shadow-lg group-hover:rotate-12 transition-all duration-300">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                    </path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 text-center mb-3">Estilo de Vida</h3>
            <p class="text-gray-600 text-center">No es una dieta temporal, es un cambio sostenible hacia un estilo de vida
                más saludable.</p>
        </div>

        <div
            class="group backdrop-blur-xl bg-white/60 rounded-3xl p-6 shadow-xl border border-white/20 transform hover:scale-105 hover:bg-white/70 transition-all duration-300">
            <div
                class="w-16 h-16 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl flex items-center justify-center mb-4 mx-auto shadow-lg group-hover:rotate-12 transition-all duration-300">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                    </path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 text-center mb-3">Resultados Rápidos</h3>
            <p class="text-gray-600 text-center">Ve cambios positivos desde la primera semana con nuestros planes
                balanceados.</p>
        </div>
    </div>
@endsection