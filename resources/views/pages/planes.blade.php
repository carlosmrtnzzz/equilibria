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
                <a href="{{ asset($ultimo->pdf_url) }}" target="_blank"
                    class="inline-block mt-2 bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">
                    📄 Descargar PDF
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