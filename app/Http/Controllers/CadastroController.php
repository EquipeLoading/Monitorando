<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Aluno;
use App\Models\Professor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class CadastroController extends Controller
{

    public function index(Request $request, $locale = null)
    {
        app()->setLocale($locale);
        session()->put('locale', $locale);
        return view('cadastro', ['tipo' => 'principal', 'locale' => app()->getLocale()]);
    }

    public function cadastroProfessor(Request $request, $locale = null)
    {
        app()->setLocale($locale);
        session()->put('locale', $locale);

        if($request->input('_token') != ''){
            $regras = [
                'nome' => 'required|min:5|max:60',
                'email' => 'required|email|unique:usuarios|ends_with:@ifsp.edu.br',
                'prontuario' => 'required|min:9|max:9',
                'disciplinas' => 'required|min:5|max:100',
                'senha' => 'required|min:5|max:60',
                'confirmacao_senha' => 'required|same:senha'
            ];

            $feedback = [
                'required' => 'O campo :attribute precisa ser preenchido',
                'min' => 'O campo :attribute deve ter no mínimo 5 caracteres',
                'max' => 'O campo :attribute deve ter no máximo 60 caracteres',
                'email.email' => 'Um e-mail válido deve ser informado',
                'email.unique' => 'O e-mail digitado já está em uso',
                'email.ends_with' => 'Por favor, digite um e-mail institucional',
                'prontuario.min' => 'O prontuario deve ter no mínimo 9 caracteres',
                'prontuario.max' => 'O campo prontuário deve ter no máximo 9 caracteres',
                'prontuario.unique' => 'O prontuário digitado já está em uso',
                'disciplinas.max' => 'O campo disciplina deve ter no máximo 100 caracteres',
                'confirmacao_senha.same' => 'A senha foi digitada incorretamente'
            ];

            $request->validate($regras, $feedback);
       
            $usuario = new Usuario();

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
                'usuario_id' => $usuario->id
            ])->save();

            return redirect()->route('login');
        }
    }

    public function cadastroAluno(Request $request, $locale = null) {

        app()->setLocale($locale);
        session()->put('locale', $locale);

        if($request->input('_token') != ''){
            $regras = [
                'nome' => 'required|min:5|max:60',
                'email' => 'required|email|unique:usuarios',
                'prontuario' => 'required|min:9|max:9',
                'turma' => 'exists:turmas,id',
                'senha' => 'required|min:5|max:60',
                'confirmacao_senha' => 'required|same:senha'
            ];

            $feedback = [
                'required' => 'O campo :attribute precisa ser preenchido',
                'min' => 'O campo :attribute deve ter no mínimo 5 caracteres',
                'max' => 'O campo :attribute deve ter no máximo 60 caracteres',
                'email.email' => 'Um e-mail válido deve ser informado',
                'email.unique' => 'O e-mail digitado já está em uso',
                'prontuario.min' => 'O prontuario deve ter no mínimo 9 caracteres',
                'prontuario.max' => 'O campo prontuário deve ter no máximo 9 caracteres',
                'prontuario.unique' => 'O prontuário digitado já está em uso',
                'turma.exists' => 'A turma selecionada não existe',
                'confirmacao_senha.same' => 'A senha foi digitada incorretamente'
            ];

            $request->validate($regras, $feedback);
       
            $usuario = new Usuario();

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
                'usuario_id' => $usuario->id,
                'status' => 'Comum'
            ])->save();

            return redirect()->route('login');
        }
    }

}
