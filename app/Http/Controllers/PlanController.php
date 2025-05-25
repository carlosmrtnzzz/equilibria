<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\WeeklyPlan;
use App\Models\Preference;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\ChatMessage;
use App\Models\Achievement;
use App\Models\UserAchievement;
class PlanController extends Controller
{
    public function generar(Request $request)
    {
        $user = Auth::user();
        $preferencias = Preference::where('user_id', $user->id)->first();

        $prompt = "Eres un nutricionista. Genera un plan de comidas semanal personalizado para una persona con los siguientes datos:\n";

        $prompt .= "Edad: {$user->age}\n";
        $prompt .= "Peso: {$user->weight_kg} kg\n";
        $prompt .= "Altura: {$user->height_cm} cm\n";
        $prompt .= "Género: {$user->gender}\n";
        if ($preferencias) {
            if ($preferencias->is_celiac)
                $prompt .= "Es celíaco.\n";
            if ($preferencias->is_lactose_intolerant)
                $prompt .= "Es intolerante a la lactosa.\n";
            if ($preferencias->disliked_foods)
                $prompt .= "No le gusta comer: {$preferencias->disliked_foods}.\n";
        }

        $prompt .= "Devuelve ÚNICAMENTE el plan en formato JSON con esta estructura exacta:\n\n";
        $prompt .= "{\n";
        $prompt .= "  \"lunes\": {\n    \"desayuno\": \"...\",\n    \"comida\": \"...\",\n    \"cena\": \"...\"\n  },\n";
        $prompt .= "  \"martes\": { \"desayuno\": \"...\" },\n  ... hasta domingo\n";
        $prompt .= "}\n\n";
        $prompt .= "No incluyas ninguna explicación ni texto adicional fuera del JSON.";

        try {
            $response = Http::withToken(config('services.openai.key'))->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un asistente nutricional llamado Equilibria.'],
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

            $hayVacio = false;
            foreach ($planJson as $dia => $comidas) {
                foreach (['desayuno', 'comida', 'cena'] as $tipo) {
                    if (!isset($comidas[$tipo]) || trim($comidas[$tipo]) === '') {
                        $hayVacio = true;
                        break 2;
                    }
                }
            }

            if ($hayVacio) {
                Log::warning('El plan contiene campos vacíos, se va a regenerar automáticamente.');
                return $this->generar($request);
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
                'start_date' => $inicioSemana->format('d/m/Y'),
                'end_date' => $finSemana->format('d/m/Y'),
            ]);

            $nombrePdf = 'plan_' . $plan->id . '.pdf';
            $path = 'planes/' . $nombrePdf;

            Storage::disk('public')->put($path, $pdf->output());

            $plan->pdf_url = 'storage/' . $path;
            $plan->save();

            ChatMessage::create([
                'user_id' => $user->id,
                'role' => 'user',
                'content' => 'Generar un plan semanal personalizado',
            ]);

            $mensajeIA = "Aquí tienes tu plan semanal.<br>" .
                "<a href='" . asset('storage/' . $path) . "' target='_blank' class='underline text-sm text-emerald-800 hover:text-emerald-900'>📄 Descargar Plan en PDF</a><br>" .
                "<span class='text-sm text-gray-600'>También puedes verlo en <a href='" . route('planes') . "' class='underline'>Planes</a>.</span>";

            ChatMessage::create([
                'user_id' => $user->id,
                'role' => 'assistant',
                'content' => $mensajeIA,
            ]);

            try {
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

                    Log::info("LOGRO: {$logro->name} | progreso actual: {$userLogro->progress} / {$logro->target_value} | desbloqueado: " . ($userLogro->unlocked ? 'sí' : 'no'));

                    if (!$userLogro->unlocked) {
                        $userLogro->progress += 1;
                        Log::info("➡️ Después de incrementar: progress={$userLogro->progress}");

                        if ($userLogro->progress >= $logro->target_value) {
                            Log::info("✅ Logro desbloqueado: {$logro->name}");

                            $userLogro->unlocked = true;
                            $userLogro->unlocked_at = now();

                            if ($logro->reward_type && $logro->reward_amount) {
                                if ($logro->reward_type === 'extra_swap') {
                                    $user->increment('extra_swaps', $logro->reward_amount);
                                } elseif ($logro->reward_type === 'extra_regeneration') {
                                    $user->increment('extra_regenerations', $logro->reward_amount);
                                }
                            }

                            session()->flash('success', '¡Has desbloqueado el logro: ' . $logro->name . '!');
                        }
                        Log::info("💾 Guardando progreso de logro: {$logro->name}");

                        $userLogro->save();
                    }
                }
                Log::info("➡️ Revisando logro: {$logro->name}");
                Log::info("➡️ Antes: progress={$userLogro->progress}, unlocked=" . ($userLogro->unlocked ? 'sí' : 'no') . ", target={$logro->target_value}");

            } catch (\Throwable $e) {
                Log::error('ERROR EN BLOQUE DE LOGROS: ' . $e->getMessage());
            }

