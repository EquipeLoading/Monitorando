<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\Usuario;
use App\Models\Turma;
use Illuminate\Support\Facades\App;
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
    if(session()->get('nome') != ''){
        return view('index', ['nome' => session()->get('nome')]);
    } else {
        return view('index', ['nome' => 'Desconhecido']);
    }
})->name('index');

Route::get('/login/{locale?}/{erro?}', [\App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::post('/login/{locale?}', [\App\Http\Controllers\LoginController::class, 'autenticacao'])->name('login');

Route::get('/cadastro/{tipo}/{locale?}', function($tipo) {
    if($tipo == 'professor') {
        return view('cadastroProfessor', ['locale' => app()->getLocale()]);
    } else if ($tipo == 'aluno') {
        $turmas = Turma::all();
        return view('cadastroAluno', ['locale' => app()->getLocale(), 'turmas' => $turmas]);
    } else {
        return view('cadastro', ['locale' => app()->getLocale()]);
    }
})->name('cadastro');
Route::get('/cadastro/principal/{locale?}', [\App\Http\Controllers\CadastroController::class, 'index'])->name('cadastro.index');
Route::post('/cadastro/professor/{locale?}', [\App\Http\Controllers\CadastroController::class, 'cadastroProfessor'])->name('cadastro.professor');
Route::post('/cadastro/aluno/{locale?}', [\App\Http\Controllers\CadastroController::class, 'cadastroAluno'])->name('cadastro.aluno');

Route::fallback(function() {
    echo 'Não foi possível acessar a rota requisitada. <a href="'.route('login', ['locale' => app()->getLocale()]).'">Clique aqui</a> para ser redirecionado para a página inicial.';
});