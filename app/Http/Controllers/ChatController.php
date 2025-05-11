<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function enviarMensaje(Request $request)
    {
        $request->validate([
            'mensaje' => 'required|string',
        ]);

        try {
            $response = Http::withToken(config('services.openai.key'))->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un asistente nutricional llamado Equilibria.'],
                    ['role' => 'user', 'content' => $request->mensaje],
                ],
            ]);
                      
            $data = $response->json();

            if (isset($data['choices'][0]['message']['content'])) {
                return response()->json(['respuesta' => $data['choices'][0]['message']['content']]);
            }

            Log::error('Respuesta incompleta de OpenAI', $data);
            return response()->json(['error' => 'No se pudo obtener una respuesta válida.'], 500);

        } catch (\Exception $e) {
            Log::error('Error al contactar con OpenAI: ' . $e->getMessage());
            return response()->json(['error' => 'Error en el servidor.'], 500);
        }
    }
}
