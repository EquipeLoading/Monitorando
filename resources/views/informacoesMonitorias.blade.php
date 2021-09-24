@extends('topbar.topbar')

@section('conteudo')

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="utf-8" />
        <link rel="icon" href="{{ asset('assets/png/icon.png') }}">

        <title> Monitorando - {{ $monitoria->disciplina }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/informacoesMonitoria.css') }}">
        <!-- mediaquery -->
    </head>
    

    <body>

        <section>

            <h1>{{ $monitoria->codigo }}</h1>
            <h2>{{$monitoria->disciplina}}</h2>

            <div id="card-inline">
                <div class="card">
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
                    <img src="{{ asset('/assets/svg/calendar.svg') }}" alt="Calendário" id="calendar">
                    <h3>Calendário</h3>
                    <p id="date">{{ date("d/m", $n) . " • " . $semana["$data"]}}</p>
                    <p id="hour">{{$monitoria->hora_inicio." - ".$monitoria->hora_fim}} </p>
                </div>

                <div class="card">
                    <img src="{{ asset('/assets/svg/location.svg') }}" alt="Local" id="calendar">
                    <h3>Local de encontro</h3>
                    <p>{{ $monitoria->local }}</p> 
                </div>

                <div class="card">
                    <?php 
                        $monitoringMonitor = $monitoria->monitor;
                        $count = substr_count($monitoringMonitor, "e");
                        $monitoringM = explode(' e ', $monitoringMonitor);
                    ?>
                
                    <img src="{{ asset('/assets/svg/user.svg') }}" alt="Calendário" id="calendar">
                    
                    @if($count == 0)
                        <h3>Monitor</h3>
                    @else
                        <h3>Monitores<h3>
                    @endif

                    @foreach($monitoringM as $monitores)
                        <?php
                            $monitor = $usuarios->where('prontuario', $monitores)->first();
                        ?>
                        

                        @if(isset($monitor))
                            <p>{{ $monitor->nome }}</p>    
                            <p id="email">{{ $monitor->email }}</p>    
                        @else
                            <p>{{ $monitores }}</p>   
                        @endif
                    @endforeach

                </div>

                <div class="card">
                    <img src="{{ asset('/assets/svg/user-group.svg') }}" alt="Calendário" id="calendar">
                    <h3>Participantes</h3>
                    @if($monitoria->num_inscritos == "0")
                        <p id="inscritosNenhum"> Nenhum participante </p>
                    @else
                        <p id="inscritos">{{ $monitoria->num_inscritos }}</p>
                    @endif
                </div>
            </div>

           <div id="row">
                <div>
                    <h6><b>Conteúdo</b>:<br><i>{{ $monitoria->conteudo }}</i></h6>

                    
                    <h6><b>Descrição</b>:<br><i>{{ $monitoria->descricao }}</i></h6>
                </div>

                <div id="column">
                    <img src="{{ asset('assets/png/Monitorando2.png') }}" alt="Logo monitorando" id="monitorando">  
                    <div id="buttons">
                        @if(Gate::allows('criador', $monitoria) || Gate::allows('monitor', $monitoria))
                        <div id="monitoriaEdit">
                            <h5>Monitoria</h5>
                            <button type="button" class="button">
                                <a href="{{ route('monitorias.editar', ['id' => $monitoria->id]) }}">
                                    <img src="{{ asset('/assets/svg/edit.svg') }}" alt="Local" id="edit">
                                </a>
                            </button>
                            <form method="POST" action="{{ route('monitorias.cancelar') }}">
                                @csrf
                                <input type="hidden" name="monitoria_id" value="{{ $monitoria->id }}" />
                                
                                <button type="submit" class="button" id="trashColor">
                                    <img src="{{ asset('/assets/svg/trash.svg') }}" alt="Local" id="trash">
                                </button>
                            </form>
                        </div>
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
                                    <button class="buttonParticipante" type="submit">
                                        <h4>Cancelar</h4>    
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('inscricao') }}">
                                    @csrf
                                    <input type="hidden" name="monitoria_id" value="{{ $monitoria->id }}" />
                                    <button class="buttonParticipante" type="submit">
                                        <h4>Inscrever-se</h4>
                                    </button>
                                </form>
                            @endif
                        @else
                            <form method="POST" action="{{ route('inscricao') }}">
                                @csrf
                                <input type="hidden" name="monitoria_id" value="{{ $monitoria->id }}" />
                                <button class="buttonParticipante" type="submit">
                                    <h4>Inscrever-se</h4>
                                </button>
                            </form>
                        @endif
        
                    </div>
                </div>
           </div>

            <p>{{ isset($erro) ? $erro : '' }}</p>

            

           

        </section>
    </body>

    </html>

@endsection