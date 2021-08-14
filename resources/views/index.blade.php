@extends('topbar.topbar')

@section('conteudo')
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <title> Monitorando </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/index.css') }}">
        <meta charset="utf-8" />
        <link rel="icon" href="{{ asset('assets/png/icon.png') }}">
        <!-- mediaquery -->
    </head>

<body>
    <script>
        var i = 0;
    </script>
    <img src="{{ asset('/assets/svg/banner.svg') }}" alt="banner_monitorando" id="banner">
    <section>
        <div id="topFilter">
            <form id="formSearch">
                <button id="search" type="submit"><img src="{{ asset('assets/svg/search.svg')}}"></button>
                <input id="inputSearch" type="text" placeholder="Pesquisa.." name="search">
            </form>
            <button id="filter">filtrar</button>
        </div>
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
                        <div >
                            <h3 id="titleDiscipline">{{ $monitoria->codigo }}</h3>
                            <h3 id="nameDiscipline">{{ $monitoria->disciplina }}</h3>   
                        </div>
                    </div>
                    <button>ver todos</button>
                </div>
                <div id="scroll">
                    @foreach ($monitorias->where('codigo', $monitoria->codigo) as $monitoriaCard)
                        <button id="{{$monitoriaCard->id}}" class="modalBtn">
                            <div id="card">
                            <!--<p>{{ $monitoria->conteudo }}</p> -->
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
                                <p id="date">{{ date("d/m", $n) . " • " . $semana["$data"]}}</p>
                                <p id="hour">{{$monitoriaCard->hora_inicio." - ".$monitoriaCard->hora_fim}} </p>
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
                                    <?php if(!($monitoringM === $monitoringMonitor)){ ?>
                                        <p class="users">
                                            <img src="{{ asset('assets/svg/user.svg') }}" id="user">
                                            <text>{{ $monitoringM }}</text>
                                         </p>
                                    <?php } else{?>   
                                        <p id="blank"></p>
                                    <?php }?>
                                <p id="limit">
                                    <img src="{{ asset('assets/svg/user-group.svg') }}" id="user">
                                    <text>Participantes {{ $monitoriaCard->num_inscritos }}</text>
                                </p>
                                        
                                <p id="details">
                                    <text>Inscrever-se</text>
                                </p>
                                <!-- <p>{{ $monitoria->descricao }}</p> -->
                            </div>
                        </button>
                        <div id="modal-{{$monitoriaCard->id}}" class="modal" style="display:none;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <span class="close">&times;</span>
                                    <h2>{{$monitoriaCard->codigo}} - {{$monitoriaCard->disciplina}}</h2>
                                </div>
                                <div class="modal-body">
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
                                    
                                    <p id="hour">{{ date("d/m", $n) . " • " . $semana["$data"] }}</p>
                                    <p id="hour">{{ $monitoriaCard->hora_inicio." - ".$monitoriaCard->hora_fim }}</p>
                                    <p class="users"> 
                                        <?php 
                                            $monitoringMonitor = $monitoriaCard->monitor;
                                            $monitoringM = explode(' e ', $monitoringMonitor);
                                        ?>
                                        @foreach($monitoringM as $monitor)
                                            <img src="{{ asset('assets/svg/user.svg') }}" id="user">
                                            <text>{{ $monitor }}</text>         
                                        @endforeach          
                                    </p>
                                    <p>{{ $monitoria->local }}</p> 
                                    <p id="limit">
                                        <img src="{{ asset('assets/svg/user-group.svg') }}" id="user">
                                        <text>Participantes {{ $monitoriaCard->num_inscritos }}</text>
                                    </p>
                                    <p>{{ $monitoria->descricao }}</p>
                                </div>
                                <div class="modal-footer">
                                    <p id="details">
                                        <text>Inscrever-se</text>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <script>
                            var modal{{$monitoriaCard->id}} = document.getElementById("modal-{{$monitoriaCard->id}}");
                            var modalBtn{{$monitoriaCard->id}} = document.getElementById({{$monitoriaCard->id}});
                            var closeBtn = document.getElementsByClassName("close");

                            modalBtn{{$monitoriaCard->id}}.addEventListener('click', function() {
                                modal{{$monitoriaCard->id}}.style.display = "block";
                            });
                            
                            closeBtn[i].addEventListener('click', function() {
                                modal{{$monitoriaCard->id}}.style.display = "none";
                            });
                            i++;

                            window.addEventListener('click', function() {
                                if(e.target == modal{{$monitoriaCard->id}}) {
                                    modal{{$monitoriaCard->id}}.style.display = "none";
                                }
                            });
                        </script>
                    @endforeach
                </div>
            @endif
        @endforeach
    </section>
</body>

</html>
@endsection