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
            <a href="{{ route('calendario') }}"> @lang('lang.Calendario') </a>
            <a href="{{ route('quem.somos') }}"> @lang('lang.QuemSomos') </a>   
        @endsection 
        <img src="{{ asset('/assets/svg/banner.svg') }}" alt="banner_monitorando" id="banner">

        <?php
            $usuarioInscrito = false;
            $i = 0;
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
                <section>
                    <div id="content-all">
                        <div id="content">
                            <hr>
                            <div >
                                <h3 id="titleDiscipline">{{ $monitoria->codigo }}</h3>
                                <h3 id="nameDiscipline">{{ $monitoria->disciplina }}</h3>   
                            </div>
                        </div>
                    </div>
                    <div id="scroll">
                        @foreach ($monitorias->where('codigo', $monitoria->codigo) as $monitoriaCard)
                            <a id="{{$monitoriaCard->id}}" class="modalBtn" href="{{ route('monitorias.informacoes', ['id' => $monitoriaCard->id]) }}">
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
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        @endforeach
    </body>

@endsection