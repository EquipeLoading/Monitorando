<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monitoria;
use Illuminate\Support\Facades\Gate;

class MonitoriasController extends Controller
{
    
    public function index() {
        $mostrarBotao = Gate::allows('mostrar-funcionalidade');
    
        return view('monitorias', ['mostrarBotao' => $mostrarBotao]);
    }

    public function cadastro(Request $request)  {
        if($request->input('_token') != ''){

            $regras = [
                'disciplina' => 'required|min:3|max:60',
                'conteudo' => 'required|min:5|max:60',
                'data_horario' => 'required',
                'local' => 'required',
                'monitor' => 'required|min:5',
                'descricao' => 'required'
            ];

            $request->validate($regras);
       
            $monitorias = new Monitoria();

            $monitorias->fill([
                'conteudo' => $request->conteudo,
                'data_horario' => $request->data_horario,
                'num_inscritos' => 0,
                'descricao' => $request->descricao,
                'disciplina' => $request->disciplina,
                'monitor' => $request->monitor,
                'local' => $request->local,
            ])->save();

            return redirect()->route('index');
        }
    }

}
