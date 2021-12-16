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
        @section('links')
            <a href="{{ route('index') }}"> HOME </a>
            <a class="active" href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
            @if(Auth::check())
                <a href="{{ route('calendario') }}"> @lang('lang.Calendario') </a>
            @endif
            <a href="{{ route('quem.somos') }}"> @lang('lang.QuemSomos') </a>   
        @endsection 
        <img src="{{ asset('/assets/svg/banner.svg') }}" alt="banner_monitorando" id="banner">
    
        <section>        
            
            @if($mostrarBotao == true)
                <div id="buttons">
                    <button type="button" id="addMonitoria" class="monitoriaButton">
                        <a href="{{ route('monitorias.cadastro') }}">
                            <img src="{{ asset('assets/svg/plus.svg') }}" alt="Plus">  
                            <h4>Monitoria</h4> 
                        </a>
                    </button>
                    <button type="button" id="removeMonitoria" class="monitoriaButton" >
                        <a href="{{ route('monitorias.cancelar') }}">
                            <img  src="{{ asset("assets/svg/trash.svg") }}" alt="Trash"> 
                            <h4>Monitoria</h4> 
                        </a>
                    </button>
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
            </div>
            
            <?php
                if(!isset($search)) { 
                    $cont = 0;
                    $cont2 = 0;
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
                        <button><a href="{{ route('monitorias.verTodas', ['codigo' => $monitoria->codigo]) }}">ver todos</a></button>
                    </div>
                    <div id="scroll">
                        @foreach ($monitorias->where('codigo', $monitoria->codigo) as $monitoriaCard)
                            <a id="{{$monitoriaCard->id}}" class="modalBtn" href="{{ route('monitorias.informacoes', ['id' => $monitoriaCard->id]) }}">
                                <div id="card">
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
                                            $monitor1 = $usuarios->where('prontuario', $monitoringMonitor)->first();
                                            $monitor2 = $usuarios->where('prontuario', $monitoringM)->first();
                                        ?>
                                        <img src="{{ asset('assets/svg/user.svg') }}" id="user">
                                        @if(isset($monitor1))
                                            <text>{{ $monitor1->nome }}</text>    
                                        @else
                                            <text>{{ $monitoringMonitor }}</text>    
                                        @endif
                                    </p>
                                        <?php if(!($monitoringM === $monitoringMonitor)){ ?>
                                            <p class="users">
                                                <img src="{{ asset('assets/svg/user.svg') }}" id="user">
                                                @if(isset($monitor2))
                                                    <text>{{ $monitor2->nome }}</text>
                                                @else
                                                    <text>{{ $monitoringM }}</text>    
                                                @endif
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
                                        <?php
                                            $data1 = new DateTime($monitoriaCard->data.' '.$monitoriaCard->hora_fim);
                                            $data2 = new DateTime('now');
                                        ?>
                                        @if($usuarioInscrito == true)
                                            <form method="POST" action="{{ route('cancelamentoInscricao') }}">
                                                @csrf
                                                <input type="hidden" name="monitoria_id" value="{{ $monitoriaCard->id }}" />
                                                <button id="details" type="submit">
                                                    <text>Cancelar</text>
                                                </button>
                                            </form>
                                        @elseif($data1 > $data2)
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
                            </a>
                            <?php
                                $cont2 +=1;
                            ?>
                        @endforeach
                    </div>
                @endif
            @endforeach
            <?php } else { ?> 
                @if($posts->isEmpty()) 
                    <p>Nenhuma monitoria foi encontrada</p>
                @endif
                @foreach ($posts as $post)
                    <?php
                        $count = 0;
                    ?>
                    @if($count === 0)
                        <?php $count++;?>

                        <div id="content">
                            <hr>
                            <div >
                                <h3 id="titleDiscipline">{{ $post->codigo }}</h3>
                                <h3 id="nameDiscipline">{{ $post->disciplina }}</h3>   
                            </div>
                        </div>
                    @endif
                    <div id="scroll">
                         <a id="{{$post->id}}" class="modalBtn" href="{{ route('monitorias.informacoes', ['id' => $post->id]) }}">
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
                                    <p class="users"> 
                                        <?php 
                                            $monitoringMonitor = $post->monitor;
                                            $monitoringM = explode(' e ', $monitoringMonitor);
                                            $monitoringMonitor = $monitoringM[count($monitoringM)-1];
                                            $monitoringM = $monitoringM[0];
                                            $monitor1 = $usuarios->where('prontuario', $monitoringMonitor)->first();
                                            $monitor2 = $usuarios->where('prontuario', $monitoringM)->first();
                                        ?>
                                        <img src="{{ asset('assets/svg/user.svg') }}" id="user">
                                        @if(isset($monitor1))
                                            <text>{{ $monitor1->nome }}</text>    
                                        @else
                                            <text>{{ $monitoringMonitor }}</text>    
                                        @endif
                                    </p>
                                    <?php if(!($monitoringM === $monitoringMonitor)){ ?>
                                        <p class="users">
                                            <img src="{{ asset('assets/svg/user.svg') }}" id="user">
                                            @if(isset($monitor2))
                                                <text>{{ $monitor2->nome }}</text>
                                            @else
                                                <text>{{ $monitoringM }}</text>    
                                            @endif
                                        </p>
                                    <?php } else{?>   
                                        <p id="blank"></p>
                                    <?php }?>
                                    <p id="limit">
                                        <img src="{{ asset('assets/svg/user-group.svg') }}" id="user">
                                        <text>Participantes {{ $post->num_inscritos }}</text>
                                    </p>
                                    <button id="details" class="marginMonitorias" type="submit">
                                        <text>Visualizar</text>
                                    </button>
                            </div>
                        </a>
                    </div>
                @endforeach 
                
            <?php } ?>
        </section>

    </body>

    </html>
@endsection