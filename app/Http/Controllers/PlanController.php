<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\WeeklyPlan;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\ChatMessage;
use App\Models\Achievement;
use App\Models\UserAchievement;
use App\Models\Preference;

class PlanController extends Controller
{
    private function getCalorieAdjustment($user)
    {
        // Cálculo base del BMR (Basal Metabolic Rate) usando la fórmula de Harris-Benedict
        $bmr = $user->gender === 'male'
            ? (88.362 + (13.397 * $user->weight_kg) + (4.799 * $user->height_cm) - (5.677 * $user->age))
            : (447.593 + (9.247 * $user->weight_kg) + (3.098 * $user->height_cm) - (4.330 * $user->age));

        // Ajuste según el objetivo
        switch ($user->goal) {
            case 'lose_weight':
                return $bmr * 0.85; // Déficit calórico del 15%
            case 'gain_weight':
                return $bmr * 1.15; // Superávit calórico del 15%
            case 'maintain':
            default:
                return $bmr; // Mantenimiento
        }
    }

    public function generar()
    {
        $dateFormat = 'd/m/Y';
        $storagePath = 'storage/';
        $user = Auth::user();

        // Calcular inicio y fin de la semana actual
        $inicioSemana = Carbon::now()->startOfWeek(\Carbon\CarbonInterface::MONDAY);
        $finSemana = $inicioSemana->copy()->addDays(6);

        // Comprobar si ya existe un plan para esta semana
        $planExistente = WeeklyPlan::where('user_id', $user->id)
            ->whereDate('start_date', $inicioSemana)
            ->whereDate('end_date', $finSemana)
            ->first();

        if ($planExistente) {
            return response()->json([
                'error' => 'Ya has generado un plan para esta semana. Solo puedes crear uno por semana.'
            ], 403);
        }

        // Cargar preferencias del usuario
        $preferences = Preference::where('user_id', $user->id)->first();
        $textoIntolerancias = $this->getIntoleranciasPromptText($preferences);

        $objetivo = [
            'lose_weight' => 'enfocado en pérdida de peso saludable',
            'maintain' => 'enfocado en mantener el peso actual',
            'gain_weight' => 'enfocado en ganancia de peso saludable'
        ][$user->goal] ?? '';

        $prompt = <<<PROMPT
Actúa como un nutricionista clínico especializado en intolerancias alimentarias. Tu tarea es generar un plan de comidas semanal completamente adaptado al siguiente perfil del usuario:

Edad: {$user->age}
Peso: {$user->weight_kg} kg
Altura: {$user->height_cm} cm
Género: {$user->gender}

{$textoIntolerancias}

Este plan debe estar {$objetivo}.

Solo debes aplicar restricciones si han sido indicadas por el usuario. NO apliques restricciones como “sin lactosa” o “sin gluten” si no se han marcado.

Devuelve exclusivamente un JSON con esta estructura exacta (5 comidas por día, de lunes a domingo):

{
  "lunes": {
    "desayuno": "string",
    "media-mañana": "string",
    "comida": "string",
    "merienda": "string",
    "cena": "string"
  },
  ...
  "domingo": { ... }
}

No incluyas ningún texto adicional, encabezado ni explicación. SOLO el JSON exacto.
PROMPT;


        try {
            $response = Http::withToken(config('services.openai.key'))->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un nutricionista profesional que crea planes de alimentación seguros. Tienes prohibido recomendar alimentos que no se adapten a las intolerancias del usuario. Tu prioridad es evitar cualquier riesgo para su salud.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            $data = $response->json();

            if (!isset($data['choices'][0]['message']['content'])) {
                Log::error('OpenAI no devolvió contenido válido', $data);
                return back()->with('error', 'No se pudo generar el plan.');
            }

            $planTexto = $data['choices'][0]['message']['content'];

            if (preg_match('/\{.*\}/s', $planTexto, $coincidencias)) {
                $jsonLimpio = $coincidencias[0];
                $planJson = json_decode($jsonLimpio, true);
            } else {
                Log::error('No se encontró JSON válido en la respuesta', ['respuesta' => $planTexto]);
                return back()->with('error', 'El plan generado no tiene el formato esperado.');
            }

            if (!$planJson || !isset($planJson['lunes'])) {
                Log::error('El JSON no tiene la estructura esperada', ['json' => $planJson]);
                return back()->with('error', 'El plan generado no tiene el formato esperado.');
            }

            $inicioSemana = Carbon::now()->startOfWeek(\Carbon\CarbonInterface::MONDAY);
            $finSemana = $inicioSemana->copy()->addDays(6);

            $plan = WeeklyPlan::create([
                'user_id' => $user->id,
                'start_date' => $inicioSemana,
                'end_date' => $finSemana,
                'meals_json' => json_encode($planJson),
                'pdf_url' => null,
                'changes_left' => 3,
            ]);

            $pdf = Pdf::loadView('pages.plan_pdf', [
                'meals' => $planJson,
                'start_date' => $inicioSemana->format($dateFormat),
                'end_date' => $finSemana->format($dateFormat),
            ]);

            $nombrePdf = 'plan_' . $plan->id . '.pdf';
            $path = 'planes/' . $nombrePdf;

            Storage::disk('public')->put($path, $pdf->output());

            $plan->pdf_url = $storagePath . $path;
            $plan->save();

            ChatMessage::create([
                'user_id' => $user->id,
                'role' => 'user',
                'content' => 'Generar un plan semanal personalizado',
            ]);

            $mensajeIA = '<div class="bg-gradient-to-r from-emerald-50 to-green-50 p-4 rounded-lg border border-emerald-200 shadow-sm">' .
                '<div class="space-y-3">' .
                '<p class="text-gray-800 font-medium">' .
                '¡Tu plan semanal está listo!' .
                '</p>' .

                '<div class="flex items-center gap-2">' .
                '<a href="' . asset($storagePath . $path) . '" ' .
                'target="_blank" ' .
                'class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">' .
                '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">' .
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />' .
                '</svg>' .
                'Descargar PDF' .
                '</a>' .
                '</div>' .

                '<p class="text-xs text-gray-500">' .
                'También puedes consultar todos tus planes en ' .
                '<a href="' . route('planes') . '" ' .
                'class="text-emerald-600 hover:text-emerald-700 underline font-medium transition-colors duration-200">' .
                'Mi Panel de Planes' .
                '</a>' .
                '</p>' .
                '</div>' .
                '</div>';

            ChatMessage::create([
                'user_id' => $user->id,
                'role' => 'assistant',
                'content' => $mensajeIA,
            ]);

            try {
                $logrosDesbloqueados = [];
                $logros = Achievement::where('type', 'generate_plan')->get();

                foreach ($logros as $logro) {
                    $userLogro = UserAchievement::firstOrNew([
                        'user_id' => $user->id,
                        'achievement_id' => $logro->id,
                    ]);

                    if (!$userLogro->exists) {
                        $userLogro->progress = 0;
                        $userLogro->unlocked = false;
                    }

                    if (!$userLogro->unlocked) {
                        $userLogro->progress += 1;

                        if ($userLogro->progress >= $logro->target_value) {

                            $userLogro->unlocked = true;
                            $userLogro->unlocked_at = now();

                            if ($logro->reward_type && $logro->reward_amount) {
                                if ($logro->reward_type === 'extra_swap') {
                                    $user->increment('extra_swaps', $logro->reward_amount);
                                } elseif ($logro->reward_type === 'extra_regeneration') {
                                    $user->increment('extra_regenerations', $logro->reward_amount);
                                }
                            }

                            $logrosDesbloqueados[] = '¡Has desbloqueado el logro: ' . $logro->name . '!';
                        }

                        $userLogro->save();
                    }
                }

            } catch (\Throwable $e) {
                Log::error('ERROR EN BLOQUE DE LOGROS: ' . $e->getMessage());
            }

            return response()->json([
                'mensaje' => "Aquí tienes tu plan semanal.",
                'pdf_url' => asset($storagePath . $path),
                'logros' => $logrosDesbloqueados,
            ]);


        } catch (\Exception $e) {
            Log::error('Error al generar plan: ' . $e->getMessage());
            return back()->with('error', 'Error al contactar con OpenAI.');
        }
    }
    public function index()
    {
        if (!Auth::check()) {
            if (session()->has('register_email')) {
                return redirect()->route('register')->with('message', 'Debes registrarte para acceder a los planes.');
            }
            return redirect()->route('register')->with('message', 'Debes registrarte para acceder a los planes.');
        }

        $user = Auth::user();
        $planes = WeeklyPlan::where('user_id', $user->id)->latest()->get();

        return view('pages.planes', compact('planes'));
    }

