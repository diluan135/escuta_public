<?php

namespace App\Http\Controllers;

use App\Events\MensagemEnviada;
use App\Http\Controllers\Controller;
use App\Models\Mensagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MensagemController extends Controller
{
    public function index(Request $request)
    {
        try {
            $idChat = $request->input('chat_id');
            $mensagens = Mensagem::where('chat_id', $idChat)->get();
            return response()->json($mensagens);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function enviarMensagem(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'usuario_id' => 'required|integer|exists:usuario,id',
                'chat_id' => 'required|integer|exists:chat,id',
                'mensagem' => 'required|string|max:255',
            ]);

            $mensagem = Mensagem::create([
                'usuario_id' => $validatedData['usuario_id'],
                'chat_id' => $validatedData['chat_id'],
                'mensagem' => $validatedData['mensagem'],
            ]);

            // Dispara o evento de broadcast
            broadcast(new MensagemEnviada($mensagem));

            return response()->json($mensagem, 201);
        } catch (\Exception $e) {
            Log::error('Erro ao enviar mensagem: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao enviar mensagem.'], 500);
        }
    }
}
