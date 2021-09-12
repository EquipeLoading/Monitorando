@extends('topbar.topbar')

@section('conteudo')

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="utf-8" />
        <title> Monitorando - {{ $monitoria->disciplina }} {{ $monitoria->conteudo}} </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/index.css') }}">
        <link rel="icon" href="{{ asset('assets/png/icon.png') }}">
        <!-- mediaquery -->
    </head>

    <body>

        @if(Gate::allows('criador', $monitoria) || Gate::allows('monitor', $monitoria))
            <button type="button"><a href="{{ route('monitorias.editar', ['id' => $monitoria->id]) }}">Editar dados</a></button>
            <form method="POST" action="{{ route('monitorias.cancelar') }}">
                @csrf
                <input type="hidden" name="monitoria_id" value="{{ $monitoria->id }}" />
                <button type="submit"> Cancelar a monitoria </button>
            </form>
        @endif

        <?php
            $usuarioInscrito = false;
        ?>

        @if(isset($inscrito))
            @foreach($inscrito as $monitoriaInscrita)
                @if($monitoriaInscrita->id == $monitoria->id)
                    <?php 
                        $usuarioInscrito = true;
                        break; 
                    ?>
                @endif
            @endforeach
            @if($usuarioInscrito == true)
                <form method="POST" action="{{ route('cancelamentoInscricao') }}">
                    @csrf
                    <input type="hidden" name="monitoria_id" value="{{ $monitoria->id }}" />
                    <button id="details" type="submit">
                        <text>Cancelar Inscrição</text>
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('inscricao') }}">
                    @csrf
                    <input type="hidden" name="monitoria_id" value="{{ $monitoria->id }}" />
                    <button id="details" type="submit">
                        <text>Inscrever-se</text>
                    </button>
                </form>
            @endif
        @else
            <form method="POST" action="{{ route('inscricao') }}">
                @csrf
                <input type="hidden" name="monitoria_id" value="{{ $monitoria->id }}" />
                <button id="details" type="submit">
                    <text>Inscrever-se</text>
                </button>
            </form>
        @endif

        <h1>{{ $monitoria->codigo }} - {{$monitoria->disciplina}}</h1>

        <h2>{{ $monitoria->conteudo }}</h2>

        <?php 
            $date = new DateTime($monitoria->data);
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
        <p id="hour">{{$monitoria->hora_inicio." - ".$monitoria->hora_fim}} </p>
        <p class="users"> 
            <?php 
                $monitoringMonitor = $monitoria->monitor;
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
        <p>{{ $monitoria->local }}</p> 
        <p id="limit">
            <img src="{{ asset('assets/svg/user-group.svg') }}" id="user">
            <text>Participantes {{ $monitoria->num_inscritos }}</text>
        </p>
        <p>{{ $monitoria->descricao }}</p>

    </body>

    </html>

@endsection