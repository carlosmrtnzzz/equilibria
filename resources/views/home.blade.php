@extends('layouts.base')

@section('content')
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
        <h1 class="text-center text-2xl mb-150">Hola hola</h1>
    </main>

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="{{ asset('js/home-scroll-animation.js') }}"></script>
@endpush