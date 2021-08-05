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
    <title> Monitorando - Login </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/login.css') }}">
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
                <button class="button_new"><a href="{{ route('cadastro', ['locale' => app()->getLocale()]) }}"> @lang('lang.Registre-se') </a></button>

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
            <button class="button_new"><a href="{{ route('cadastro', ['locale' => app()->getLocale()]) }}"> @lang('lang.Registre-se') </a></button>
        </div> 
    <?php } ?>
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
                    <a href="#paracadastro">@lang('lang.RecuperarSenha')</a>
                </p>

                <p id="check">
                    <input type="checkbox" name="manterlogado" id="manterlogado" value="" />
                    <label for="manterlogado">@lang('lang.Manter-meLogado')</label>
                </p>

                <p>
                    <button class="button_registro" type="button"><a href="{{ route('cadastro', ['locale' => app()->getLocale()]) }}"> @lang('lang.Registre-se') </a></button>
                    <button class="button_login" type="submit"> @lang('lang.Entrar') </button>
                </p>

            </form>

            <p id="camp">{{ isset($erro) && $erro != '' ? $erro : '' }}</p>
            
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