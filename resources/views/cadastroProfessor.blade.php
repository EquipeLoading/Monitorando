<?php   
    $mobile = FALSE;
    $user_agents = array("iPhone","iPad","Android","webOS","BlackBerry","iPod","Symbian","IsGeneric");
    foreach($user_agents as $user_agent){
        if (strpos($_SERVER['HTTP_USER_AGENT'], $user_agent) !== FALSE) {
            $mobile = TRUE;
            $modelo = $user_agent;
            break;
        }
    }     
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title> @lang('lang.titleCadastroProfessor')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}">
    <link rel="icon" href="{{ asset('assets/png/icon.png') }}">
    <!-- mediaquery -->
</head>

<body>
    <script>
        function openNav() {
            document.getElementById("menuButton").style.display = 'none';
            document.getElementById("myNav").style.width = "70%";
        }
        function closeNav() {
            document.getElementById("menuButton").style.display = 'block';
            document.getElementById("myNav").style.width = "0%";
        }
    </script>
     
    <?php if($mobile){ ?>
        <div id="myNav" class="overlay">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <div class="overlay-content">
                <a class="active" href="{{ route('index') }}"> HOME </a>
                <a href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
                <a href="#calendario"> @lang('lang.Calendario') </a>
                <a href="#quem somos"> @lang('lang.QuemSomos') </a>
            </div>
        </div>
        <div id="background">
            <span id="menuButton" onclick="openNav()">&#9776;</span>          
        <div>
    <?php }else{ ?>   
        <div class="topnav">
            <a class="active" href="{{ route('index') }}"> HOME </a>
            <a href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
            <a href="#calendario"> @lang('lang.Calendario') </a>
            <a href="#quem somos"> @lang('lang.QuemSomos') </a>
            <!-- <button class="button_on"><a href="{{ route('login', ['locale' => app()->getLocale()]) }}"> @lang('lang.Entrar') </a></button>
            <button class="button_new"><a href="{{ route('cadastro', ['locale' => app()->getLocale()]) }}"> @lang('lang.Registre-se') </a></button> -->
        </div> 
    <?php } ?>
    
    <section>
        <img src="{{ asset('/img/banner.jpg') }}" alt="banner_monitorando" id="banner">
        <div id="cadastro">
            <form method="POST" action="{{ route('cadastro.professor', ['locale' => app()->getLocale()]) }}">
                @csrf
                <h1> @lang('lang.Cadastro') </h1>

                <p id="camp">
                    <label class="labelFont" for="nome"> @lang('lang.Nome') </label>
                    <input class="inputBorder" name="nome" value="{{ old('nome') }}" type="text">
                    {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="email"> @lang('lang.emailInstitucional') </label>
                    <input class="inputBorder" name="email" value="{{ old('email') }}" type="email" placeholder="@lang('lang.Nome')@ifsp.edu.br" />
                    {{ $errors->has('email') ? $errors->first('email') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="prontuario"> @lang('lang.prontuario') </label>
                    <input class="inputBorder" name="prontuario" value="{{ old('prontuario') }}" type="text" placeholder="SPXXXXXXX" />
                    {{ $errors->has('prontuario') ? $errors->first('prontuario') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="disciplinas"> @lang('lang.disciplinas') </label>
                    <input class="inputBorder" name="disciplinas" value="{{ old('disciplinas') }}" type="text" />
                    {{ $errors->has('disciplinas') ? $errors->first('disciplinas') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="senha"> @lang('lang.Senha') </label>
                    <input class="inputBorder"  name="senha" value="{{ old('senha') }}" type="password" />
                    {{ $errors->has('senha') ? $errors->first('senha') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="senha"> @lang('lang.ConfirmacaoDeSenha') </label>
                    <input class="inputBorder"  name="confirmacao_senha" value="{{ old('confirmacao_senha') }}" type="password" />
                    {{ $errors->has('confirmacao_senha') ? $errors->first('confirmacao_senha') : '' }}
                </p>

                <p>
                    <button class="button_login" type="submit"> @lang('lang.Registre-se') </button>
                </p>

            </form>
        </div>
    </section>
</body>