<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\Turma;
use App\Models\Monitoria;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Rota da página principal
Route::get('/', function() {
    $monitorias = Monitoria::all();
    return view('index', ['nome' => session()->get('nome'), 'monitorias' => $monitorias]);
})->name('index');

//Rotas de login
Route::prefix('/login')->group(function() {
    Route::get('/{erro?}', [\App\Http\Controllers\LoginController::class, 'index'])->name('login');
    Route::post('/', [\App\Http\Controllers\LoginController::class, 'autenticacao'])->name('login');
});

//Rotas de cadastro
Route::prefix('/cadastro')->group(function() {
    Route::get('/', [\App\Http\Controllers\CadastroController::class, 'index'])->name('cadastro');
    Route::get('/professor', function() {
        return view('cadastroProfessor');
    })->name('cadastro.professor');
    Route::post('/professor', [\App\Http\Controllers\CadastroController::class, 'cadastroProfessor'])->name('cadastro.professor');
    Route::get('/aluno', function() {
        $turmas = Turma::all();
        return view('cadastroAluno', ['turmas' => $turmas]);
    })->name('cadastro.aluno');
    Route::post('/aluno', [\App\Http\Controllers\CadastroController::class, 'cadastroAluno'])->name('cadastro.aluno');
});

//Rotas das monitorias (cadastro e cancelamento)
Route::prefix('/monitorias')->group(function() {
    Route::get('/', [\App\Http\Controllers\MonitoriasController::class, 'index'])->name('monitorias');
    Route::get('/cadastro', function() {
        return view('cadastroMonitorias');
    })->name('monitorias.cadastro')->middleware('verified');
    Route::post('/cadastro', [\App\Http\Controllers\MonitoriasController::class, 'cadastro'])->name('monitorias.cadastro');
    Route::post('/autocomplete', [\App\Http\Controllers\MonitoriasController::class, 'autocomplete'])->name('monitorias.autocomplete');
    Route::get('/cancelar', function() {
        $usuario = Auth::user();
        $monitorias = Monitoria::where('user_id', $usuario->id)->get();

        return view('cancelarMonitoria', ['monitorias' => $monitorias]);
    })->name('monitorias.cancelar');
    Route::post('/cancelar', [\App\Http\Controllers\MonitoriasController::class, 'cancelar'])->name('monitorias.cancelar');
});

//Rotas de validação de email
Route::prefix('/email')->group(function() {
    Route::get('/verificacao', function() {

        return view('verificarEmail', ['mensagem' => session()->get('mensagem')]);
    })->middleware('auth')->name('verification.notice');
    Route::get('/verificacao/{id}/{hash}', function(EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/');
    })->middleware(['auth', 'signed'])->name('verification.verify');
    Route::post('/notificacao-de-verificacao', function(Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('mensagem', __('lang.mensagemEmailEnviado'));
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
});

//Rota de fallback
Route::fallback(function() {
    echo __('lang.fallback');
});