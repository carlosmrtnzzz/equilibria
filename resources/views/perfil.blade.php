@extends('layouts.base')

@section('content')
    <div class="w-full">

        <div class="relative w-full h-64 bg-cover bg-center"
            style="background-image: url('{{ asset('assets/images/profile-banner.jpg') }}');">
            <div class="absolute bottom-[-48px] left-8">
                <img src="{{ asset('assets/images/default-avatar.jpg') }}" alt="Avatar"
                    class="w-24 h-24 rounded-full border-4 border-white shadow-lg">
            </div>
        </div>

        <div class="mt-16 px-8 flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">
                {{ Auth::user()->name }}
            </h2>
            <a href="#" class="bg-gray-700 text-white px-4 py-2 rounded flex items-center gap-2 hover:bg-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11 5h4m4 0h-4m0 0V1m0 4l-6.5 6.5a2.121 2.121 0 00-.621 1.5v3.378a1 1 0 001 1h3.378a2.121 2.121 0 001.5-.621L19 9m0 0l-4-4z" />
                </svg>
                Editar perfil
            </a>
        </div>

    </div>
@endsection