    public function planActual()
    {
        $plan = WeeklyPlan::where('user_id', Auth::id())->latest()->first();

        if (!$plan) {
            return response()->json(['error' => 'No tienes un plan aún.'], 404);
        }

        // Comprobar si el plan es de la semana actual
        $inicioSemana = Carbon::now()->startOfWeek(\Carbon\CarbonInterface::MONDAY);
        $finSemana = $inicioSemana->copy()->addDays(6);

        $esPlanActual = $plan->start_date == $inicioSemana->toDateString() && $plan->end_date == $finSemana->toDateString();

        return response()->json([
            'meals' => json_decode($plan->meals_json, true),
            'changes_left' => $plan->changes_left,
            'es_plan_actual' => $esPlanActual,
        ]);
    }

    public function reemplazarPlatos(Request $request)
    {
        $dateFormat = 'd/m/Y';
        $storagePath = 'storage/';

        $request->validate([
            'platos' => 'required|array|max:3',
            'platos.*.dia' => 'required|string',
            'platos.*.tipo' => 'required|string',
        ]);

        $user = Auth::user();

        $preferences = Preference::where('user_id', $user->id)->first();
        $textoIntolerancias = $this->getIntoleranciasPromptText($preferences);

        $plan = WeeklyPlan::where('user_id', $user->id)->latest()->first();

        if (!$plan) {
            return response()->json(['error' => 'No tienes un plan activo.'], 404);
        }

        if ($plan->changes_left <= 0) {
            return response()->json(['error' => 'Ya has usado todos tus cambios.'], 403);
        }

        $platosAReemplazar = $request->input('platos');
        if (count($platosAReemplazar) > $plan->changes_left) {
            return response()->json([
                'error' => "Solo te quedan {$plan->changes_left} cambio(s), pero intentas cambiar " . count($platosAReemplazar) . " plato(s)."
            ], 403);
        }

        $originalPlan = json_decode($plan->meals_json, true);
        $prompt = $this->buildPrompt($platosAReemplazar, $originalPlan, $textoIntolerancias);

        try {
            $nuevoJson = $this->getNuevosPlatosFromIA($prompt);
            if (!$nuevoJson) {
                return response()->json(['error' => 'La IA no devolvió un JSON válido.'], 500);
            }

            $this->actualizaPlatos($originalPlan, $nuevoJson, $platosAReemplazar);

            $plan->meals_json = json_encode($originalPlan);
            $plan->changes_left -= count($platosAReemplazar);

            $pdf = Pdf::loadView('pages.plan_pdf', [
                'meals' => $originalPlan,
                'start_date' => Carbon::parse($plan->start_date)->format($dateFormat),
                'end_date' => Carbon::parse($plan->end_date)->format($dateFormat),
            ]);

            $nombrePdf = 'plan_' . $plan->id . '.pdf';
            $path = 'planes/' . $nombrePdf;
            Storage::disk('public')->put($path, $pdf->output());
            $plan->pdf_url = $storagePath . $path;
            $plan->save();

            $logrosDesbloqueados = $this->procesaLogrosChangeDish($user, $platosAReemplazar);

            $mensajeIA = "He actualizado los platos seleccionados. Te queda(n) <strong>{$plan->changes_left}</strong> cambio(s).<br>";

            ChatMessage::create([
                'user_id' => $user->id,
                'role' => 'assistant',
                'content' => $mensajeIA,
            ]);

            return response()->json([
                'success' => true,
                'nuevo_plan' => $originalPlan,
                'changes_left' => $plan->changes_left,
                'pdf_url' => asset($storagePath . $path),
                'logros' => $logrosDesbloqueados,
            ]);
        } catch (\Exception $e) {
            Log::error('Error reemplazando platos: ' . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al contactar con la IA.'], 500);
        }
    }

    /**
     * Construye el prompt para la IA.
     */
    private function buildPrompt(array $platosAReemplazar, array $originalPlan, string $textoIntolerancias = ''): string
    {
        $prompt = "Eres un nutricionista. Reemplaza únicamente los siguientes platos por otros equivalentes y saludables:\n";
        if ($textoIntolerancias) {
            $prompt .= $textoIntolerancias;
        }
        foreach ($platosAReemplazar as $p) {
            $prompt .= ucfirst($p['dia']) . " - " . ucfirst($p['tipo']) . ": " . $originalPlan[$p['dia']][$p['tipo']] . "\n";
        }
        $prompt .= "\nDevuelve ÚNICAMENTE un JSON con esta estructura exacta (respetando el número y formato de llaves):\n{\n";

        $estructuraEsperada = [];
        foreach ($platosAReemplazar as $p) {
            $estructuraEsperada[$p['dia']][] = $p['tipo'];
        }
        foreach ($estructuraEsperada as $dia => $tipos) {
            $prompt .= "  \"$dia\": {\n";
            foreach ($tipos as $i => $tipo) {
                $coma = $i < count($tipos) - 1 ? ',' : '';
                $prompt .= "    \"$tipo\": \"...\"$coma\n";
            }
            $prompt .= "  },\n";
        }
        $prompt .= "}\n\n";
        $prompt .= "No incluyas ninguna explicación ni comentario adicional. Solo el JSON exacto con los nuevos platos reemplazados. No dejes ninguno fuera.";
        return $prompt;
    }

    /**
     * Llama a la IA y devuelve el JSON de platos nuevos.
     */
    private function getNuevosPlatosFromIA(string $prompt): ?array
    {
        $response = Http::withToken(config('services.openai.key'))->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Eres un nutricionista profesional que crea planes de alimentación seguros. Tienes prohibido recomendar alimentos que no se adapten a las intolerancias del usuario. Tu prioridad es evitar cualquier riesgo para su salud.'],
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);
        $data = $response->json();
        $planNuevo = $data['choices'][0]['message']['content'] ?? '';
        if (!preg_match('/\{.*\}/s', $planNuevo, $match)) {
            return null;
        }
        $nuevoJson = json_decode($match[0], true);
        return $nuevoJson ?: null;
    }

