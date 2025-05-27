@extends('layouts.base')

@section('content')
    <!-- Fondo con gradiente animado -->
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 relative overflow-hidden">
        <!-- Elementos decorativos animados -->
        <div
            class="absolute top-0 left-0 w-72 h-72 bg-gradient-to-r from-emerald-400/20 to-teal-400/20 rounded-full blur-3xl animate-pulse">
        </div>
        <div
            class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-r from-cyan-400/20 to-blue-400/20 rounded-full blur-3xl animate-pulse delay-1000">
        </div>

        <div class="relative max-w-5xl mx-auto pt-16 pb-12 px-4">
            <!-- Header mejorado -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-3 mb-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                    </div>
                    <h1
                        class="text-4xl font-bold bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 bg-clip-text text-transparent">
                        Chat con Equilibria
                    </h1>
                </div>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Tu asistente inteligente para crear planes nutricionales personalizados
                </p>
            </div>

            <!-- Chat container mejorado -->
            <div
                class="backdrop-blur-xl bg-white/80 rounded-3xl shadow-2xl border border-white/20 p-6 mb-8 transform hover:scale-[1.01] transition-all duration-300">
                <div id="chat-box"
                    class="h-96 overflow-y-auto bg-gradient-to-br from-gray-50/50 to-white/50 rounded-2xl p-6 shadow-inner border border-gray-100/50 scroll-smooth">
                    <!-- Mensaje de bienvenida -->
                    <div class="flex items-start gap-3 mb-4 opacity-70">
                        <div
                            class="w-8 h-8 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="bg-white/70 rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm border border-gray-100">
                            <p class="text-gray-700">¡Hola! Soy Equilibria, tu asistente nutricional. ¿En qué puedo ayudarte
                                hoy?</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de acción mejorados -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <button type="button" id="generarBtn"
                    class="group relative overflow-hidden bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-600 text-white px-6 py-4 rounded-2xl font-semibold shadow-xl transform hover:scale-105 hover:shadow-2xl transition-all duration-300 border border-emerald-400/20 cursor-pointer">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-emerald-400 to-teal-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div class="relative flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        <span>Generar Plan Semanal</span>
                    </div>
                </button>

                <button type="button" id="abrirModalBtn"
                    class="group relative overflow-hidden bg-gradient-to-r from-amber-500 via-orange-500 to-yellow-500 text-white px-6 py-4 rounded-2xl font-semibold shadow-xl transform hover:scale-105 hover:shadow-2xl transition-all duration-300 border border-amber-400/20 cursor-pointer">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-amber-400 to-orange-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div class="relative flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                        <span>Cambiar Plato</span>
                    </div>
                </button>

                <button type="button" id="abrirIntrolerancias"
                    class="group relative overflow-hidden bg-gradient-to-r from-purple-500 via-indigo-500 to-blue-500 text-white px-6 py-4 rounded-2xl font-semibold shadow-xl transform hover:scale-105 hover:shadow-2xl transition-all duration-300 border border-purple-400/20 cursor-pointer">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-purple-400 to-indigo-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div class="relative flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Intolerancias</span>
                    </div>
                </button>
            </div>
        </div>
    </div>


    <!-- Modal Cambiar Platos mejorado -->
    <div id="modalCambiarPlatos"
        class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 animate-fadeIn">
        <div
            class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl w-full max-w-3xl max-h-[85vh] overflow-hidden border border-white/20 transform animate-slideUp">
            <!-- Header del modal -->
            <div class="bg-gradient-to-r from-emerald-500 to-teal-500 p-6 text-center">
                <div class="flex items-center justify-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white">Cambiar Platos</h2>
                </div>
                <p class="text-white/90">Selecciona hasta 3 platos para reemplazar</p>
            </div>

            <!-- Contenido del modal -->
            <div class="p-6 overflow-y-auto max-h-[60vh]">
                <div id="contenedorPlatos" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Los platos se cargarán dinámicamente aquí -->
                </div>
            </div>

            <!-- Footer del modal -->
            <div class="bg-gray-50/80 backdrop-blur-sm p-6 flex justify-end gap-3 border-t border-gray-200/50">
                <button id="cancelarModalBtn"
                    class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 cursor-pointer">
                    Cancelar
                </button>
                <button id="confirmarCambiosBtn"
                    class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white rounded-xl font-medium shadow-lg transition-all duration-300 transform hover:scale-105 cursor-pointer">
                    Actualizar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Intolerancias mejorado -->
    <div id="modalIntolerancias"
        class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 animate-fadeIn">
        <div
            class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden border border-white/20 transform animate-slideUp">
            <!-- Header del modal -->
            <div class="bg-gradient-to-r from-purple-500 to-indigo-500 p-6 text-center">
                <div class="flex items-center justify-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white">Intolerancias Alimentarias</h2>
                </div>
                <p class="text-white/90">Personaliza tu experiencia nutricional</p>
            </div>

            <!-- Contenido del modal -->
            <div class="p-6">
                <form id="formPreferencias" class="space-y-6">
                    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-2xl p-4 border border-purple-100">
                        <h3 class="text-gray-800 font-semibold mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Selecciona tus intolerancias:
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label
                                class="group flex items-center gap-3 p-3 rounded-xl hover:bg-white/70 transition-all duration-200 cursor-pointer">
                                <input type="checkbox" id="is_celiac" name="is_celiac"
                                    class="w-5 h-5 text-purple-600 bg-white border-2 border-gray-300 rounded-lg focus:ring-purple-500 focus:ring-2 transition-all duration-200">
                                <span class="text-gray-700 group-hover:text-gray-900 font-medium">Celiaquía (Gluten)</span>
                            </label>

                            <label
                                class="group flex items-center gap-3 p-3 rounded-xl hover:bg-white/70 transition-all duration-200 cursor-pointer">
                                <input type="checkbox" id="is_lactose_intolerant" name="is_lactose_intolerant"
                                    class="w-5 h-5 text-purple-600 bg-white border-2 border-gray-300 rounded-lg focus:ring-purple-500 focus:ring-2 transition-all duration-200">
                                <span class="text-gray-700 group-hover:text-gray-900 font-medium">Intolerancia a la
                                    lactosa</span>
                            </label>

                            <label
                                class="group flex items-center gap-3 p-3 rounded-xl hover:bg-white/70 transition-all duration-200 cursor-pointer">
                                <input type="checkbox" id="is_fructose_intolerant" name="is_fructose_intolerant"
                                    class="w-5 h-5 text-purple-600 bg-white border-2 border-gray-300 rounded-lg focus:ring-purple-500 focus:ring-2 transition-all duration-200">
                                <span class="text-gray-700 group-hover:text-gray-900 font-medium">Intolerancia a la
                                    fructosa</span>
                            </label>

                            <label
                                class="group flex items-center gap-3 p-3 rounded-xl hover:bg-white/70 transition-all duration-200 cursor-pointer">
                                <input type="checkbox" id="is_histamine_intolerant" name="is_histamine_intolerant"
                                    class="w-5 h-5 text-purple-600 bg-white border-2 border-gray-300 rounded-lg focus:ring-purple-500 focus:ring-2 transition-all duration-200">
                                <span class="text-gray-700 group-hover:text-gray-900 font-medium">Intolerancia a la
                                    histamina</span>
                            </label>

                            <label
                                class="group flex items-center gap-3 p-3 rounded-xl hover:bg-white/70 transition-all duration-200 cursor-pointer">
                                <input type="checkbox" id="is_sorbitol_intolerant" name="is_sorbitol_intolerant"
                                    class="w-5 h-5 text-purple-600 bg-white border-2 border-gray-300 rounded-lg focus:ring-purple-500 focus:ring-2 transition-all duration-200">
                                <span class="text-gray-700 group-hover:text-gray-900 font-medium">Intolerancia al
                                    sorbitol</span>
                            </label>

                            <label
                                class="group flex items-center gap-3 p-3 rounded-xl hover:bg-white/70 transition-all duration-200 cursor-pointer">
                                <input type="checkbox" id="is_casein_intolerant" name="is_casein_intolerant"
                                    class="w-5 h-5 text-purple-600 bg-white border-2 border-gray-300 rounded-lg focus:ring-purple-500 focus:ring-2 transition-all duration-200">
                                <span class="text-gray-700 group-hover:text-gray-900 font-medium">Intolerancia a la
                                    caseína</span>
                            </label>

                            <label
                                class="group flex items-center gap-3 p-3 rounded-xl hover:bg-white/70 transition-all duration-200 cursor-pointer">
                                <input type="checkbox" id="is_egg_intolerant" name="is_egg_intolerant"
                                    class="w-5 h-5 text-purple-600 bg-white border-2 border-gray-300 rounded-lg focus:ring-purple-500 focus:ring-2 transition-all duration-200">
                                <span class="text-gray-700 group-hover:text-gray-900 font-medium">Intolerancia al
                                    huevo</span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer del modal -->
            <div class="bg-gray-50/80 backdrop-blur-sm p-6 flex justify-end gap-3 border-t border-gray-200/50">
                <button type="button" id="cancelarPreferenciasBtn"
                    class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 cursor-pointer">
                    Cancelar
                </button>
                <button type="submit" form="formPreferencias"
                    class="px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 text-white rounded-xl font-medium shadow-lg transition-all duration-300 transform hover:scale-105 cursor-pointer">
                    Guardar Preferencias
                </button>
            </div>
        </div>
    </div>

    <!-- Toast de éxito mejorado -->
    <div id="toast-success"
        class="fixed top-33 right-[-100%] z-[9999] backdrop-blur-xl bg-green-500/90 text-white px-6 py-4 rounded-2xl shadow-2xl transition-all duration-500 ease-out border border-green-400/30 flex items-center gap-3">
        <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">

        </div>
        <span class="font-medium"></span>
    </div>

    @push('scripts')
        <script>
            window.generarPlanUrl = "{{ route('plan.generar') }}";
            window.planesUrl = "{{ route('planes') }}";
        </script>
        <script src="{{ asset('js/chat-equilibria.js') }}"></script>
        <script src="{{ asset('js/cambiar-platos.js') }}"></script>
        <script src="{{ asset('js/preferencias.js') }}"></script>

        <!-- Estilos CSS adicionales -->
        <style>
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(50px) scale(0.95);
                }

                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            /* Scroll personalizado */
            ::-webkit-scrollbar {
                width: 8px;
            }

            ::-webkit-scrollbar-track {
                background: rgba(0, 0, 0, 0.05);
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb {
                background: linear-gradient(to bottom, #10b981, #0891b2);
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(to bottom, #059669, #0e7490);
            }

            /* Efectos adicionales */
            .hover\:shadow-3xl:hover {
                box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
            }

            .animate-fadeIn {
                animation: fadeIn 0.3s ease-out;
            }

            .animate-slideUp {
                animation: slideUp 0.4s ease-out;
            }

            /* Scroll personalizado para el chat */
            #chat-box::-webkit-scrollbar {
                width: 6px;
            }

            #chat-box::-webkit-scrollbar-track {
                background: rgba(0, 0, 0, 0.05);
                border-radius: 10px;
            }

            #chat-box::-webkit-scrollbar-thumb {
                background: linear-gradient(to bottom, #10b981, #0891b2);
                border-radius: 10px;
            }

            #chat-box::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(to bottom, #059669, #0e7490);
            }

            /* Efectos de hover para checkboxes */
            input[type="checkbox"]:checked {
                background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='m13.854 3.646-7.5 7.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6 10.293l7.146-7.147a.5.5 0 0 1 .708.708z'/%3e%3c/svg%3e");
            }

            /* Animación suave para elementos interactivos */
            .group:hover .group-hover\:opacity-100 {
                opacity: 1;
            }

            /* Efectos de profundidad para botones */
            button:active {
                transform: scale(0.98);
            }
        </style>
    @endpush
@endsection