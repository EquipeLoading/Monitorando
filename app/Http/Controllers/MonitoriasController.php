<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monitoria;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Disciplina;
use Illuminate\Support\Facades\DB;

class MonitoriasController extends Controller
{
    
    public function index(Request $request) {
        $mostrarBotao = Gate::allows('professor');
        $monitorias = Monitoria::all();
        $usuario = Auth::user();
        if(isset($usuario)){
            $usuario = User::where('id', Auth::user()->id)->get()->first();
        }
        $inscrito = null;
        if(isset($usuario)){
            $inscrito = $usuario->monitorias()->wherePivot('tipo', 'Inscrito')->get();
        }
        
        $search = $request->input('search');
        $posts = DB::table('monitorias')
                ->where('conteudo', 'LIKE', "%{$search}%")
                ->orWhere('disciplina', 'LIKE', "%{$search}%")
                ->orWhere('codigo', 'LIKE',  "%{$search}%")
                ->get();

        return view('monitorias', compact('posts'), ['nome' => session()->get('nome'), 'mostrarBotao' => $mostrarBotao, 'monitorias' => $monitorias, 'inscrito' => $inscrito, 'search' => $search, 'usuarios' => User::all()]);
    }

    public function inscricaoMonitorias(Request $request) {
        $monitoria = Monitoria::where('id', $request->monitoria_id)->get()->first();
        $usuario = User::where('id', Auth::user()->id)->get()->first();
        $monitoriaInscrito = $usuario->monitorias()->wherePivot('tipo', 'Inscrito')->wherePivot('monitoria_id', $monitoria->id)->get()->first();

        if(!(isset($monitoriaInscrito))){
            $usuario->monitorias()->attach($monitoria, ['tipo' => 'Inscrito']);

            $monitoria->num_inscritos += 1;
            $monitoria->save();

            return redirect()->route('monitorias');
        }
        else {
            return back()->with('erro', 'Não foi possível se inscrever na monitoria');
        }

        
    }

    public function cadastro(Request $request)  {
        if($request->input('_token') != ''){

            $regras = [
                'codigo' => 'required|min:3|max:5',
                'disciplina' => 'required',
                'conteudo' => 'required|min:5|max:60',
                'data' => 'required|after_or_equal:today',
                'hora_inicio' => 'required',
                'hora_fim' => 'required|after:hora_inicio',
                'local' => 'required',
                'descricao' => 'required',
                'monitores' => 'required|exists:users,prontuario',
                'periodo' => 'integer'
            ];

            $request->validate($regras);
       
            $monitorias = new Monitoria();

            $usuario = Auth::user()->id;

            $quantidadeMonitores = 0;
            $monitor = "";

            if(isset($_POST['monitores'])){
                foreach($_POST['monitores'] as $monitorNovo){
                    if($quantidadeMonitores == 0){
                        $monitor = $monitorNovo;
                        $quantidadeMonitores++;
                    } else {
                        $monitor .= " e ".$monitorNovo;
                        $quantidadeMonitores++;
                    }
                }
            }

            $monitorias->fill([
                'codigo' => $request->codigo,
                'conteudo' => $request->conteudo,
                'data' => $request->data,
                'hora_inicio' => $request->hora_inicio,
                'hora_fim' => $request->hora_fim,
                'num_inscritos' => 0,
                'descricao' => $request->descricao,
                'disciplina' => $request->disciplina,
                'monitor' => $monitor,
                'local' => $request->local,
                'periodo' => $request->periodo
            ])->save();

            if(isset($_POST['monitores'])){
                foreach($_POST['monitores'] as $monitorNovo){
                    $monitores = User::where('prontuario', $monitorNovo)->get()->first();
                    User::find($monitores->id)->monitorias()->attach($monitorias->id, ['tipo' => 'Monitor']);
                }
            }

            User::find($usuario)->monitorias()->attach($monitorias->id, ['tipo' => 'Criador']);

            return redirect()->route('index');
        }
    }

    public function autocomplete(Request $request) {
        $procurar = $request->get('codigo');

        if($procurar == '') {
            $codigos = Disciplina::orderby('codigo', 'asc')->select('codigo', 'nome')->limit(5)->get();
        } else {
            $codigos = Disciplina::orderby('codigo', 'asc')->select('codigo', 'nome')->where('codigo', 'LIKE', '%'.$procurar.'%')->limit(5)->get();
        }
        
        $resposta = array();
        foreach($codigos as $valor) {
            $resposta[] = array("value" => $valor->nome, "label" => $valor->codigo);
        }

        return response()->json($resposta);
    }

    public function cancelar(Request $request) {
        $usuarios = Monitoria::find($request->monitoria_id)->usuarios()->get();
        foreach($usuarios as $usuario){
            $usuario->monitorias()->detach($request->monitoria_id);
        }
        $monitoria = Monitoria::where('id', $request->monitoria_id)->get()->first();
        $monitoria->delete();

        return redirect()->route('index');
    }

