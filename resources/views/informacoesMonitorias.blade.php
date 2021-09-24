@extends('topbar.topbar')

@section('conteudo')

<?php if(!isset($monitoria)) { ?>
    <p>Nenhuma monitoria foi encontrada</p>
<?php } else { ?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="utf-8" />
        <link rel="icon" href="{{ asset('assets/png/icon.png') }}">
        <title> Monitorando - {{ $monitoria->disciplina }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/informacoesMonitoria.css') }}">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <!-- mediaquery -->
    </head>
    

    <body>

        <section>

            <h1>{{ $monitoria->codigo }}</h1>
            <h2>{{$monitoria->disciplina}}</h2>

            <div id="card-inline">
                <div class="card">
        <script>
            $(document).ready(function(){
                var count = 0;
                var i = 0;
                $('#buttonPresenca').click(function(e) {
                    e.preventDefault();
                    if(count == 0){
                        $('#buttonPresenca').remove();
                        $('#adicionarPresenca').append('<form action="{{route("monitorias.informacoes", ["id" => $monitoria->id])}}" method="POST">' + 
                                                            '@csrf' +
                                                            '<div id="newField">' + 
                                                                '<label for="prontuarios[]">Prontuário</label>' +
                                                                '<input type="text" name="prontuarios[]"/>' + 
                                                                '<button type="button" id="addNewField"><img src="{{ asset("assets/svg/plus.svg") }}" alt="Plus"></button>' + 
                                                            '</div>' +  
                                                            '<button type="submit">Atribuir Presença</button>' +
                                                        '</form>');
                        count++;
                    }
                });
                $('#adicionarPresenca').on('click', '#addNewField', function(e) {
                    $('#newField').append('<div id="newField">' + 
                                        '<label for="prontuario[]">Prontuário</label>' +
                                        '<input type="text" name="prontuarios[]">' + 
                                        '<button type="button" class="remove_field"><img src="{{ asset("assets/svg/trash.svg") }}" alt="Trash"></button>' + 
                                    '</div>');
                });
                $('#adicionarPresenca').on('click', '.remove_field', function(e) {
                    e.preventDefault(); 
                    $(this).parent('div').remove();
                });

                $('#modalBtn').on('click', function() {
                    $("#modal").css('display', 'block');
                });

                $('.exit').on('click', function() {
                    $("#modal").css('display', 'none');
                });

                $(document).on('click',function(e){
                    if(!(($(e.target).closest("#modal").length > 0 ) || ($(e.target).closest("#modalBtn").length > 0))){
                        $("#modal").css('display', 'none');
                    }
                });

                $('#modalAvaliacaoBtn').on('click', function() {
                    $("#modalAvaliacao").css('display', 'block');
                });

                $('.close').on('click', function() {
                    $("#modalAvaliacao").css('display', 'none');
                });

                $(document).on('click',function(e){
                    if(!(($(e.target).closest("#modalAvaliacao").length > 0 ) || ($(e.target).closest("#modalAvaliacaoBtn").length > 0))){
                        $("#modalAvaliacao").css('display', 'none');
                    }
                });

                $('#editarAvaliacao').on('click', function() {
                    $("#modalEditarAvaliacao").css('display', 'block');
                });

                $('.closeEdit').on('click', function() {
                    $("#modalEditarAvaliacao").css('display', 'none');
                });

                $(document).on('click',function(e){
                    if(!(($(e.target).closest("#modalEditarAvaliacao").length > 0 ) || ($(e.target).closest("#editarAvaliacao").length > 0))){
                        $("#modalEditarAvaliacao").css('display', 'none');
                    }
                });

                $('#adicionarTopico').click(function(e) {
                    if(i == 0){
                        $('#forum').append('<form method="POST" id="postarNovoTopico" action="{{ route('monitorias.postar.topico', ['id' => $monitoria->id]) }}" enctype="multipart/form-data">' +
                                                '@csrf' +
                                                '<div id="novoTopico">' + 
                                                    '<label for="topico">Tópico</label>' +
                                                    '<input type="text" value="{{ old('topico') }}" name="topico">' + 
                                                    '<textarea name="mensagem" form="postarNovoTopico">{{ old('mensagem') }}</textarea>' + 
                                                    '<input type="file" class="form-control-file" name="imagem" id="avatarFile" aria-describedby="fileHelp">' +
                                                    '<small id="fileHelp" class="form-text text-muted"><br/>Insira uma imagem ou um arquivo pdf</small>' +
                                                    '<button type="submit">Criar Tópico</button>' +
                                                '</div>' +
                                            '</form>');
                        i++;
                    }
                });
            });
        </script>

        @if(Gate::allows('criador', $monitoria) || Gate::allows('monitor', $monitoria))
            <button type="button"><a href="{{ route('monitorias.editar', ['id' => $monitoria->id]) }}">Editar dados</a></button>
            <button type="button" id="modalBtn">Cancelar a monitoria</button>
        @endif

        <div id="modal">
            <div class="modal-content">
                <span class="exit">&times;</span>
                <p>Todos os dados relacionadas a essa monitoria serão excluídos do sistema. Tem certeza que deseja mesmo cancelá-la?</p>
                <button type="button" class="exit">Não</button>
                <form method="POST" action="{{ route('monitorias.cancelar') }}">
                    @csrf
                    <input type="hidden" name="monitoria_id" value="{{ $monitoria->id }}" />
                    <button type="submit"> Sim </button>
                </form>
            </div>
        </div>

        <?php
            $usuarioInscrito = false;
            $avaliado = false;
        ?>

        @if(isset($inscrito))
            @foreach($inscrito as $monitoriaInscrita)
                @if($monitoriaInscrita->id == $monitoria->id)
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
        @if(Gate::allows('criador', $monitoria) || Gate::allows('monitor', $monitoria))
            <div id="adicionarPresenca">
                <button id="buttonPresenca" type="button">Atribuir presenças na monitoria</button>
                {{ $errors->has('prontuarios') ? $errors->first('prontuarios') : '' }}
            </div>
            {{ session()->has('mensagem') ? session('mensagem') : '' }}
            @if(!($participantes->isEmpty()))
                <h2>Usuários que participaram da monitoria</h2>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Prontuário</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($participantes as $participante)
                            <tr>
                                <td>{{$participante->nome}}</td>
                                <td>{{$participante->prontuario}}</td>
                                <td><a href="{{ route('profile', ['id' => $participante->id]) }}">Visitar Perfil</a></td>
                                <td>
                                    <form action="{{ route('monitorias.presenca', ['monitoriaId' => $monitoria->id, 'usuarioId' => $participante->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit">Remover</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endif
        <?php
            $usuario = Auth::user();
        ?>

        @if(Gate::allows('participou', $monitoria))
            @foreach($avaliacoes as $avaliacao)
                @if(isset($usuario))
                    @if($avaliacao->id == $usuario->id)
                        <?php
                            $avaliado = true;
                            break;
                        ?>
                    @endif
                @endif
            @endforeach
            @if($avaliado == false)
                <button id="modalAvaliacaoBtn">Avaliar Monitoria</button><br/>
                {{ $errors->has('nota') ? $errors->first('nota') : '' }}
                {{ $errors->has('justificativa') ? $errors->first('justificativa') : '' }}
                <div id="modalAvaliacao">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <form id="formAvaliacao" method="POST" action="{{ route('monitorias.avaliar', ['id' => $monitoria->id]) }}">
                            @csrf
                            <label for="nota">Atribua uma nota de 1 a 10 para a monitoria</label>
                            <input type="text" name="nota" value="{{ old('nota') }}" /><br />
                            <label for="justificativa">Por que você atribuiu essa nota? Existe alguma sugestão de melhoria para essa monitoria?</label>
                            <textarea name="justificativa" value="{{ old('justificativa') }}" form="formAvaliacao"></textarea><br />
                            <button type="submit">Enviar avaliação</button>
                        </form>
                    </div>
                </div>
                {{ session()->has('sucesso') ? session('sucesso') : '' }}
            @endif
        @endif

        @if(Gate::allows('criador', $monitoria))
            @if(!($avaliacoes->isEmpty()))
                <?php 
                    $cont = 0;
                    $media = 0;
                ?>
                @foreach($avaliacoes as $avaliacao)
                    <?php
                        $media += $avaliacao->pivot->nota;
                        $cont++;
                    ?>
                @endforeach
                <?php
                    $media /= $cont;
                    $media = number_format($media, 1);
                ?>
                <h3>Média das notas das avaliações: {{ $media }}</h3>
                @foreach($avaliacoes as $avaliacao)
                    @if(isset($usuario))
                        @if($avaliacao->id == $usuario->id)
                            <br>
                            <div class="avaliacao">
                                <p><b>Nota:</b> {{ $avaliacao->pivot->nota }}</p>
                                <p><b>Comentário: </b>{{ $avaliacao->pivot->justificativa }}</p>
                                <button id="editarAvaliacao">Editar avaliação</button>
                                {{ $errors->has('nota') ? $errors->first('nota') : '' }}
                                {{ $errors->has('justificativa') ? $errors->first('justificativa') : '' }}
                                <div id="modalEditarAvaliacao">
                                    <div class="modal-content">
                                        <span class="closeEdit">&times;</span>
                                        <form id="formEditarAvaliacao" method="POST" action="{{ route('monitorias.editar.avaliacao', ['id' => $monitoria->id]) }}">
                                            @csrf
                                            <label for="nota">Atribua uma nota de 1 a 10 para a monitoria</label>
                                            <input type="text" name="nota" value="{{ $avaliacao->pivot->nota ?? old('nota') }}" /><br />
                                            <label for="justificativa">Por que você atribuiu essa nota? Existe alguma sugestão de melhoria para essa monitoria?</label>
                                            <textarea name="justificativa" form="formEditarAvaliacao">{{ $avaliacao->pivot->justificativa ?? old('justificativa') }}</textarea><br />
                                            <button type="submit">Editar avaliação</button>
                                        </form>
                                    </div>
                                </div>
                                {{ session()->has('sucesso') ? session('sucesso') : '' }}
                            </div>
                        @else
                            <br>
                            <div class="avaliacao">
                                <p><b>Nota:</b> {{ $avaliacao->pivot->nota }}</p>
                                <p><b>Comentário: </b>{{ $avaliacao->pivot->justificativa }}</p>
                            </div>
                        @endif
                    @endif
                @endforeach
            @endif
        @endif

        @if(Gate::allows('participou', $monitoria) && !(Gate::allows('criador', $monitoria)))
            @if(!($avaliacoes->isEmpty()))
                @foreach($avaliacoes as $avaliacao)
                    @if(isset($usuario))
                        @if($avaliacao->id == $usuario->id)
                            <br>
                            <div class="avaliacao">
                                <p><b>Nota:</b> {{ $avaliacao->pivot->nota }}</p>
                                <p><b>Comentário: </b>{{ $avaliacao->pivot->justificativa }}</p>
                                <button id="editarAvaliacao">Editar avaliação</button>
                                {{ $errors->has('nota') ? $errors->first('nota') : '' }}
                                {{ $errors->has('justificativa') ? $errors->first('justificativa') : '' }}
                                <div id="modalEditarAvaliacao">
                                    <div class="modal-content">
                                        <span class="closeEdit">&times;</span>
                                        <form id="formEditarAvaliacao" method="POST" action="{{ route('monitorias.editar.avaliacao', ['id' => $monitoria->id]) }}">
                                            @csrf
                                            <label for="nota">Atribua uma nota de 1 a 10 para a monitoria</label>
                                            <input type="text" name="nota" value="{{ $avaliacao->pivot->nota ?? old('nota') }}" /><br />
                                            <label for="justificativa">Por que você atribuiu essa nota? Existe alguma sugestão de melhoria para essa monitoria?</label>
                                            <textarea name="justificativa" form="formEditarAvaliacao">{{ $avaliacao->pivot->justificativa ?? old('justificativa') }}</textarea><br />
                                            <button type="submit">Editar avaliação</button>
                                        </form>
                                    </div>
                                </div>
                                {{ session()->has('sucesso') ? session('sucesso') : '' }}
                            </div>
                        @endif
                    @endif
                @endforeach
            @endif
        @endif

    <div id="forum">
        <h3>Fórum - Tópicos</h3>
        @if(Auth::check() == false)
            <p><a href="{{ route('cadastro') }}">Cadastre-se</a> para visualizar os tópicos existentes ou postar algo no fórum</p>
        @else
            <button type="button" id="adicionarTopico">Adicionar Tópico</button>
            {{ session()->has('topico') ? session('topico') : '' }}
            {{ $errors->has('topico') ? $errors->first('topico') : '' }}
            {{ $errors->has('mensagem') ? $errors->first('mensagem') : '' }}
            {{ $errors->has('imagem') ? $errors->first('imagem') : '' }}
        @endif
    </div>
    <div id="topicos">
        @if(Auth::check())
            {{ session()->has('editado') ? session('editado') : '' }}
            @foreach($topicos as $topico) 
                @if($topico->monitoria_id == $monitoria->id)
                    <h4><a href="{{ route('monitorias.forum', ['id' => $monitoria->id, 'topico' => $topico->id]) }}"> {{$topico->topico}} </a></h4>
                    @if(isset($usuario) && $usuario->id == $topico->user_id)
                        <button type="button" id="editarTopico{{$topico->id}}">Editar Tópico</button>
                        <button type="button" id="excluirTopico"><a href="{{ route('monitorias.excluir.topico', ['id' => $topico->id]) }}">Excluir tópico</a></button>
                        @foreach($mensagens->where('topico_id', $topico->id) as $mensagem)
                            <?php
                                $mensagemCriador = $mensagem;
                            ?>
                            <script>
                                var editar = true;
                                $(document).ready(function() {
                                    $("#editarTopico{{$topico->id}}").click(function(e) {
                                        if(editar == true) {
                                            e.preventDefault(); 
                                            $("#topicos").append('<form method="POST" id="editarTopico" action="{{ route('monitorias.editar.topico', ['id' => $topico->id, 'mensagem' => $mensagemCriador->id]) }}" enctype="multipart/form-data">' +
                                                                    '@csrf' +
                                                                    '<div id="novoTopico">' + 
                                                                        '<label for="topico">Tópico</label>' +
                                                                        '<input type="text" value="{{ $topico->topico ?? old('topico') }}" name="topico">' + 
                                                                        '<textarea name="mensagem" form="editarTopico">{{ $mensagemCriador->mensagem ?? old('mensagem') }}</textarea>' + 
                                                                        '<input type="file" class="form-control-file" name="imagem" id="avatarFile" aria-describedby="fileHelp">' +
                                                                        '<small id="fileHelp" class="form-text text-muted"><br/>Insira uma imagem ou um arquivo pdf</small>' +
                                                                        '<button type="submit" name="apagarAnexo">Apagar anexo</button>' +
                                                                        '<button type="submit">Editar Tópico</button>' +
                                                                    '</div>' +
                                                                '</form>');
                                            editar = false;
                                        }
                                    });
                            });
                            </script>
                        @endforeach
                    @endif
                @endif
            @endforeach
        @endif
    </div>
    </body>

    </html>
<?php } ?>

@endsection