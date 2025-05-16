@extends('layouts.base')

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-10">
        <h2 class="text-3xl font-bold text-emerald-700 mb-8 text-center">Plan Semanal Actual</h2>

        @if ($planes->isEmpty())
            <div class="text-center text-gray-600 text-lg">
                <p>🛈 Aún no has generado ningún plan semanal.</p>
                <p class="mt-2">
                    Puedes hacerlo desde la sección <a href="{{ route('chat') }}" class="text-emerald-600 underline">Chat</a>.
                </p>
            </div>
        @else
            @php
                $ultimo = $planes->first();
                $meals = json_decode($ultimo->meals_json, true);
            @endphp

            <div class="mb-6 text-center">
                <p class="text-gray-700">
                    Mostrando plan del <strong>{{ \Carbon\Carbon::parse($ultimo->start_date)->format('d/m/Y') }}</strong>
                    al <strong>{{ \Carbon\Carbon::parse($ultimo->end_date)->format('d/m/Y') }}</strong>.
                </p>
                <a href="{{ asset($ultimo->pdf_url) }}" target="_blank" class="download-button mt-4 block w-max">
                    <div class="docs">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        Descargar PDF
                    </div>
                    <div class="download">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                    </div>
                </a>

            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
                    <thead class="bg-emerald-100 text-emerald-800">
                        <tr>
                            <th class="px-4 py-2 border">Día</th>
                            <th class="px-4 py-2 border">Desayuno</th>
                            <th class="px-4 py-2 border">Comida</th>
                            <th class="px-4 py-2 border">Cena</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($meals as $dia => $comidas)
                            <tr class="border-t">
                                <td class="px-4 py-2 border font-semibold capitalize">{{ $dia }}</td>
                                <td class="px-4 py-2 border">{{ $comidas['desayuno'] ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $comidas['comida'] ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $comidas['cena'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection