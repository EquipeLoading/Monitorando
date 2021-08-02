<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\Turma;
use App\Models\Monitoria;

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

Route::get('/', function() {
    $monitorias = Monitoria::all();
    return view('index', ['nome' => session()->get('nome'), 'monitorias' => $monitorias]);
})->name('index');

Route::prefix('/login')->group(function() {
    Route::get('/{locale?}/{erro?}', [\App\Http\Controllers\LoginController::class, 'index'])->name('login');
    Route::post('/{locale?}', [\App\Http\Controllers\LoginController::class, 'autenticacao'])->name('login');
});

Route::prefix('/cadastro')->group(function() {
    Route::get('/principal/{locale?}', [\App\Http\Controllers\CadastroController::class, 'index'])->name('cadastro');
    Route::get('/professor/{locale?}', function($locale = null) {
        app()->setLocale($locale);
        session()->put('locale', $locale);

        return view('cadastroProfessor', ['locale' => app()->getLocale()]);
    })->name('cadastro.professor');
    Route::post('/professor/{locale?}', [\App\Http\Controllers\CadastroController::class, 'cadastroProfessor'])->name('cadastro.professor');
    Route::get('/aluno/{locale?}', function($locale = null) {
        app()->setLocale($locale);
        session()->put('locale', $locale);

        $turmas = Turma::all();
        return view('cadastroAluno', ['locale' => app()->getLocale(), 'turmas' => $turmas]);
    })->name('cadastro.aluno');
    Route::post('/aluno/{locale?}', [\App\Http\Controllers\CadastroController::class, 'cadastroAluno'])->name('cadastro.aluno');
});

Route::get('/monitorias', [\App\Http\Controllers\MonitoriasController::class, 'index'])->name('monitorias');
Route::get('/monitorias/cadastro', function() {
    return view('cadastroMonitorias');
})->name('monitorias.cadastro')->middleware('verified');
Route::post('/monitorias/cadastro', [\App\Http\Controllers\MonitoriasController::class, 'cadastro'])->name('monitorias.cadastro');


Route::prefix('/email')->group(function() {
    Route::get('/verificacao/{locale?}', function($locale = null) {
        app()->getLocale($locale);

        return view('verificarEmail', ['locale' => app()->getLocale(), 'mensagem' => session()->get('mensagem')]);
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

Route::fallback(function() {
    echo __('lang.fallback');
});