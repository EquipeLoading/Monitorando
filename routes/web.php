<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\Turma;
use App\Models\User;
use App\Models\Monitoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\FullCalenderController;
use App\Models\Topico;
use App\Models\Mensagem;

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
    Route::get('/{erro?}', [\App\Http\Controllers\LoginController::class, 'index'])->name('login')->middleware('guest');
    Route::post('/', [\App\Http\Controllers\LoginController::class, 'autenticacao'])->name('login');
    Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
});

Route::prefix('/perfil')->group(function(){
    Route::get('/{id}', [\App\Http\Controllers\profileController::class, 'index'])->whereNumber('id')->middleware('auth')->name('profile');
    Route::put('/{id}', [\App\Http\Controllers\profileController::class, 'atualizarDados'])->whereNumber('id')->name('profile');
});

//Rotas de cadastro
Route::prefix('/cadastro')->group(function() {
    Route::get('/', [\App\Http\Controllers\CadastroController::class, 'index'])->name('cadastro')->middleware('guest');
    Route::get('/professor', function() {
        return view('cadastroProfessor');
    })->name('cadastro.professor')->middleware('guest');
    Route::post('/professor', [\App\Http\Controllers\CadastroController::class, 'cadastroProfessor'])->name('cadastro.professor');
    Route::get('/aluno', function() {
        $turmas = Turma::all();
        return view('cadastroAluno', ['turmas' => $turmas]);
    })->name('cadastro.aluno')->middleware('guest');
    Route::post('/aluno', [\App\Http\Controllers\CadastroController::class, 'cadastroAluno'])->name('cadastro.aluno');
});

