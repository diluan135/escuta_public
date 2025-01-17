<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ChatPublicar;
use App\Models\MensagemPublicar;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index(){
        // Buscar todos os chats publicados
        $chats = ChatPublicar::where('publicado', 1)->get();

        // Inicializar um array para armazenar chats e suas mensagens
        $result = [];

        // Iterar sobre os chats para buscar suas mensagens
        foreach ($chats as $chat) {
            // Buscar as mensagens publicadas para cada chat
            $mensagens = MensagemPublicar::where('chatPublicado_id', $chat->id)->where('publicado', 1)->get();

            // Adicionar o chat e suas mensagens ao array resultante
            $result[] = [
                'chat' => $chat,
                'mensagens' => $mensagens
            ];
        }

        // Retornar os chats e suas mensagens como JSON
        return response()->json($result);
    }
}
