<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class CadastroController extends Controller
{

    public function index(Request $request)
    {
        return view('cadastro');
    }

    public function cadastroProfessor(Request $request)
    {
        if($request->input('_token') != ''){
            $regras = [
                'nome' => 'required|min:5|max:60',
                'email' => 'required|email|unique:users|ends_with:@ifsp.edu.br',
                'prontuario' => 'required|min:8|max:9|unique:users',
                'disciplinas' => 'required|min:3|max:100',
                'senha' => 'required|min:8|max:60',
                'confirmacao_senha' => 'required|same:senha'
            ];

            $request->validate($regras);
       
            $usuario = new User();

            $usuario->fill([
                'nome' => $request->nome,
                'email' => $request->email,
                'prontuario' => $request->prontuario,
                'senha' => Hash::make($request->senha),
                'tipo' => 'Professor',
                'disciplinas' => $request->disciplinas
            ])->save();

            event(new Registered($usuario));

            Auth::login($usuario);

            session_start();
            session()->put('nome', $usuario->nome);
            session()->put('email', $usuario->email);

            return redirect()->route('verification.notice');

        }
    }

    public function cadastroAluno(Request $request) {
        if($request->input('_token') != ''){
            $regras = [
                'nome' => 'required|min:5|max:60',
                'email' => 'required|email|unique:users',
                'prontuario' => 'required|min:9|max:9|unique:users',
                'turma_id' => 'exists:turmas,id',
                'senha' => 'required|min:8|max:60',
                'confirmacao_senha' => 'required|same:senha'
            ];

            $request->validate($regras);
       
            $usuario = new User();

            $usuario->fill([
                'nome' => $request->nome,
                'email' => $request->email,
                'prontuario' => $request->prontuario,
                'senha' => Hash::make($request->senha),
                'turma_id' => $request->turma_id,
                'tipo' => 'Comum'
            ])->save();

            event(new Registered($usuario));

            Auth::login($usuario);

            session_start();
            session()->put('nome', $usuario->nome);
            session()->put('email', $usuario->email);

            return redirect()->route('verification.notice');
        }
    }

}
