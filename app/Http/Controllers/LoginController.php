<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index(Request $request)
    {
        $erro = '';
        $usuario = Auth::user();
        $nome = '';

        if(isset($usuario)) {
            $nome = Auth::user()->nome;
        }

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

        return view('login', ['nome' => $nome]);

    }

    public function autenticacao(Request $request) {

        if($request->input('_token') != '') {
            $regras = [
                'email' =>'required|email',
                'senha' => 'required'
            ];

            //validação dos dados recebidos por parâmetro
            $request->validate($regras);

            //$usuario = ['email' => $request->email, 'senha' => $request->senha];

            $email = $request->email;
            $senha = $request->senha;

            $usuario = new User();

            $login = $usuario->where('email', $email)->get()->first();

            if(isset($login)) {
                if(Hash::needsRehash($login->senha)) {
                    $login->senha = Hash::make($login->senha);
                    $login->save();
                }
                if(Hash::check($senha, $login->senha)) {
                    if($request->manterlogado === '1'){
                        Auth::login($login, $remember = true);
                    }
                    else{
                        Auth::login($login);
                    }
                    session_start();
                    session()->put('nome', $login->nome);
                    session()->put('email', $login->email);

                    return redirect()->route('index');
                } else {
                    return redirect()->route('login', ['erro' => 1]);
                }
            } else {
                return redirect()->route('login', ['erro' => 1]);
            }

        }

    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();

        return redirect('login');
    }

}