            return response()->json([
                'mensaje' => "Aquí tienes tu plan semanal.",
                'pdf_url' => asset('storage/' . $path),
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

        return response()->json([
            'meals' => json_decode($plan->meals_json, true),
            'changes_left' => $plan->changes_left,
        ]);
    }

    public function reemplazarPlatos(Request $request)
    {
        $request->validate([
            'platos' => 'required|array|max:3',
            'platos.*.dia' => 'required|string',
            'platos.*.tipo' => 'required|string',
        ]);

        $user = Auth::user();
        $plan = WeeklyPlan::where('user_id', $user->id)->latest()->first();

        if (!$plan) {
            return response()->json(['error' => 'No tienes un plan activo.'], 404);
        }

        if ($plan->changes_left <= 0) {
            return response()->json(['error' => 'Ya has usado todos tus intentos.'], 403);
        }

        if (count($request->platos) > $plan->changes_left) {
            return response()->json([
                'error' => "Solo te quedan {$plan->changes_left} intento(s), pero intentas cambiar " . count($request->platos) . " plato(s)."
            ], 403);
        }

        $originalPlan = json_decode($plan->meals_json, true);
        $platosAReemplazar = $request->input('platos');

        $prompt = "Eres un nutricionista. Reemplaza únicamente los siguientes platos por otros equivalentes y saludables:\n";

        foreach ($platosAReemplazar as $p) {
            $prompt .= ucfirst($p['dia']) . " - " . ucfirst($p['tipo']) . ": " . $originalPlan[$p['dia']][$p['tipo']] . "\n";
        }

        $prompt .= "\nDevuelve ÚNICAMENTE un JSON con esta estructura exacta (respetando el número y formato de llaves):\n{\n";

        $estructuraEsperada = [];
        foreach ($platosAReemplazar as $p) {
            if (!isset($estructuraEsperada[$p['dia']])) {
                $estructuraEsperada[$p['dia']] = [];
            }
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

        try {
            $response = Http::withToken(config('services.openai.key'))->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un asistente nutricional llamado Equilibria.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            $data = $response->json();
            $planNuevo = $data['choices'][0]['message']['content'] ?? '';

            if (!preg_match('/\{.*\}/s', $planNuevo, $match)) {
                return response()->json(['error' => 'La IA no devolvió un JSON válido.'], 500);
            }

            $nuevoJson = json_decode($match[0], true);
            if (!$nuevoJson) {
                return response()->json(['error' => 'Error al parsear el JSON devuelto.'], 500);
            }

            foreach ($platosAReemplazar as $p) {
                if (isset($nuevoJson[$p['dia']][$p['tipo']])) {
                    $originalPlan[$p['dia']][$p['tipo']] = $nuevoJson[$p['dia']][$p['tipo']];
                }
            }

            $plan->meals_json = json_encode($originalPlan);
            $plan->changes_left -= count($platosAReemplazar);

            $pdf = Pdf::loadView('pages.plan_pdf', [
                'meals' => $originalPlan,
                'start_date' => Carbon::parse($plan->start_date)->format('d/m/Y'),
                'end_date' => Carbon::parse($plan->end_date)->format('d/m/Y'),
            ]);

            $nombrePdf = 'plan_' . $plan->id . '.pdf';
            $path = 'planes/' . $nombrePdf;
            Storage::disk('public')->put($path, $pdf->output());
            $plan->pdf_url = 'storage/' . $path;
            $plan->save();

            $mensajeIA = "He actualizado los platos seleccionados. Te quedan <strong>{$plan->changes_left}</strong> intento(s).";
            "<a href='" . asset('storage/' . $path) . "' target='_blank' class='underline text-sm text-emerald-800 hover:text-emerald-900'>📄 Descargar Plan en PDF</a><br>" .
                "<span class='text-sm text-gray-600'>También puedes verlo en <a href='" . route('planes') . "' class='underline'>Planes</a>.</span>";

            ChatMessage::create([
                'user_id' => $user->id,
                'role' => 'assistant',
                'content' => $mensajeIA,
            ]);

            return response()->json([
                'success' => true,
                'nuevo_plan' => $originalPlan,
                'changes_left' => $plan->changes_left,
                'pdf_url' => asset('storage/' . $path),
            ]);

        } catch (\Exception $e) {
            Log::error('Error reemplazando platos: ' . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al contactar con la IA.'], 500);
        }
    }
}
