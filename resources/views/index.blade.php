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
    <title> Monitorando </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/index.css') }}">
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

        // function quit(){
        //     document.getElementById("quitButton").style.height = "20%";
        //     document.getElementById("arrow").style.display = 'none';
        // }
        // function back(){
        //     document.getElementById("quitButton").style.height = "0%";
        //     document.getElementById("arrow").style.display = 'block';
        // }

        function onClick() {
            document.getElementById("img01").src = element.src;
            document.getElementById("modal").style.display = "block";
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
                    <a class="active" href="{{ route('index') }}"> HOME </a>
                    <a href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
                    <a href="#calendario"> @lang('lang.Calendario') </a>
                    <a href="#quem somos"> @lang('lang.QuemSomos') </a>      
                <?php }else{ ?>     
                    <!-- <div id="quitButton" >
                        <button onclick=" back()">sair</button>
                    </div> -->
                    <a class="active" href="{{ route('index') }}"> HOME </a>
                    <a href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
                    <a href="#calendario"> @lang('lang.Calendario') </a>
                    <a href="#quem somos"> @lang('lang.QuemSomos') </a>
                    <button class="button_new"><a href="{{ route('cadastro', ['locale' => app()->getLocale()]) }}"> @lang('lang.Registre-se') </a></button>
                <?php } ?>
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
            <?php if(empty($name)){ ?>
                <button class="button_new"><a href="{{ route('cadastro', ['locale' => app()->getLocale()]) }}"> @lang('lang.Registre-se') </a></button>
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

        
    <img src="{{ asset('/img/banner.jpg') }}" alt="banner_monitorando" id="banner">
    <section>
       <div id="topFilter">
            <form id="formSearch">
                <button id="search" type="submit"><img src="{{ asset('assets/svg/search.svg')}}"></button>
                <input id="inputSearch" type="text" placeholder="Pesquisa.." name="search">
            </form>
            <button id="filter">filtrar</button>
       </div>
        @foreach($monitorias as $monitoria)
            <?php 
                $monitoringName = $monitoria->disciplina;
                $monitoring = explode(' - ', $monitoringName);
                $monitoringName = $monitoring[count($monitoring)-1];
                $monitoring = $monitoring[0];
            ?>
            <div id="content-all">
                <div id="content">
                    <hr>
                    <div id="discipline">
                        <h3 id="titleDiscipline">{{ $monitoring }}</h3>
                        <?php if(!($monitoring === $monitoringName)){ ?>
                            <h3 id="nameDiscipline">{{ $monitoringName }}</h3>   
                        <?php }?>   
                    </div>
                </div>
                <button>ver todos</button>
            </div>
            <div id="scroll">
                @foreach ($monitorias as $monitoriaCard)
                        <div id="card">
                            <!-- <p>{{ $monitoria->conteudo }}</p> -->
                            <?php 
                                $monitoringTime = $monitoriaCard->data_horario;
                                $monitoringT = explode('T',$monitoringTime);
                                $monitoringTime = $monitoringT[count($monitoringT)-1];
                                $monitoringT = $monitoringT[0];
                                
                                $date = new DateTime($monitoringT);
                                $n = $date->getTimestamp();
                                $data = date('D', $n);
                                $semana = array(
                                    'Sun' => 'Domingo',
                                    'Mon' => 'Segunda-Feira',
                                    'Tue' => 'Terça-Feira',
                                    'Wed' => 'Quarta-Feira',
                                    'Thu' => 'Quinta-Feira',
                                    'Fri' => 'Sexta-Feira',
                                    'Sat' => 'Sábado'
                                );

                            ?>
                            <p id="hour">{{ date("d/m", $n) . " • " . $semana["$data"] . " " . $monitoringTime }}</p>
                            <p class="users"> 
                                <?php 
                                    $monitoringMonitor = $monitoriaCard->monitor;
                                    $monitoringM = explode(' e ', $monitoringMonitor);
                                    $monitoringMonitor = $monitoringM[count($monitoringM)-1];
                                    $monitoringM = $monitoringM[0];
                                ?>
                                <img src="{{ asset('assets/svg/user.svg') }}" id="user">
                                <text>{{ $monitoringMonitor }}</text>                   
                            </p>
                            <p class="users">
                                <?php if(!($monitoringM === $monitoringMonitor)){ ?>
                                    <img src="{{ asset('assets/svg/user.svg') }}" id="user">
                                    <text>{{ $monitoringM }}</text>
                            </p>
                            <?php } else{?>   
                                <div id="blank"></div>
                            <?php }?>
                            <p id="limit">
                                <img src="{{ asset('assets/svg/user-group.svg') }}" id="user">
                                <text>Participantes {{ $monitoriaCard->num_inscritos }}</text>
                            </p>
                            
                            <p id="details" onclick="onClick()">
                                <text>Inscrever-se</text>
                            </p>
                                    <!-- <p id="place">{{ $monitoria->local }}</p> -->
                                    <!-- <p onclick="document.getElementById('modal').style.display='none'">{{ $monitoria->descricao }} </p> -->
                        </div>
                @endforeach
            </div>

        @endforeach
    </section>
</body>

</html>