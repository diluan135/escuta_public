<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\EnquetesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinhasController;
use App\Http\Controllers\MensagemController;
use App\Http\Controllers\TestController;
<<<<<<< HEAD
use App\Events\TesteDeConexao;
use App\Http\Controllers\FAQController;
use Illuminate\Http\Request;

Route::post('/api/teste-conexao', function (Request $request) {
    $mensagem = $request->input('mensagem', 'Mensagem padrão');
    event(new TesteDeConexao($mensagem));
    return response()->json(['status' => 'Evento de conexão enviado']);
});

=======
>>>>>>> 0cedd0c (implementação da merda do websocket)

// ------------------------------------------------------ OUTROS  ----------------------------------------------------------

Route::get('/', [HomeController::class, 'index'])->name('home');    // REDIRECT PRO INICIO
Route::get('api/linhas', [LinhasController::class, 'index']);       // PUXAR AS LINHAS

Route::post('/api/test-event', [TestController::class, 'sendEvent']);



// ------------------------------------------------------ LOGIN ----------------------------------------------------------

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index')->name('login.index');
    Route::post('/login', 'store')->name('login.store');
    Route::post('/logout', 'destroy')->name('login.destroy');
    Route::get('/registro', 'showRegistroForm')->name('login.registro.form'); // Adiciona esta rota para exibir o formulário
    Route::post('/registro', 'registro')->name('login.registro');
});

Route::middleware('auth')->get('/api/user', function () {           // PUXAR DADOS DO USUARIO APÓS AUTENTICAR
    return auth()->user();                                          // ta apontando erro mas funciona
});

// ------------------------------------------------------ CHAT & MENSAGEM ----------------------------------------------------------

Route::get('/api/chat', [ChatController::class, 'index']);
Route::post('/api/chat/newChat', [ChatController::class, 'newChat']);

Route::post('/api/mensagem/enviarMensagem', [MensagemController::class, 'enviarMensagem']);
Route::get('/api/mensagem', [MensagemController::class, 'index']);

// ------------------------------------------------------ ENQUETES ----------------------------------------------------------

Route::get('/api/enquetes', [EnquetesController::class, 'index']);
Route::post('/api/votar', [EnquetesController::class, 'voto']);


// ------------------------------------------------------ FAQ ----------------------------------------------------------

Route::get('/api/FAQ/get', [FAQController::class, 'index']);