    public function cancelarInscricao(Request $request) {
        $monitoria = Monitoria::where('id', $request->monitoria_id)->get()->first();
        $usuario = User::where('id', Auth::user()->id)->get()->first();
        $monitoriaInscrito = $usuario->monitorias()->wherePivot('tipo', 'Inscrito')->wherePivot('monitoria_id', $monitoria->id)->get()->first();

        if(isset($monitoriaInscrito)){
            $monitoria->usuarios()->wherePivot('tipo', 'Inscrito')->detach(Auth::user()->id);
            $monitoria->num_inscritos -= 1;
            $monitoria->save();

            return redirect()->route('monitorias');
        } else {
            return back()->with('erro', 'Não foi possível cancelar a inscrição na monitoria');
        }
        
        
    }

    public function editarMonitoria(Request $request) {
        
        $regras = [
            'codigo' => 'required|min:3|max:5',
            'disciplina' => 'required',
            'conteudo' => 'required|min:5|max:60',
            'data' => 'required|after_or_equal:today',
            'hora_inicio' => 'required',
            'hora_fim' => 'required|after:hora_inicio',
            'local' => 'required',
            'descricao' => 'required',
            'monitores' => 'required|exists:users,prontuario',
            'periodo' => 'integer'
        ];

        $request->validate($regras);

        $quantidadeMonitores = 0;
        $monitor = "";

        if(isset($_POST['monitores'])){
            foreach($_POST['monitores'] as $monitorNovo){
                if($quantidadeMonitores == 0){
                    $monitor = $monitorNovo;
                    $quantidadeMonitores++;
                } else {
                    $monitor .= " e ".$monitorNovo;
                    $quantidadeMonitores++;
                }
            }
        }

        $monitoria = Monitoria::find($request->monitoria);

        $monitoria->update([
            'codigo' => $request->codigo,
            'conteudo' => $request->conteudo,
            'data' => $request->data,
            'hora_inicio' => $request->hora_inicio,
            'hora_fim' => $request->hora_fim,
            'num_inscritos' => 0,
            'descricao' => $request->descricao,
            'disciplina' => $request->disciplina,
            'monitor' => $monitor,
            'local' => $request->local,
            'periodo' => $request->periodo
        ]);

        $monitoria->usuarios()->wherePivot('tipo', 'Monitor')->detach();

        if(isset($_POST['monitores'])){
            foreach($_POST['monitores'] as $monitorNovo){
                $monitores = User::where('prontuario', $monitorNovo)->get()->first();
                User::find($monitores->id)->monitorias()->attach($monitoria->id, ['tipo' => 'Monitor']);
            }
        }
        
        return redirect()->route('monitorias.informacoes', ['id' => $request->monitoria]);
    }

    public function atribuirPresenca(Request $request, $id) {
        $regras = [
            'prontuarios' => 'required|exists:users,prontuario'
        ];

        $request->validate($regras);

        foreach($_POST['prontuarios'] as $prontuario){
            $usuarios = User::where('prontuario', $prontuario)->get()->first();
            User::find($usuarios->id)->monitorias()->attach($id, ['tipo' => 'Participou']);
        }
        return back()->with('mensagem', 'A(s) presença(s) foram atribuídas com sucesso!');
    }

    public function excluirPresenca(Request $request, $monitoriaId, $usuarioId) {
        $monitoria = Monitoria::where('id', $monitoriaId)->get()->first();
        $monitoria->usuarios()->wherePivot('tipo', 'Participou')->detach($usuarioId);
        $usuario = User::where('id', $usuarioId)->get()->first();

        return back()->with('mensagem', 'O usuário '.$usuario->nome.' foi removido da lista de presença da monitoria');
    }

    public function avaliacao(Request $request, $id) {
        $regras = [
            'nota' => 'required|integer|between:1,10',
            'justificativa' => 'required|min:5|max:500'
        ];

        $request->validate($regras);

        $monitoria = Monitoria::where('id', $id)->get()->first();
        $monitoria->usuarios()->attach(Auth::user()->id, ['tipo' => 'Avaliado', 'nota' => $request->nota, 'justificativa' => $request->justificativa]);

        return back()->with('sucesso', 'Sua avaliação foi enviada com sucesso!');
    }

    public function editarAvaliacao(Request $request, $id) {
        $regras = [
            'nota' => 'required|integer|between:1,10',
            'justificativa' => 'required|min:5|max:500'
        ];

        $request->validate($regras);

        $monitoria = Monitoria::where('id', $id)->get()->first();
        $monitoria->usuarios()->wherePivot('tipo', 'Avaliado')->detach(Auth::user()->id);
        $monitoria->usuarios()->attach(Auth::user()->id, ['tipo' => 'Avaliado', 'nota' => $request->nota, 'justificativa' => $request->justificativa]);

        return back()->with('sucesso', 'Sua avaliação foi editada com sucesso!');
    }
}
