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
        <video autoplay loop muted class="background-video">
            <source src="{{ asset('assets/videos/equilibria-home.mp4') }}" type="video/mp4">
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
                <video autoplay loop muted class="w-full h-auto">
                    <source src="{{ asset('assets/videos/running.mp4') }}" type="video/mp4">
                </video>
            </div>
        </div>
    </main>

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="{{ asset('js/home-scroll-animation.js') }}"></script>
@endpush