//Rotas das monitorias (cadastro e cancelamento)
Route::prefix('/monitorias')->group(function() {
    Route::get('/', [\App\Http\Controllers\MonitoriasController::class, 'index'])->name('monitorias');
    Route::post('/', [\App\Http\Controllers\MonitoriasController::class, 'inscricaoMonitorias'])->name('inscricao')->middleware('verified');
    Route::get('/{id}', function($id) {
        $usuario = Auth::user();
        $inscrito = null;
        $topicos = Topico::where('monitoria_id', $id)->get();
        if(isset($usuario)){
            $usuario = User::where('id', Auth::user()->id)->get()->first();
            $inscrito = $usuario->monitorias()->wherePivot('tipo', 'Inscrito')->get();
        }
        $participantes = Monitoria::find($id)->usuarios()->wherePivot('tipo', 'Participou')->get();
        $avaliacoes = Monitoria::find($id)->usuarios()->wherePivot('tipo', 'Avaliado')->get();
        $mensagens = Mensagem::all();

        return view('informacoesMonitorias', ['monitoria' => Monitoria::where('id', $id)->get()->first(), 'usuarios' => User::all(), 'inscrito' => $inscrito, 'erro' => session()->get('erro'), 'participantes' => $participantes, 'avaliacoes' => $avaliacoes, 'topicos' => $topicos, 'mensagens' => $mensagens]);
    })->whereNumber('id')->name('monitorias.informacoes');
    Route::post('/{id}', [\App\Http\Controllers\MonitoriasController::class, 'atribuirPresenca'])->whereNumber('id')->name('monitorias.informacoes');
    Route::get('/ver-todos/{codigo}', function($codigo){
        $monitorias = Monitoria::where('codigo', $codigo)->get();
        $usuario = Auth::user();
        if(isset($usuario)){
            $usuario = User::where('id', Auth::user()->id)->get()->first();
        }
        $inscrito = null;
        if(isset($usuario)){
            $inscrito = $usuario->monitorias()->wherePivot('tipo', 'Inscrito')->get();
        }

        return view('verTodasMonitorias', ['monitorias' => $monitorias, 'usuarios' => User::all(), 'inscrito' => $inscrito]);
    })->name('monitorias.verTodas');
    Route::post('/excluir-presenca/{monitoriaId}/{usuarioId}', [\App\Http\Controllers\MonitoriasController::class, 'excluirPresenca'])->whereNumber('monitoriaId')->whereNumber('usuarioId')->name('monitorias.presenca');
    Route::get('/editar/{id}', function($id) {
        return view('editarMonitorias', ['monitoria' => Monitoria::where('id', $id)->get()->first()]);
    })->whereNumber('id')->name('monitorias.editar')->middleware('verified');
    Route::put('/editar/{id}', [\App\Http\Controllers\MonitoriasController::class, 'editarMonitoria'])->whereNumber('id')->name('monitorias.editar');
    Route::post('/cancelar-inscricao', [\App\Http\Controllers\MonitoriasController::class, 'cancelarInscricao'])->name('cancelamentoInscricao')->middleware('verified');
    Route::get('/cadastro', function() {
        return view('cadastroMonitorias');
    })->name('monitorias.cadastro')->middleware('verified');
    Route::post('/cadastro', [\App\Http\Controllers\MonitoriasController::class, 'cadastro'])->name('monitorias.cadastro');
    Route::post('/autocomplete', [\App\Http\Controllers\MonitoriasController::class, 'autocomplete'])->name('monitorias.autocomplete');
    Route::post('/autocomplete/monitores', [\App\Http\Controllers\MonitoriasController::class, 'autocompleteMonitores'])->name('monitorias.autocomplete.monitores');
    Route::get('/cancelar', function() {
        $usuario = Auth::user()->id;
        $monitorias = User::find($usuario)->monitorias()->wherePivotIn('tipo', ['Criador', 'Monitor'])->orderby('codigo', 'asc')->get();
        $monitorias = $monitorias->unique()->values();

        return view('cancelarMonitoria', ['monitorias' => $monitorias, 'usuarios' => User::all()]);
    })->name('monitorias.cancelar')->middleware('verified');
    Route::post('/cancelar', [\App\Http\Controllers\MonitoriasController::class, 'cancelar'])->name('monitorias.cancelar');
    Route::post('/avaliacao/{id}', [\App\Http\Controllers\MonitoriasController::class, 'avaliacao'])->whereNumber('id')->name('monitorias.avaliar')->middleware('verified');
    Route::post('/editar-avaliacao/{id}', [\App\Http\Controllers\MonitoriasController::class, 'editarAvaliacao'])->whereNumber('id')->name('monitorias.editar.avaliacao')->middleware('verified');
    Route::post('/postar-topico/{id}', [\App\Http\Controllers\MonitoriasController::class, 'postarTopico'])->whereNumber('id')->name('monitorias.postar.topico')->middleware('verified');
    Route::post('/editar-topico/{id}', [\App\Http\Controllers\MonitoriasController::class, 'editarTopico'])->whereNumber('id')->whereNumber('mensagem')->name('monitorias.editar.topico')->middleware('verified');
    Route::post('/editar-mensagem/{id}', [\App\Http\Controllers\MonitoriasController::class, 'editarMensagem'])->whereNumber('id')->name('monitorias.editar.mensagem')->middleware('verified');
    Route::get('/{id}/forum/{topico}', function($id, $topicoId) {
        $topico = Topico::where('id', $topicoId)->get()->first();
        $mensagens = Mensagem::where('topico_id', $topicoId)->get();
        $usuarios = User::all();
        $todosTopicos = Topico::all();
        $monitoria = Monitoria::where('id', $id)->get()->first();

        return view('forum', ['topico' => $topico, 'mensagens' => $mensagens, 'monitoria_id' => $id, 'usuarios' => $usuarios, 'todosTopicos' => $todosTopicos, 'monitoria' => $monitoria]);
    })->whereNumber('id')->whereNumber('topico')->name('monitorias.forum')->middleware('verified');
    Route::post('/{id}/forum/{topico}', [\App\Http\Controllers\MonitoriasController::class, 'responderTopico'])->whereNumber('topico')->whereNumber('id')->name('monitorias.forum')->middleware('verified');
    Route::get('/excluir-topico/{id}', function($id) {
        Mensagem::where('topico_id', $id)->delete();
        Topico::where('id', $id)->delete();

        return redirect()->back();
    })->whereNumber('id')->name('monitorias.excluir.topico');
    Route::get('/excluir-mensagem/{id}', function($id) {
        Mensagem::where('id', $id)->delete();

        return redirect()->back();
    })->whereNumber('id')->name('monitorias.excluir.mensagem');
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

Route::prefix('/resetar-senha')->group(function() {
    Route::get('/', function () {
        return view('resetarSenha');
    })->middleware('guest')->name('password.request');
    Route::post('/', function (Request $request) {
        $request->validate(['email' => 'required|email']);
    
        $status = Password::sendResetLink(
            $request->only('email')
        );

        session(['email' => $request->email]);
    
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    })->middleware('guest')->name('password.email');
    Route::get('/esqueci-a-senha/{token}', function ($token) {
        return view('definirNovaSenha', ['token' => $token]);
    })->middleware('guest')->name('password.reset');
    Route::post('/esqueci-a-senha', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'senha' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );
    
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    })->middleware('guest')->name('password.update');
});

Route::get('/pesquisar', function(Request $request){
    $search = $request->input('pesquisa');
    $pesquisaMonitorias = DB::table('monitorias')
                ->where('conteudo', 'LIKE', "%{$search}%")
                ->orWhere('disciplina', 'LIKE', "%{$search}%")
                ->orWhere('codigo', 'LIKE',  "%{$search}%")
                ->orderby('data', 'desc')
                ->get();
    $pesquisaUsuarios = DB::table('users')
                ->where('nome', 'LIKE', "%{$search}%")
                ->orWhere('prontuario', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE',  "%{$search}%")
                ->orWhere('disciplinas', 'LIKE',  "%{$search}%")
                ->get();
    
    return back()->with('search', $search)->with('pesquisaMonitorias', $pesquisaMonitorias)->with('pesquisaUsuarios', $pesquisaUsuarios);
})->name('pesquisar');

Route::get('/calendario', [\App\Http\Controllers\CalendarioController::class, 'index'])->name('calendario')->middleware('verified');

Route::get('/quem-somos', function() {
    return view('quemSomos');
})->name('quem.somos');

//Rota de fallback
Route::fallback(function() {
    // echo __('lang.fallback');
    return view('404');

});