    /**
     * Actualiza los platos en el plan original con los nuevos.
     */
    private function actualizaPlatos(array &$originalPlan, array $nuevoJson, array $platosAReemplazar): void
    {
        foreach ($platosAReemplazar as $p) {
            if (isset($nuevoJson[$p['dia']][$p['tipo']])) {
                $originalPlan[$p['dia']][$p['tipo']] = $nuevoJson[$p['dia']][$p['tipo']];
            }
        }
    }

    /**
     * Procesa los logros relacionados con el cambio de platos.
     */
    private function procesaLogrosChangeDish($user, $platosAReemplazar): array
    {
        $logrosDesbloqueados = [];
        try {
            $logros = Achievement::where('type', 'change_dish')->get();
            foreach ($logros as $logro) {
                $userLogro = UserAchievement::firstOrNew([
                    'user_id' => $user->id,
                    'achievement_id' => $logro->id,
                ]);
                if (!$userLogro->exists) {
                    $userLogro->progress = 0;
                    $userLogro->unlocked = false;
                }
                if (!$userLogro->unlocked) {
                    $userLogro->progress += count($platosAReemplazar);
                    if ($userLogro->progress >= $logro->target_value) {
                        $userLogro->unlocked = true;
                        $userLogro->unlocked_at = now();
                        if ($logro->reward_type && $logro->reward_amount) {
                            if ($logro->reward_type === 'extra_swap') {
                                $user->increment('extra_swaps', $logro->reward_amount);

                                $plan = WeeklyPlan::where('user_id', $user->id)->latest()->first();
                                $plan->increment('changes_left', $logro->reward_amount);

                            }
                        }
                        $logrosDesbloqueados[] = '¡Has desbloqueado el logro: ' . $logro->name . '!';
                    }
                    $userLogro->save();
                }
            }
        } catch (\Throwable $e) {
            Log::error('ERROR EN BLOQUE DE LOGROS (change_dish): ' . $e->getMessage());
        }
        return $logrosDesbloqueados;
    }

