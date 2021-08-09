<?php
     $allNames =  $nome;
     $name = explode(' ', $allNames);
     $allNames = $name[count($name)-1];
     $name = $name[0];


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
    <title> Monitorando - Monitorias </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/monitorias.css') }}">
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
                 <?php if(!empty($name)){ ?>
                    <button id="profile">
                        <img src="{{ asset('/assets/svg/profile.svg') }}" alt="Profile" id="Perfil">                
                            <?php if(!($name !== $allNames)){ ?>
                                <text>{{ $name }}</text>
                            <?php } else{?>
                                <text>{{ $name . " " . $allNames }}</text>
                            <?php } ?>
                        <img src="{{ asset('/assets/svg/right-arrow.svg') }}" alt="arrow" id="arrow">
                    </button>
                    <a  href="{{ route('index') }}"> HOME </a>
                    <a class="active" href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
                    <a href="#calendario"> @lang('lang.Calendario') </a>
                    <a href="#quem somos"> @lang('lang.QuemSomos') </a>      
                <?php }else{ ?>     
                    <a href="{{ route('index') }}"> HOME </a>
                    <a class="active" href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
                    <a href="#calendario"> @lang('lang.Calendario') </a>
                    <a href="#quem somos"> @lang('lang.QuemSomos') </a>
                    <button class="button_new"><a href="{{ route('cadastro') }}"> @lang('lang.Registre-se') </a></button>
                <?php } ?>
            </div>
        </div>
        <div id="background">
            <span id="menuButton" onclick="openNav()">&#9776;</span>          
        <div>
    <?php }else{ ?>   
        <div class="topnav">
            <a href="{{ route('index') }}"> HOME </a>
            <a class="active" href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
            <a href="#calendario"> @lang('lang.Calendario') </a>
            <a href="#quem somos"> @lang('lang.QuemSomos') </a>
            <?php if(empty($name)){ ?>
                <button class="button_new"><a href="{{ route('cadastro') }}"> @lang('lang.Registre-se') </a></button>
            <?php }else{ ?>              
                <button id="profile">
                    <img src="{{ asset('/assets/svg/profile.svg') }}" alt="Profile" id="Perfil"> 
                    <?php if(!($name !== $allNames)){ ?>
                        <text>{{ $name }}</text>
                    <?php } else{?>
                        <text>{{ $name . " " . $allNames }}</text>
                    <?php } ?>
                </button>
            <?php }?>
        </div> 
    <?php } ?>
    
    <img src="{{ asset('/assets/svg/banner.svg') }}" alt="banner_monitorando" id="banner">
 
    <section>        
        <?php if(!empty($nome)){?>
            <div id="all-content">
            <div id="content">
                <hr>
                <h3 id="userName">Ola <br> {{ $nome }}!</h3>   
            </div>
            @if($mostrarBotao == true)
                <div id="buttons">
                    <button type="button" class="monitoriaButton"><a href="{{ route('monitorias.cadastro') }}"> Cadastre uma monitoria </a></button>
                    <button type="button" class="monitoriaButton" ><a href="{{ route('monitorias.cancelar') }}"> Cancele uma monitoria </a></button>
                </div>
             @endif
        </div>         
        <?php }?>

    </section>  

</body>

</html>