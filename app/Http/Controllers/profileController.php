<?php

namespace App\Http\Controllers;
use App\Models\Monitoria;
use App\Models\Turma;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index() {  
        $usuario = Auth::user();

        $monitorias = Monitoria::all();
        $turmas = Turma::all();
        return view('profile',  ['usuario' => $usuario, 'monitorias' => $monitorias, 'turmas' => $turmas]);
    }

    public function atualizarDados(Request $request) {
        $usuario = Auth::user();
        if($usuario->tipo == "Comum") {
            $regras = [
                'nome' => 'required|min:5|max:60',
                'email' => 'required|email|unique:users,email,'.$usuario->id.',id',
                'prontuario' => 'required|min:9|max:9|unique:users,prontuario,'.$usuario->id.',id',
                'turma_id' => 'exists:turmas,numero',
            ];
    
            $request->validate($regras);

            $turmas = Turma::all();
            $turmaId = 0;
            foreach($turmas as $turma) {
                if($turma->numero == $request->turma_id){
                    $turmaId = $turma->id;
                }
            }

            if($request->email != $usuario->email){
                event(new Registered($usuario));

                User::where('id', $usuario->id)->update([
                    'nome' => $request->nome,
                    'email' => $request->email,
                    'prontuario' => $request->prontuario,
                    'turma_id' => $turmaId,
                    'email_verified_at' => null
                ]);

                return redirect()->route('verification.notice');
            }
            else{
                User::where('id', $usuario->id)->update([
                    'nome' => $request->nome,
                    'email' => $request->email,
                    'prontuario' => $request->prontuario,
                    'turma_id' => $turmaId,
                ]);
                return redirect()->route('profile');
            }
        } else {
            $regras = [
                'nome' => 'required|min:5|max:60',
                'email' => 'required|email|unique:users,email,'.$usuario->id.',id|ends_with:@ifsp.edu.br',
                'prontuario' => 'required|min:9|max:9|unique:users,prontuario,'.$usuario->id.',id',
                'disciplinas' => 'required|min:3|max:100',
            ];

            $request->validate($regras);

            if($request->email != $usuario->email){
                event(new Registered($usuario));

                User::where('id', $usuario->id)->update([
                    'nome' => $request->nome,
                    'email' => $request->email,
                    'prontuario' => $request->prontuario,
                    'disciplinas' => $request->disciplinas,
                    'email_verified_at' => null
                ]);

                return redirect()->route('verification.notice');
            }
            else{
                User::where('id', $usuario->id)->update([
                    'nome' => $request->nome,
                    'email' => $request->email,
                    'prontuario' => $request->prontuario,
                    'disciplinas' => $request->disciplinas
                ]);

                return redirect()->route('profile');
            }
        }
    }
}
