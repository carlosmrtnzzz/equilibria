@extends('layouts.base')

@section('content')
    <!-- Fondo con gradiente animado -->
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 relative overflow-hidden">
        <!-- Elementos decorativos animados -->
        <div
            class="absolute top-0 left-0 w-72 h-72 bg-gradient-to-r from-emerald-400/20 to-teal-400/20 rounded-full blur-3xl animate-pulse">
        </div>

        <div class="relative max-w-6xl mx-auto pt-16 pb-12 px-4">
            <!-- Header mejorado -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-3 mb-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-r from-amber-500 to-yellow-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                            </path>
                        </svg>
                    </div>
                    <h1
                        class="text-4xl font-bold pb-2 bg-gradient-to-r from-amber-600 via-yellow-600 to-orange-600 bg-clip-text text-transparent">
                        Tus Logros
                    </h1>
                </div>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Descubre tu progreso y celebra cada paso hacia una vida más saludable
                </p>
            </div>

            @php
                $total = $allAchievements->count();
                $conseguidos = $allAchievements->filter(fn($a) => $a->users->first()?->pivot->unlocked ?? false)->count();
                $porcentajeGeneral = $total > 0 ? intval(($conseguidos / $total) * 100) : 0;
            @endphp

            <!-- Panel de progreso general -->
            <div
                class="backdrop-blur-xl bg-white/80 rounded-3xl shadow-2xl border border-white/20 p-8 mb-8 transform hover:scale-[1.01] transition-all duration-300">
                <div class="text-center mb-6">
                    <div
                        class="inline-flex items-center gap-3 bg-gradient-to-r from-amber-50 to-yellow-50 px-6 py-3 rounded-2xl border border-amber-200/50 mb-4">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 00-2-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                        <span class="text-amber-700 font-semibold">Progreso General</span>
                    </div>

                    <!-- Estadísticas principales -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div
                            class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl p-6 border border-emerald-200/50">
                            <div class="text-3xl font-bold text-emerald-600 mb-2">{{ $conseguidos }}</div>
                            <div class="text-emerald-700 font-medium">Logros Conseguidos</div>
                        </div>
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200/50">
                            <div class="text-3xl font-bold text-blue-600 mb-2">{{ $total }}</div>
                            <div class="text-blue-700 font-medium">Total de Logros</div>
                        </div>
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-200/50">
                            <div class="text-3xl font-bold text-purple-600 mb-2">{{ $porcentajeGeneral }}%</div>
                            <div class="text-purple-700 font-medium">Completado</div>
                        </div>
                    </div>

                    <!-- Barra de progreso general -->
                    <div class="max-w-md mx-auto">
                        <div class="w-full bg-gray-200/50 rounded-full h-4 shadow-inner">
                            <div class="h-4 rounded-full bg-gradient-to-r from-amber-500 to-yellow-500 transition-all duration-1000 ease-out shadow-sm"
                                style="width: {{ $porcentajeGeneral }}%">
                            </div>
                        </div>
                        <p class="text-gray-600 mt-2 font-medium">
                            {{ $porcentajeGeneral }}% de tu journey nutricional completado
                        </p>
                    </div>
                </div>
            </div>

            @if ($total === 0)
                    <!-- Estado vacío mejorado -->
                    <div
                        class="backdrop-blur-xl bg-white/80 rounded-3xl shadow-2xl border border-white/20 p-12 text-center transform hover:scale-[1.01] transition-all duration-300">
                        <div
                            class="w-24 h-24 bg-gradient-to-r from-gray-400/20 to-gray-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Los logros están en camino</h3>
                        <p class="text-gray-600 text-lg mb-8 max-w-md mx-auto">
                            Pronto tendrás desafíos emocionantes para completar y celebrar tus éxitos
                        </p>
                        <div
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-50 to-teal-50 px-4 py-2 rounded-full border border-emerald-200/50">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-emerald-700 text-sm font-medium">¡Mantente atento a las actualizaciones!</span>
                        </div>
                    </div>
                </div>
            @else
                <!-- Grid de logros mejorado -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach ($allAchievements as $achievement)
                        @php
                            $pivot = $achievement->users->where('pivot.achievement_id', $achievement->id)->first()?->pivot;
                            $progress = $pivot?->progress ?? 0;
                            $target = $achievement->target_value;
                            $completed = $pivot?->unlocked ?? false;
                            $percentage = $target > 0 ? min(100, intval(($progress / $target) * 100)) : 0;
                        @endphp

                        <div
                            class="group backdrop-blur-xl bg-white/80 rounded-3xl shadow-2xl border border-white/20 p-6 transform hover:scale-105 hover:shadow-3xl transition-all duration-500 relative overflow-hidden {{ $completed ? 'ring-2 ring-amber-400/50' : '' }}">

                            <!-- Efecto de brillo para logros completados -->
                            @if($completed)
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-amber-400/10 via-yellow-400/10 to-orange-400/10 animate-pulse">
                                </div>
                            @endif

                            <!-- Header del logro -->
                            <div class="relative flex items-center gap-4 mb-4">
                                <div class="relative">
                                    <div
                                        class="w-16 h-16 {{ $completed ? 'bg-gradient-to-r from-amber-500 to-yellow-500' : 'bg-gray-300' }} rounded-2xl flex items-center justify-center shadow-lg transition-all duration-300 group-hover:scale-110">
                                        @if($completed)
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                                </path>
                                            </svg>
                                        @else
                                            <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                                </path>
                                            </svg>
                                        @endif
                                    </div>

                                    <!-- Badge de estado -->
                                    @if($completed)
                                        <div
                                            class="absolute -top-2 -right-2 w-6 h-6 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center shadow-lg">
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1">
                                    <h3
                                        class="text-lg font-bold {{ $completed ? 'text-amber-700' : 'text-gray-700' }} transition-colors duration-300">
                                        {{ $achievement->name }}
                                    </h3>
                                    <p class="text-sm text-gray-600 leading-relaxed">
                                        {{ $achievement->description }}
                                    </p>
                                </div>
                            </div>

                            <!-- Barra de progreso -->
                            <div class="relative">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium {{ $completed ? 'text-emerald-700' : 'text-gray-600' }}">
                                        Progreso
                                    </span>
                                    <span class="text-sm font-bold {{ $completed ? 'text-emerald-700' : 'text-gray-600' }}">
                                        {{ $progress }}/{{ $target }}
                                    </span>
                                </div>

                                <div class="w-full bg-gray-200/50 rounded-full h-3 shadow-inner overflow-hidden">
                                    <div class="h-3 rounded-full transition-all duration-1000 ease-out {{ $completed ? 'bg-gradient-to-r from-amber-500 to-yellow-500' : 'bg-gradient-to-r from-gray-400 to-gray-500' }}"
                                        style="width: {{ $percentage }}%">
                                    </div>
                                </div>

                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-xs {{ $completed ? 'text-amber-600' : 'text-gray-500' }} font-medium">
                                        {{ $percentage }}% completado
                                    </span>
                                    @if($completed)
                                        <div
                                            class="inline-flex items-center gap-1 bg-gradient-to-r from-green-50 to-emerald-50 px-2 py-1 rounded-full border border-green-200/50">
                                            <span class="text-xs text-green-700 font-semibold">¡Completado!</span>
                                        </div>
                                    @else
                                        <div
                                            class="inline-flex items-center gap-1 bg-gradient-to-r from-blue-50 to-indigo-50 px-2 py-1 rounded-full border border-blue-200/50">
                                            <span class="text-xs text-blue-700 font-semibold">En progreso</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Información adicional -->
                <div class="mt-25 text-center mb-20">
                    <div
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-50 to-teal-50 px-4 py-2 rounded-full border border-emerald-200/50">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-emerald-700 text-sm font-medium">¡Sigue usando Equilibria para desbloquear más
                            logros!</span>
                    </div>
                </div>
            </div>
            </div>
        @endif
    </div>
@endsection