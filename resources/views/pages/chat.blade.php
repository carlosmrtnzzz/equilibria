@extends('layouts.base')

@section('content')
    <div class="max-w-4xl mx-auto mt-12">
        <h2 class="text-2xl font-semibold mb-7 text-center text-emerald-700">Chat con Equilibria</h2>

        <div id="chat-box" class="border p-4 h-96 overflow-y-auto bg-white shadow rounded mb-4"></div>

        <div class="mb-4 flex gap-2">
            <button type="button" id="generarBtn"
                class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700 cursor-pointer">
                Generar Plan Semanal
            </button>
            <button type="button" id="abrirModalBtn"
                class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 cursor-pointer">
                Cambiar Plato
            </button>
            <button type="button" id="abrirIntrolerancias"
                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 cursor-pointer">
                Intolerancias
            </button>
        </div>
    </div>
@endsection

<div id="modalCambiarPlatos" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[80vh] p-6 overflow-y-auto">
        <h2 class="text-xl font-bold mb-4 text-gray-800 text-center">Selecciona hasta 3 platos para reemplazar</h2>
        <div id="contenedorPlatos" class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        </div>
        <div class="flex justify-end gap-2">
            <button id="cancelarModalBtn"
                class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 cursor-pointer">
                Cancelar
            </button>
            <button id="confirmarCambiosBtn"
                class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700 cursor-pointer">
                Actualizar
            </button>
        </div>
    </div>
</div>


<div id="modalIntolerancias" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6">
        <h2 class="text-xl font-bold mb-4 text-center text-gray-800">Intolerancias</h2>
        <form id="formPreferencias" class="space-y-4">
            <h3 class="text-gray-700 font-medium">Selecciona tus intolerancias alimentarias:</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <label class="flex items-center gap-2">
                    <input type="checkbox" id="is_celiac" name="is_celiac" class="form-checkbox text-emerald-600">
                    Celiaquía (Gluten)
                </label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" id="is_lactose_intolerant" name="is_lactose_intolerant"
                        class="form-checkbox text-emerald-600">
                    Intolerancia a la lactosa
                </label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" id="is_fructose_intolerant" name="is_fructose_intolerant"
                        class="form-checkbox text-emerald-600">
                    Intolerancia a la fructosa
                </label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" id="is_histamine_intolerant" name="is_histamine_intolerant"
                        class="form-checkbox text-emerald-600">
                    Intolerancia a la histamina
                </label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" id="is_sorbitol_intolerant" name="is_sorbitol_intolerant"
                        class="form-checkbox text-emerald-600">
                    Intolerancia al sorbitol
                </label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" id="is_casein_intolerant" name="is_casein_intolerant"
                        class="form-checkbox text-emerald-600">
                    Intolerancia a la caseína
                </label>

                <label class="flex items-center gap-2">
                    <input type="checkbox" id="is_egg_intolerant" name="is_egg_intolerant"
                        class="form-checkbox text-emerald-600">
                    Intolerancia al huevo
                </label>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" id="cancelarPreferenciasBtn"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 cursor-pointer">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 cursor-pointer">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>


<div id="toast-success"
    class="fixed top-28 right-[-100%] z-[9999] bg-green-100 border-l-4 border-green-500 text-green-800 px-6 py-3 rounded shadow-lg transition-all duration-500 ease-out">
</div>

@push('scripts')
    <script>
        window.generarPlanUrl = "{{ route('plan.generar') }}";
        window.planesUrl = "{{ route('planes') }}";
    </script>
    <script src="{{ asset('js/chat-equilibria.js') }}"></script>
    <script src="{{ asset('js/cambiar-platos.js') }}"></script>
    <script src="{{ asset('js/preferencias.js') }}"></script>

@endpush