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
    </script>

    <?php if($mobile){ ?>
        <div id="myNav" class="overlay">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <div class="overlay-content">
                    <a href="{{ route('index') }}"> HOME </a>
                    <a class="active" href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
                    <a href="#calendario"> @lang('lang.Calendario') </a>
                    <a href="#quem somos"> @lang('lang.QuemSomos') </a>       
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
        </div> 
    <?php }?>

    <img src="{{ asset('/img/banner.jpg') }}" alt="banner_monitorando" id="banner">

    <?php
        $cont = 0;
    ?>
    @foreach($monitorias as $monitoria)
        <?php
            $repetida = false;
        ?>
        @if($cont === 0)
            <?php 
                $monitoriaCodigo[$cont] = $monitoria->codigo;
                $cont++;
                $repetida = false;
            ?>
        @else
            @foreach($monitoriaCodigo as $monitoriaRepetida)
                @if($monitoriaRepetida == $monitoria->codigo)
                    <?php
                        $repetida = true;
                        break;
                    ?>
                @else
                    <?php
                        $monitoriaCodigo[$cont] = $monitoria->codigo;
                        $cont++;
                        $repetida = false;
                    ?>
                @endif
            @endforeach
        @endif
        @if($repetida == false)
            <div id="content-all">
                <div id="content">
                    <hr>
                    <div id="discipline">
                        <h3 id="titleDiscipline">{{ $monitoria->codigo }}</h3>
                        <h3 id="nameDiscipline">{{ $monitoria->disciplina }}</h3>   
                    </div>
                </div>
            </div>
            <div id="scroll">
                @foreach ($monitorias->where('codigo', $monitoria->codigo) as $monitoriaCard)
                    <div id="card">
                    <!-- <p>{{ $monitoria->conteudo }}</p> -->
                    <?php 
                        $monitoringTime = $monitoriaCard->data;
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
                        <p id="hour">{{ date("d/m", $n) . " • " . $semana["$data"] . " " . $monitoriaCard->hora_inicio." - ".$monitoriaCard->hora_fim }}</p>
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
                                <p class="users"></p>
                            <?php }?>
                            <!--
                                $monitoringMonitor = $monitoriaCard->monitor;
                                $monitoring = explode(' e ', $monitoringMonitor);

                                {{--@foreach($monitoring as $monitores)
                                    <img src="{{ asset('assets/svg/user.svg') }}" id="user">
                                    <text>{{ $monitoringM }}</text>
                                @endforeach--}}
                            -->
                            <!-- <p>{{ $monitoria->local }}</p> -->
                            <p id="limit">
                                <img src="{{ asset('assets/svg/user-group.svg') }}" id="user">
                                <text>Participantes {{ $monitoriaCard->num_inscritos }}</text>
                            </p>
                            <form method="POST" action="{{ route('monitorias.cancelar') }}">
                                @csrf
                                <input type="hidden" name="monitoria_id" value="{{ $monitoriaCard->id }}" />
                                <button type="submit" id="details">
                                    <text>Cancelar Monitoria</text>
                                </button>
                            </form>
                            <!-- <p>{{ $monitoria->descricao }}</p> -->
                        </div>
                @endforeach
            </div>
        @endif
    @endforeach

</body>

</html>