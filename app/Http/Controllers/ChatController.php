<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request)
    {   
        $id = $request->input('usuario_id');
        $data = Chat::where('usuario_id', $id)->get();
        return response()->json($data);
    }

    public function newChat(Request $request)
    {
        // Validação dos dados da requisição
        $validatedData = $request->validate([
            'usuario_id' => 'required|integer|exists:usuario,id',
            'tipo' => 'required|string|max:255',
            'assunto' => 'required|string|max:255',
        ]);

        // Criação de um novo registro de chat
        $chat = Chat::create([
            'usuario_id' => $validatedData['usuario_id'],
            'tipo' => $validatedData['tipo'],
            'assunto' => $validatedData['assunto'],
            'linha' => $request->input('linha'),
            'chat_status' => 'Nova solicitação',
        ]);

        // Retorno de uma resposta JSON com o novo registro criado
        return response()->json($chat, 201); // 201 Created
    
    }
}
