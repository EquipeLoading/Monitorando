@extends('topbar.topbar')

@section('conteudo')
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title> Monitorando - Login </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/login.css') }}">
    <link rel="icon" href="{{ asset('assets/png/icon.png') }}">
    <!-- mediaquery -->
</head>

<body>
    <section>
        <img src="{{ asset('/img/banner.jpg') }}" alt="banner_monitorando" id="banner">
        <div id="login">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1> L O G I N </h1>
                <p id="camp">
                    <label class="labelFont" for="email"> E-mail </label>
                    <br>
                    <input id="email" name="email" class="inputBorder" value="{{ old('email') }}" type="text" />
                    {{ $errors->has('email') ? $errors->first('email') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="senha"> @lang('lang.Senha')</label>
                    <br>
                    <input id="senha" name="senha" type="password" class="inputBorder"/>
                    {{ $errors->has('senha') ? $errors->first('senha') : '' }}
                </p>

                <p class="link">
                    <a href="{{ route('password.request') }}">@lang('lang.RecuperarSenha')</a>
                </p>

                <p id="check">
                    <input type="checkbox" name="manterlogado" id="manterlogado" value="1" />
                    <label for="manterlogado">@lang('lang.Manter-meLogado')</label>
                </p>

                <p id="butoes">
                    <button class="button_registro" type="button"><a href="{{ route('cadastro') }}"> @lang('lang.Registre-se') </a></button>
                    <button class="button_login" type="submit"> @lang('lang.Entrar') </button>
                </p>

            </form>

            <p id="camp">{{ isset($erro) && $erro != '' ? $erro : '' }}</p>
            <p id="camp">{{ session()->has('status') ? session('status') : '' }}</p>
            
        </div>
    </section>
    <div class="info1">
        <h2>
            Monitorando
        </h2>
        <p> @lang('lang.Paragrafo1')</p>
    </div>
    <div class="info">
        <h2> @lang('lang.Praticidade') </h2>
        <p> @lang('lang.Paragrafo2')</p>
        <h3> @lang('lang.Vergonha') </h3>
        <p>@lang('lang.Paragrafo3')</p>
    </div>
</body>

</html>
@endsection