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

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/topbar.css') }}">
</head>

<body>
    @yield('conteudo')
</body>