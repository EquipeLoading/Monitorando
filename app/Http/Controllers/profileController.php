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
    public function index($id) {  
        $usuario = Auth::user();

        $monitorias = Monitoria::all();
        $usuarios = User::all();
        $turmas = Turma::all();
        $perfilUsuario = User::where('id', $id)->get()->first();

        $usuarioLogado = User::find(Auth::user()->id);
        $monitoriasParticipadas = $usuarioLogado->monitorias()->wherePivot('tipo', 'Participou')->get();
        $monitoriasInscrito = $usuarioLogado->monitorias()->wherePivot('tipo', 'Inscrito')->get();
        $monitoriasAvaliadas = $usuarioLogado->monitorias()->wherePivot('tipo', 'Avaliado')->get();

        return view('profile',  ['usuario' => $usuario, 'monitorias' => $monitorias, 'turmas' => $turmas, 'perfilUsuario' => $perfilUsuario, 'monitoriasParticipadas' => $monitoriasParticipadas, 'usuarios' => $usuarios, 'monitoriasInscrito' => $monitoriasInscrito, 'monitoriasAvaliadas' => $monitoriasAvaliadas]);
    }

    public function atualizarDados(Request $request) {
        $usuario = Auth::user();
        if($usuario->tipo == "Comum") {
            $regras = [
                'nome' => 'required|min:5|max:60',
                'email' => 'required|email|unique:users,email,'.$usuario->id.',id',
                'prontuario' => 'required|min:9|max:9|unique:users,prontuario,'.$usuario->id.',id',
                'turma_id' => 'exists:turmas,numero',
                'link' => 'required'
            ];
    
            $request->validate($regras);

            $quantidadeLinks = 0;
            $link = "";

            if(isset($_POST['link'])){
                foreach($_POST['link'] as $linkNovo){
                    if($quantidadeLinks == 0){
                        $link = $linkNovo;
                        $quantidadeLinks++;
                    } else {
                        $link .= " e ".$linkNovo;
                        $quantidadeLinks++;
                    }
                }
            }

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
                    'email_verified_at' => null,
                    'linksExternos' => $link
                ]);

                return redirect()->route('verification.notice');
            }
            else{
                User::where('id', $usuario->id)->update([
                    'nome' => $request->nome,
                    'email' => $request->email,
                    'prontuario' => $request->prontuario,
                    'turma_id' => $turmaId,
                    'linksExternos' => $link
                ]);
                return redirect()->route('profile', ['id' => $usuario->id]);
            }
        } else {
            $regras = [
                'nome' => 'required|min:5|max:60',
                'email' => 'required|email|unique:users,email,'.$usuario->id.',id|ends_with:@ifsp.edu.br',
                'prontuario' => 'required|min:9|max:9|unique:users,prontuario,'.$usuario->id.',id',
                'disciplinas' => 'required|min:3|max:100',
            ];

            $request->validate($regras);

            $quantidadeLinks = 0;
            $link = "";

            if(isset($_POST['link'])){
                foreach($_POST['link'] as $linkNovo){
                    if($quantidadeLinks == 0){
                        $link = $linkNovo;
                        $quantidadeLinks++;
                    } else {
                        $link .= " e ".$linkNovo;
                        $quantidadeLinks++;
                    }
                }
            }

            if($request->email != $usuario->email){
                event(new Registered($usuario));

                User::where('id', $usuario->id)->update([
                    'nome' => $request->nome,
                    'email' => $request->email,
                    'prontuario' => $request->prontuario,
                    'disciplinas' => $request->disciplinas,
                    'email_verified_at' => null,
                    'linksExternos' => $link
                ]);

                return redirect()->route('verification.notice');
            }
            else{
                User::where('id', $usuario->id)->update([
                    'nome' => $request->nome,
                    'email' => $request->email,
                    'prontuario' => $request->prontuario,
                    'disciplinas' => $request->disciplinas,
                    'linksExternos' => $link
                ]);

                return redirect()->route('profile', ['id' => $usuario->id]);
            }
        }
    }
}
