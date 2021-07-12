<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function index(Request $request, $locale = null)
    {
        $erro = '';

        app()->setLocale($locale);
        session()->put('locale', $locale);

        if(app()->getLocale() == 'pt-BR') {
            if($request->get('erro') == 1) {
                $erro = 'Usuário e/ou senha não existe';
                return view('login', ['erro' => $erro]);
            }
        } else {
            if($request->get('erro') == 1) {
                $erro = 'User and/or password does not exist';
                return view('login', ['erro' => $erro]);
            }
        }

        return view('login');

    }

    public function autenticacao(Request $request, $locale = null) {

        if($request->input('_token') != '') {
            $regras = [
                'email' =>'required|email',
                'senha' => 'required'
            ];

            $feedback = [
                'required' => 'O campo :attribute precisa ser preenchido',
                'email.email' => 'Um e-mail válido deve ser informado'
            ];

            //validação dos dados recebidos por parâmetro
            $request->validate($regras, $feedback);

            //armazenamento dos dados recebidos do formulário
            $email = $request->email;
            $senha = $request->senha;

            $usuario = new Usuario();

            //compara os dados recebidos na requisição com os dados armazenados no banco de dados
            $login = $usuario->where('email', $email)->get()->first();

            if(Hash::needsRehash($usuario->senha)) {
                $usuario->senha = Hash::make($usuario->senha);
            }

            //inicia a seção caso exista um usuário com os dados informados, se não existir, devolve um erro
            if(isset($login)) {
                if(Hash::check($senha, $login->senha)) {
                    session_start();
                    session()->put('nome', $login->nome);
                    session()->put('email', $login->email);

                    return redirect()->route('index');
                }
            } else {
                return redirect()->route('login', ['erro' => 1]);
            }

        }

    }

}
