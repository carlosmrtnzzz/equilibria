@extends('layouts.base')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 relative overflow-hidden">
        <div
            class="absolute top-0 left-0 w-72 h-72 bg-gradient-to-r from-emerald-400/20 to-teal-400/20 rounded-full blur-3xl animate-pulse">
        </div>
        <div
            class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-r from-cyan-400/20 to-blue-400/20 rounded-full blur-3xl animate-pulse delay-1000">
        </div>

        <div class="relative max-w-6xl mx-auto pt-16 pb-12 px-4 mb-25">
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-3 mb-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                    </div>
                    <h1
                        class="text-4xl font-bold bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 bg-clip-text text-transparent">
                        Plan Semanal Actual
                    </h1>
                </div>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Tu planificación nutricional personalizada para toda la semana
                </p>
            </div>

            @if ($planes->isEmpty())
                <div
                    class="backdrop-blur-xl bg-white/80 rounded-3xl shadow-2xl border border-white/20 p-12 text-center transform hover:scale-[1.01] transition-all duration-300">
                    <div
                        class="w-24 h-24 bg-gradient-to-r from-gray-400/20 to-gray-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-700 mb-4">Aún no tienes planes semanales</h3>
                    <p class="text-gray-600 text-lg mb-8 max-w-md mx-auto">
                        Comienza creando tu primer plan nutricional personalizado
                    </p>
                    <a href="{{ route('chat') }}"
                        class="group inline-flex items-center gap-3 bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-600 text-white px-8 py-4 rounded-2xl font-semibold shadow-xl transform hover:scale-105 hover:shadow-2xl transition-all duration-300 border border-emerald-400/20">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-emerald-400 to-teal-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl">
                        </div>
                        <div class="relative flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            <span>Ir a Chat con Equilibria</span>
                        </div>
                    </a>
                </div>
            @else
                @php
                    $ultimo = $planes->first();
                    $meals = json_decode($ultimo->meals_json, true);
                @endphp

                <!-- Información del plan -->
                <div
                    class="backdrop-blur-xl bg-white/80 rounded-3xl shadow-2xl border border-white/20 p-8 mb-8 transform hover:scale-[1.01] transition-all duration-300">
                    <div class="text-center mb-6">
                        <div
                            class="inline-flex items-center gap-3 bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-3 rounded-2xl border border-emerald-200/50 mb-4">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V9a2 2 0 002 2h4a2 2 0 002-2V7M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2">
                                </path>
                            </svg>
                            <span class="text-emerald-700 font-semibold">Plan Activo</span>
                        </div>
                        <p class="text-gray-700 text-lg">
                            Período: <span
                                class="font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">{{ \Carbon\Carbon::parse($ultimo->start_date)->format('d/m/Y') }}</span>
                            al <span
                                class="font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">{{ \Carbon\Carbon::parse($ultimo->end_date)->format('d/m/Y') }}</span>
                        </p>
                    </div>

                    <!-- Botón de descarga mejorado -->
                    <div class="flex justify-center">
                        <a href="{{ asset($ultimo->pdf_url) }}" target="_blank"
                            class="group relative overflow-hidden bg-gradient-to-r from-red-500 via-pink-500 to-purple-500 text-white px-8 py-4 rounded-2xl font-semibold shadow-xl transform hover:scale-105 hover:shadow-2xl transition-all duration-300 border border-red-400/20">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-red-400 to-purple-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <div class="relative flex items-center gap-3">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                    <span>Descargar PDF</span>
                                </div>
                                <svg class="w-5 h-5 group-hover:translate-y-0.5 transition-transform duration-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Tabla mejorada -->
                <div class="backdrop-blur-xl bg-white/80 mt-15 rounded-3xl shadow-2xl border border-white/20 overflow-hidden" id="weekly_plan_mobile">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gradient-to-r from-emerald-500 to-teal-500 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left font-semibold text-lg border-r border-emerald-400/30">Día
                                    </th>
                                    <th class="px-6 py-4 text-left font-semibold text-lg border-r border-emerald-400/30">
                                        Desayuno</th>
                                    <th class="px-6 py-4 text-left font-semibold text-lg border-r border-emerald-400/30">Media
                                        Mañana</th>
                                    <th class="px-6 py-4 text-left font-semibold text-lg border-r border-emerald-400/30">Comida
                                    </th>
                                    <th class="px-6 py-4 text-left font-semibold text-lg border-r border-emerald-400/30">
                                        Merienda</th>
                                    <th class="px-6 py-4 text-left font-semibold text-lg">Cena</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white/50 backdrop-blur-sm">
                                @foreach ($meals as $dia => $comidas)
                                    <tr
                                        class="border-t border-gray-200/50 hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-teal-50/50 transition-all duration-300 group">
                                        <td class="px-6 py-4 border-r border-gray-200/50">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-3 h-3 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full group-hover:scale-125 transition-transform duration-300">
                                                </div>
                                                <span class="font-bold capitalize text-gray-800 text-lg">{{ $dia }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 border-r border-gray-200/50">
                                            <div
                                                class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-3 border border-yellow-200/50">
                                                <p class="text-gray-700 font-medium">{{ $comidas['desayuno'] ?? '-' }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 border-r border-gray-200/50">
                                            <div
                                                class="bg-gradient-to-r from-amber-50 to-yellow-50 rounded-xl p-3 border border-amber-200/50">
                                                <p class="text-gray-700 font-medium">{{ $comidas['media-mañana'] ?? '-' }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 border-r border-gray-200/50">
                                            <div
                                                class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-3 border border-blue-200/50">
                                                <p class="text-gray-700 font-medium">{{ $comidas['comida'] ?? '-' }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 border-r border-gray-200/50">
                                            <div
                                                class="bg-gradient-to-r from-lime-50 to-green-50 rounded-xl p-3 border border-lime-200/50">
                                                <p class="text-gray-700 font-medium">{{ $comidas['merienda'] ?? '-' }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div
                                                class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-3 border border-purple-200/50">
                                                <p class="text-gray-700 font-medium">{{ $comidas['cena'] ?? '-' }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection