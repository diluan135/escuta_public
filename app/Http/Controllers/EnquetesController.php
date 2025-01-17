<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Enquete;
use App\Models\Opcoes;
use App\Models\Votos;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EnquetesController extends Controller
{
    public function index()
    {
        // Obtém o horário atual
        $currentTime = Carbon::now('America/Sao_Paulo');

        // Consulta as enquetes cuja coluna 'encerra_em' é menor que o horário atual
        $enquetes = Enquete::where('encerra_em', '>', $currentTime)->get();

        // Consulta as opções associadas às enquetes retornadas
        $opcoes = Opcoes::whereIn('enquete_id', $enquetes->pluck('id'))->get();

        // Retorna a lista de enquetes e opções
        return response()->json([
            'horario' => $currentTime->format('Y-m-d H:i:s'),
            'enquetes' => $enquetes,
            'opcoes' => $opcoes
        ]);
    }

    public function voto(Request $request)
    {
        $usuario_id = $request->input('usuario_id');
        $enquete_id = $request->input('enquetes_id');
        $opcao_id = $request->input('opcao_id');

        // Verificar se o usuário já votou na mesma enquete
        $votoExistente = Votos::where('usuario_id', $usuario_id)
            ->where('enquetes_id', $enquete_id)
            ->first();

        if ($votoExistente) {
            // Atualizar o voto existente com a nova opção
            $votoExistente->opcao_id = $opcao_id;
            $votoExistente->save();
            return response()->json(['message' => 'Voto alterado com sucesso.']);
        } else {
            // Criar um novo voto
            $novoVoto = new Votos();
            $novoVoto->usuario_id = $usuario_id;
            $novoVoto->enquetes_id = $enquete_id;
            $novoVoto->opcao_id = $opcao_id;
            $novoVoto->save();
        }

    }
}
