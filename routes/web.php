<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\Turma;
use App\Models\User;
use App\Models\Monitoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    $usuario = Auth::user();
    $nome = '';

    if(isset($usuario)) {
        $nome = Auth::user()->nome;
    }

    return view('index', ['nome' => $nome]);
})->name('index');

//Rotas de login
Route::prefix('/login')->group(function() {
    Route::get('/{erro?}', [\App\Http\Controllers\LoginController::class, 'index'])->name('login');
    Route::post('/', [\App\Http\Controllers\LoginController::class, 'autenticacao'])->name('login');
    Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
});

Route::prefix('/profile')->group(function(){
    Route::get('/', [\App\Http\Controllers\profileController::class, 'index'])->middleware('auth')->name('profile');
    Route::put('/', [\App\Http\Controllers\profileController::class, 'atualizarDados'])->name('profile');
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
    Route::post('/', [\App\Http\Controllers\MonitoriasController::class, 'inscricaoMonitorias'])->name('inscricao')->middleware('verified');
    Route::get('/{id}', function($id) {
        $usuario = User::where('id', Auth::user()->id)->get()->first();
        $inscrito = null;
        if(isset($usuario)){
            $inscrito = $usuario->monitorias()->wherePivot('tipo', 'Inscrito')->get();
        }
        return view('informacoesMonitorias', ['monitoria' => Monitoria::where('id', $id)->get()->first(), 'usuarios' => User::all(), 'inscrito' => $inscrito]);
    })->whereNumber('id')->name('monitorias.informacoes');
    Route::get('/editar/{id}', function($id) {
        return view('editarMonitorias', ['monitoria' => Monitoria::where('id', $id)->get()->first()]);
    })->whereNumber('id')->name('monitorias.editar');
    Route::put('/editar/{id}', [\App\Http\Controllers\MonitoriasController::class, 'editarMonitoria'])->whereNumber('id')->name('monitorias.editar');
    Route::post('/cancelar-inscricao', [\App\Http\Controllers\MonitoriasController::class, 'cancelarInscricao'])->name('cancelamentoInscricao')->middleware('verified');
    Route::get('/cadastro', function() {
        return view('cadastroMonitorias');
    })->name('monitorias.cadastro')->middleware('verified');
    Route::post('/cadastro', [\App\Http\Controllers\MonitoriasController::class, 'cadastro'])->name('monitorias.cadastro');
    Route::post('/autocomplete', [\App\Http\Controllers\MonitoriasController::class, 'autocomplete'])->name('monitorias.autocomplete');
    Route::get('/cancelar', function() {
        $usuario = Auth::user()->id;
        $monitorias = User::find($usuario)->monitorias()->wherePivot('tipo', 'Criador')->get();

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