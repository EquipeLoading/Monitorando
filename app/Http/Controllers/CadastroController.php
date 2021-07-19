<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Aluno;
use App\Models\Professor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class CadastroController extends Controller
{

    public function index(Request $request, $locale = null)
    {
        app()->setLocale($locale);
        session()->put('locale', $locale);
        return view('cadastro', ['locale' => app()->getLocale()]);
    }

    public function cadastroProfessor(Request $request, $locale = null)
    {
        app()->setLocale($locale);
        session()->put('locale', $locale);

        if($request->input('_token') != ''){
            $regras = [
                'nome' => 'required|min:5|max:60',
                'email' => 'required|email|unique:users|ends_with:@ifsp.edu.br',
                'prontuario' => 'required|min:9|max:9',
                'disciplinas' => 'required|min:5|max:100',
                'senha' => 'required|min:5|max:60',
                'confirmacao_senha' => 'required|same:senha'
            ];

            $feedback = [
                'required' => __('lang.requiredLogin'),
                'min' => __('lang.min'),
                'max' => __('lang.max'),
                'email.email' => __('lang.emailLogin'),
                'email.unique' => __('lang.emailUnique'),
                'email.ends_with' => __('lang.emailTerminaCom'),
                'prontuario.min' => __('lang.prontuarioMin'),
                'prontuario.max' => __('lang.CampoProntuario'),
                'prontuario.unique' => __('lang.ProntuarioEmUso'),
                'disciplinas.max' => __('lang.disciplinaMax'),
                'confirmacao_senha.same' => __('lang.SenhaIncorreta')
            ];

            $request->validate($regras, $feedback);
       
            $usuario = new User();

            $usuario->fill([
                'nome' => $request->nome,
                'email' => $request->email,
                'prontuario' => $request->prontuario,
                'senha' => Hash::make($request->senha)
            ])->save();

            $professor = new Professor();

            //pega todos os dados enviados pelo formulário e armazena no banco de dados como um novo usuário
            $professor->fill([
                'disciplinas' => $request->disciplinas,
                'user_id' => $usuario->id
            ])->save();

            event(new Registered($usuario));

            Auth::login($usuario);

            session_start();
            session()->put('nome', $usuario->nome);
            session()->put('email', $usuario->email);

            return redirect()->route('index');

        }
    }

    public function cadastroAluno(Request $request, $locale = null) {

        app()->setLocale($locale);
        session()->put('locale', $locale);

        if($request->input('_token') != ''){
            $regras = [
                'nome' => 'required|min:5|max:60',
                'email' => 'required|email|unique:users',
                'prontuario' => 'required|min:9|max:9',
                'turma_id' => 'exists:turmas,id',
                'senha' => 'required|min:5|max:60',
                'confirmacao_senha' => 'required|same:senha'
            ];

            $feedback = [
                'required' => __('lang.requiredLogin'),
                'min' => __('lang.min'),
                'max' => __('lang.max'),
                'email.email' => __('lang.emailLogin'),
                'email.unique' => __('lang.emailUnique'),
                'prontuario.min' => __('lang.prontuarioMin'),
                'prontuario.max' => __('lang.CampoProntuario'),
                'prontuario.unique' => __('lang.ProntuarioEmUso'),
                'turma_id.exists' => __('lang.TurmaNãoExiste'),
                'confirmacao_senha.same' => __('lang.SenhaIncorreta')
            ];

            $request->validate($regras, $feedback);
       
            $usuario = new User();

            $usuario->fill([
                'nome' => $request->nome,
                'email' => $request->email,
                'prontuario' => $request->prontuario,
                'senha' => Hash::make($request->senha)
            ])->save();

            $aluno = new Aluno();

            //pega todos os dados enviados pelo formulário e armazena no banco de dados como um novo usuário
            $aluno->fill([
                'turma_id' => $request->turma_id,
                'user_id' => $usuario->id,
                'status' => 'Comum'
            ])->save();

            event(new Registered($usuario));

            Auth::login($usuario);

            session_start();
            session()->put('nome', $usuario->nome);
            session()->put('email', $usuario->email);

            return redirect()->route('index');
        }
    }

}
