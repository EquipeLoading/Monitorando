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
    
    public function index() {
        $mostrarBotao = Gate::allows('mostrar-funcionalidade');
        
        return view('monitorias', ['mostrarBotao' => $mostrarBotao, 'nome' => session()->get('nome')]);
    }

    public function cadastro(Request $request)  {
        if($request->input('_token') != ''){

            $regras = [
                'codigo' => 'required|min:3|max:3|exists:disciplinas',
                'disciplina' => 'required',
                'conteudo' => 'required|min:5|max:60',
                'data' => 'required|after_or_equal:today',
                'hora_inicio' => 'required',
                'hora_fim' => 'required|after:hora_inicio',
                'local' => 'required',
                'monitor' => 'required|min:5',
                'descricao' => 'required'
            ];

            $request->validate($regras);
       
            $monitorias = new Monitoria();

            $usuario = Auth::user()->id;

            $monitorias->fill([
                'codigo' => $request->codigo,
                'conteudo' => $request->conteudo,
                'data' => $request->data,
                'hora_inicio' => $request->hora_inicio,
                'hora_fim' => $request->hora_fim,
                'num_inscritos' => 0,
                'descricao' => $request->descricao,
                'disciplina' => $request->disciplina,
                'monitor' => $request->monitor,
                'local' => $request->local,
                'user_id' => $usuario
            ])->save();

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
        $monitoria = Monitoria::where('id', $request->monitoria_id)->get()->first();
        $monitoria->delete();

        return redirect()->route('index');
    }

}
