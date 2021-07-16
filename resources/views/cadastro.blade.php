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
    <title> Monitorando - Cadastro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/cadastro.css') }}">
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
     
   <!-- <?php if($mobile){ ?>
        <div id="myNav" class="overlay">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <div class="overlay-content">
                <a class="active" href="#home"> HOME </a>
                <a href="#monitorias"> @lang('lang.Monitorias') </a>
                <a href="#calendario"> @lang('lang.Calendario') </a>
                <a href="#quem somos"> @lang('lang.QuemSomos') </a>
            </div>
        </div>
        <div id="background">
            <span id="menuButton" onclick="openNav()">&#9776;</span>          
        <div>
    <?php }else{ ?>   
        <div class="topnav">
            <a class="active" href="#home"> HOME </a>
            <a href="#monitorias"> @lang('lang.Monitorias') </a>
            <a href="#calendario"> @lang('lang.Calendario') </a>
            <a href="#quem somos"> @lang('lang.QuemSomos') </a>
            <button class="button_on"><a href="{{ route('login', ['locale' => app()->getLocale()]) }}"> @lang('lang.Entrar') </a></button>
            <button class="button_new"><a href="{{ route('cadastro', ['tipo' => 'principal', 'locale' => app()->getLocale()]) }}"> @lang('lang.Registre-se') </a></button> 
        </div> -->
    <?php } ?>
    
    <section>
        <!-- <img src="{{ asset('/img/banner.jpg') }}" alt="banner_monitorando" id="banner"> -->
        <img src="{{ asset('assets/png/icon.png') }}" alt="Logo monitorando" id="monitorando"> 
        
        <div id="cadastro">
            <h1> @lang('lang.Cadastro') </h1>
            <p>Deseja se cadastrar como </p>
            <a id="aluno_button" href="{{ route('cadastro', ['tipo' => 'aluno', 'locale' => app()->getLocale()]) }}"><button class="button_registro" type="button" >Aluno</button></a>
            <a id="professor_button" href="{{ route('cadastro', ['tipo' => 'professor', 'locale' => app()->getLocale()]) }}"><button class="button_registro" type="button" >Professor</button></a>
            <hr>
            <a href="{{ route('login', ['locale' => app()->getLocale()]) }}"> <button id="login_button">@lang('lang.Entrar')</button></a>
        </div>
       
    </section>
    <div class="info1">
        <!-- <h2>
            Monitorando
        </h2>
        <p> @lang('lang.Paragrafo1') </p>
    </div>
    <div class="info">
        <h2> @lang('lang.Praticidade') </h2>
        <p> @lang('lang.Paragrafo2') </p>
        <h3> @lang('lang.Vergonha') </h3>
        <p> @lang('lang.Paragrafo3') </p> -->
    </div>

    <!-- <footer class="footer">
        <div id="criacao">
            <h1 id="tfooter"> Criado por:</h1>
            <div id="nomes">
                <li> Ana Beatriz Silva Nascimento </li>
                <li> Fernanda Cesar da Silva </li>
                <li> Gustavo Angelozi Frederico </li>
                <li> Larissa Yumi Ohashi </li>
                <li> Mariana Souza Santos </li>
                <li> Wilson de Souza Oliveira Junior </li>
            </div>
        </div>
        <h2> Contato </h2>
        <div class="contato">
            <p> E-mail:
                equipe.loading06@gmail.com </p>
            <a href="https://www.youtube.com/channel/UC4h1uvG3epGzdxZNYYyVrBQ" target="_blank" class="link"> Youtube
                Monitorando </a>
            <a href="https://blogmonitorando.blogspot.com/" target="_blank" class="link"> Blog Monitorando </a>
        </div>
        < </footer> -->

</body>

</html>