    private function getIntoleranciasPromptText($preferences)
    {
        $tipos = [
            [
                'key' => 'is_celiac',
                'nombre' => 'gluten',
                'extra' => function () {
                    return "Prohíbe cualquier alimento que contenga gluten (trigo, cebada, centeno, espelta, etc.). Usa solo productos certificados sin gluten. ";
                }
            ],
            [
                'key' => 'is_lactose_intolerant',
                'nombre' => 'lactosa',
                'extra' => function () {
                    return "Prohíbe cualquier lácteo que contenga lactosa. Solo usa lácteos sin lactosa cuando sea necesario. ";
                }
            ],
            [
                'key' => 'is_fructose_intolerant',
                'nombre' => 'fructosa',
                'extra' => function () {
                    return "El usuario es INTOLERANTE a la FRUCTOSA. Está TERMINANTEMENTE PROHIBIDO incluir ningún alimento que contenga fructosa, sacarosa o sorbitol, ni siquiera en pequeñas cantidades. Prohíbe absolutamente:

- Frutas: plátano, manzana, pera, mango, piña, sandía, melón, uvas, cerezas, higos, coco, aguacate, fresa.
- Verduras: tomate (con o sin semillas), cebolla (todas las partes), alcachofa, espárragos, pimiento, remolacha, brócoli, coliflor, espinacas cocinadas, puerros, rúcula, jícama, apio.
- Otros: pan integral, pan de centeno, miel, mermeladas, zumos, galletas sin azúcar, edulcorantes como sorbitol (E420), comidas ambiguas o preparadas.

Solo están permitidos ingredientes seguros como arroz blanco, patata, calabacín, zanahoria cocida, pepino, escarola, acelga, huevo, pollo, ternera, pescado blanco, nueces y almendras naturales.

⚠️ Si algún ingrediente genera dudas, NO lo incluyas. Estas instrucciones son obligatorias.";
                }
            ],
            [
                'key' => 'is_histamine_intolerant',
                'nombre' => 'histamina',
                'extra' => function () {
                    return "Evita alimentos ricos en histamina como pescado azul, embutidos, quesos curados, tomate, espinacas y berenjena. ";
                }
            ],
            [
                'key' => 'is_sorbitol_intolerant',
                'nombre' => 'sorbitol',
                'extra' => function () {
                    return "Prohíbe alimentos y productos que contengan sorbitol (E420), como chicles, caramelos sin azúcar, peras, manzanas, ciruelas, etc. ";
                }
            ],
            [
                'key' => 'is_casein_intolerant',
                'nombre' => 'caseína',
                'extra' => function () {
                    return "Prohíbe cualquier producto lácteo o derivado que contenga caseína. ";
                }
            ],
            [
                'key' => 'is_egg_intolerant',
                'nombre' => 'huevo',
                'extra' => function () {
                    return "No incluyas huevo ni productos que lo contengan. ";
                }
            ],
        ];

        $intolerancias = [];
        $restricciones = '';

        foreach ($tipos as $tipo) {
            if ($preferences && !empty($preferences->{$tipo['key']})) {
                $intolerancias[] = $tipo['nombre'];
                $restricciones .= call_user_func($tipo['extra']);
            }
        }

        $texto = '';
        if (count($intolerancias)) {
            $texto .= "ATENCIÓN: El usuario tiene las siguientes intolerancias alimentarias: " . implode(', ', $intolerancias) . ". ";
            $texto .= "Solo debes aplicar restricciones si están explícitamente indicadas. NO apliques restricciones a ingredientes como lactosa, gluten u otros si no se mencionan aquí. ";
            $texto .= $restricciones;
            $texto .= "Si algún alimento genera dudas, no lo incluyas. Estas restricciones son OBLIGATORIAS.";
        }

        return $texto;
    }

}
