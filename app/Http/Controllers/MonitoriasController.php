<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monitoria;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Disciplina;

class MonitoriasController extends Controller
{
    
    public function index() {
        $mostrarBotao = Gate::allows('professor');
    
        return view('monitorias', ['nome' => session()->get('nome'), 'mostrarBotao' => $mostrarBotao]);
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
                'descricao' => 'required'
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
            ])->save();

            User::find($usuario)->monitorias()->attach($monitorias->id);

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
        $usuario = Monitoria::find($request->monitoria_id)->usuarios()->get()->first();
        $usuario->monitorias()->detach($request->monitoria_id);
        $monitoria = Monitoria::where('id', $request->monitoria_id)->get()->first();
        $monitoria->delete();

        return redirect()->route('index');
    }

}
