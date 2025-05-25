@extends('layouts.base')

@section('content')
    <div class="max-w-5xl mx-auto py-16 px-4">
        <h1 class="text-3xl font-bold text-center text-emerald-700 mb-8">Tus Logros</h1>

        @php
            $total = $allAchievements->count();
            $conseguidos = $allAchievements->filter(fn($a) => $a->users->first()?->pivot->unlocked ?? false)->count();
        @endphp

        <p class="text-center text-gray-600 mb-6">
            Has desbloqueado <span class="font-semibold text-emerald-700">{{ $conseguidos }}</span> de
            <span class="font-semibold text-emerald-700">{{ $total }}</span> logros.
        </p>

        @if ($total === 0)
            <p class="text-center text-gray-500">Todavía no hay logros definidos.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @foreach ($allAchievements as $achievement)
                    @php
                        $pivot = $achievement->users->first()?->pivot;
                        $progress = $pivot?->progress ?? 0;
                        $target = $achievement->target_value;
                        $completed = $pivot?->unlocked ?? false;
                        $percentage = $target > 0 ? min(100, intval(($progress / $target) * 100)) : 0;
                    @endphp

                    <div class="bg-white shadow rounded-xl p-5 transition hover:scale-[1.02]">
                        <div class="flex items-center gap-4 mb-3">
                            <img src="{{ asset('icons/' . $achievement->icon) }}" alt="Icono logro"
                                class="w-12 h-12 {{ $completed ? '' : 'grayscale opacity-50' }}">
                            <div>
                                <h3 class="text-lg font-semibold text-emerald-700">{{ $achievement->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $achievement->description }}</p>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="w-full bg-gray-200 rounded-full h-4">
                                <div class="h-4 rounded-full transition-all duration-300"
                                    style="width: {{ $percentage }}%; background-color: {{ $completed ? '#10b981' : '#d1d5db' }}">
                                </div>
                            </div>
                            <p class="text-sm mt-1 text-right text-gray-500">
                                {{ $percentage }}% {{ $completed ? 'Completado' : 'Pendiente' }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection