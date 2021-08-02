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
    <title> @lang('lang.titleCadastro')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/cadastro.css') }}">
    <link rel="icon" href="{{ asset('assets/png/icon.png') }}">
    <!-- mediaquery -->
</head>

<body>
    
    <section>
        <img src="{{ asset('assets/png/Monitorando.png') }}" alt="Logo monitorando" id="monitorando"> 
        <div id="cadastro">
            <h1> @lang('lang.Cadastro') </h1>
            <p> @lang('lang.desejaCadastrar') </p>
            <a id="aluno_button" href="{{ route('cadastro.aluno', ['locale' => app()->getLocale()]) }}"><button class="button_registro" type="button" >@lang('lang.aluno')</button></a>
            <a id="professor_button" href="{{ route('cadastro.professor', ['locale' => app()->getLocale()]) }}"><button class="button_registro" type="button" >@lang('lang.professor')</button></a>
            <hr>
            <a href="{{ route('login', ['locale' => app()->getLocale()]) }}"> <button id="login_button">@lang('lang.Entrar')</button></a>
        </div>
    </section>
</body>

</html>