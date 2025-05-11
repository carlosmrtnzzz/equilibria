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
class PlanController extends Controller
{
    public function generar(Request $request)
    {
        $user = Auth::user();
        $preferencias = Preference::where('user_id', $user->id)->first();

        // Construimos el prompt
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

            // Extraer sólo el JSON, ignorando texto adicional
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


            // Guardar en base de datos
            $plan = WeeklyPlan::create([
                'user_id' => $user->id,
                'start_date' => Carbon::today(),
                'end_date' => Carbon::today()->addDays(6),
                'meals_json' => json_encode($planJson),
                'pdf_url' => null,
                'changes_left' => 3,
            ]);

            // Crear PDF
            $pdf = Pdf::loadView('pages.plan_pdf', [
                'meals' => $planJson,
                'start_date' => Carbon::today()->format('d/m/Y'),
                'end_date' => Carbon::today()->addDays(6)->format('d/m/Y'),
            ]);

            $nombrePdf = 'plan_' . $plan->id . '.pdf';
            $path = 'planes/' . $nombrePdf;

            // Guardar PDF en storage/app/public/planes
            Storage::disk('public')->put($path, $pdf->output());

            // Actualizar la URL en la base de datos
            $plan->pdf_url = 'storage/' . $path;
            $plan->save();

            // Guardar el mensaje en la base de datos para el historial del chat
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


            return redirect()->route('chat')->with([
                'respuesta_chat' => "Aquí tienes tu plan semanal. Puedes descargarlo directamente o verlo en la sección de Planes.",
                'pdf_url' => asset('storage/' . $path),
            ]);


        } catch (\Exception $e) {
            Log::error('Error al generar plan: ' . $e->getMessage());
            return back()->with('error', 'Error al contactar con OpenAI.');
        }
    }
    public function index()
    {
        // Si no ha completado el registro aún (no está logueado pero tiene datos en sesión)
        if (!Auth::check()) {
            if (session()->has('register_email')) {
                return redirect()->route('register')->with('message', 'Debes registrarte para acceder a los planes.');
            }
            // Si no hay sesión ni login, simplemente mándalo al registro
            return redirect()->route('register')->with('message', 'Debes registrarte para acceder a los planes.');
        }

        // Si está autenticado, carga sus planes
        $user = Auth::user();
        $planes = WeeklyPlan::where('user_id', $user->id)->latest()->get();

        return view('pages.planes', compact('planes'));
    }

}
