@extends('topbar.topbar')

@section('conteudo')
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="utf-8" />
        <title> Monitorando - Monitorias </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/index.css') }}">
        <link rel="icon" href="{{ asset('assets/png/icon.png') }}">
        <!-- mediaquery -->
    </head>

    <body>
        
        
        <img src="{{ asset('/assets/svg/banner.svg') }}" alt="banner_monitorando" id="banner">
    
        <section>        
            
            @if($mostrarBotao == true)
                <div id="buttons">
                    <button type="button" class="monitoriaButton"><a href="{{ route('monitorias.cadastro') }}"> Cadastre uma monitoria </a></button>
                    <button type="button" class="monitoriaButton" ><a href="{{ route('monitorias.cancelar') }}"> Cancele uma monitoria </a></button>
                </div>
            @endif

        </section>  

        <script>
            var i = 0;
        </script>
        <section>
            <div id="topFilter">
                <form id="formSearch" action="" method="GET">
                    <button id="search" type="submit"><img src="{{ asset('assets/svg/search.svg')}}"></button>
                    <input id="inputSearch" type="text" placeholder="Pesquisa.." name="search">
                </form>
                <button id="filter">filtrar</button>
            </div>
            <?php
                if(!isset($search)) { 

                    $cont = 0;
                    $usuarioInscrito = false;
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
                                        <text>{{ $usuarios->where('prontuario', $monitoringMonitor)->first()->nome }}</text>                   
                                    </p>
                                        <?php if(!($monitoringM === $monitoringMonitor)){ ?>
                                            <p class="users">
                                                <img src="{{ asset('assets/svg/user.svg') }}" id="user">
                                                <text>{{ $usuarios->where('prontuario', $monitoringM)->first()->nome }}</text>
                                             </p>
                                        <?php } else{?>   
                                            <p id="blank"></p>
                                        <?php }?>
                                    <p id="limit">
                                        <img src="{{ asset('assets/svg/user-group.svg') }}" id="user">
                                        <text>Participantes {{ $monitoriaCard->num_inscritos }}</text>
                                    </p>
                                    @if(isset($inscrito))
                                        @foreach($inscrito as $monitoriaInscrita)
                                            @if($monitoriaInscrita->id == $monitoriaCard->id)
                                                <?php 
                                                    $usuarioInscrito = true;
                                                    break; 
                                                ?>
                                            @else
                                                <?php
                                                    $usuarioInscrito = false;
                                                ?>
                                            @endif
                                        @endforeach
                                        @if($usuarioInscrito == true)
                                            <form method="POST" action="{{ route('cancelamentoInscricao') }}">
                                                @csrf
                                                <input type="hidden" name="monitoria_id" value="{{ $monitoriaCard->id }}" />
                                                <button id="details" type="submit">
                                                    <text>Cancelar Inscrição</text>
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('inscricao') }}">
                                                @csrf
                                                <input type="hidden" name="monitoria_id" value="{{ $monitoriaCard->id }}" />
                                                <button id="details" type="submit">
                                                    <text>Inscrever-se</text>
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <form method="POST" action="{{ route('inscricao') }}">
                                            @csrf
                                            <input type="hidden" name="monitoria_id" value="{{ $monitoriaCard->id }}" />
                                            <button id="details" type="submit">
                                                <text>Inscrever-se</text>
                                            </button>
                                        </form>
                                    @endif
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
                                        <p>{{ $monitoriaCard->local }}</p> 
                                        <p id="limit">
                                            <img src="{{ asset('assets/svg/user-group.svg') }}" id="user">
                                            <text>Participantes {{ $monitoriaCard->num_inscritos }}</text>
                                        </p>
                                        <p>{{ $monitoriaCard->descricao }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        @if(isset($inscrito))
                                            @foreach($inscrito as $monitoriaInscrita)
                                                @if($monitoriaInscrita->id == $monitoriaCard->id)
                                                    <?php 
                                                        $usuarioInscrito = true;
                                                        break; 
                                                    ?>
                                                @else
                                                    <?php
                                                        $usuarioInscrito = false;
                                                    ?>
                                                @endif
                                            @endforeach
                                            @if($usuarioInscrito == true)
                                                <form method="POST" action="{{ route('cancelamentoInscricao') }}">
                                                    @csrf
                                                    <input type="hidden" name="monitoria_id" value="{{ $monitoriaCard->id }}" />
                                                    <button id="details" type="submit">
                                                        <text>Cancelar Inscrição</text>
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('inscricao') }}">
                                                    @csrf
                                                    <input type="hidden" name="monitoria_id" value="{{ $monitoriaCard->id }}" />
                                                    <button id="details" type="submit">
                                                        <text>Inscrever-se</text>
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <form method="POST" action="{{ route('inscricao') }}">
                                                @csrf
                                                <input type="hidden" name="monitoria_id" value="{{ $monitoriaCard->id }}" />
                                                <button id="details" type="submit">
                                                    <text>Inscrever-se</text>
                                                </button>
                                            </form>
                                        @endif
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
            <?php } else { ?> 
                @if(!isset($post)) 
                    <p>Nenhuma monitoria foi encontrada</p>
                @endif
                @foreach ($posts as $post)
                
                <div id="scroll">
                    <button id="{{$post->id}}" class="modalBtn">
                        <div id="card">
                            <?php 
                                $date = new DateTime($post->data);
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
                            <p id="hour">{{$post->hora_inicio." - ".$post->hora_fim}} </p>
                            <p>{{ $post->conteudo }}</p>
                            <p class="users"> 
                                <?php 
                                    $monitoringMonitor = $post->monitor;
                                    $monitoringM = explode(' e ', $monitoringMonitor);
                                ?>
                                @foreach($monitoringM as $monitor)
                                    <img src="{{ asset('assets/svg/user.svg') }}" id="user">
                                    <text>{{ $monitor }}</text>         
                                @endforeach          
                            </p>
                            <p>{{ $post->local }}</p> 
                            <p id="limit">
                                <img src="{{ asset('assets/svg/user-group.svg') }}" id="user">
                                <text>Participantes {{ $post->num_inscritos }}</text>
                            </p>
                            <p>{{ $post->descricao }}</p>
                        </div>
                    </button>
                </div>
            @endforeach <?php } ?>
        </section>

    </body>

    </html>
@endsection