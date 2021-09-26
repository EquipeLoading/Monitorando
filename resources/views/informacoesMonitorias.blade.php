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
        <script>
            $(document).ready(function(){
                var i = 0;
                var count = 0;
                $('.buttonPresenca').click(function(e) {
                    $('.buttonPresenca').css('display', 'none');
                    $('#modalAvaliacaoBtn').css('display', 'none');
                    e.preventDefault();
                    if(count == 0){
                        $('#adicionarPresenca').append('<h1>Lista de Presença</h1> <form id="formColumn" action="{{route("monitorias.informacoes", ["id" => $monitoria->id])}}" method="POST">' + 
                                                        '@csrf' +
                                                            '<div id="newField">' + 
                                                                '<div id="formFlex">' + 
                                                                    '<input type="text" placeholder="Prontuario.." name="prontuarios[]"/>' + 
                                                                    '<button type="button" id="addNewField"><img src="{{ asset("assets/svg/plus.svg") }}" alt="Plus"></button>' + 
                                                                '</div>' +  
                                                            '</div>' +
                                                            '<button type="submit" id="presenca"><img src="{{ asset("assets/svg/save.svg") }}" alt="Save"></button>' +
                                                            '<button type="button" id="fecharPresenca"><img src="{{ asset("assets/svg/plus.svg") }}" alt="Plus"></button>' +
                                                        '</form>');
                        count++;
                    }
                });
                $('#presenca').on('click', function() {
                    $("#listaChamada").css('display', 'block');
                });
                $('#adicionarPresenca').on('click', '#addNewField', function(e) {
                    $('#newField').append(
                        '<div id="newField">' +
                            '<div id="formFlex">' + 
                                    '<input type="text" placeholder="Prontuario.." name="prontuarios[]">' + 
                                    '<button type="button" class="remove_field"><img src="{{ asset("assets/svg/trash.svg") }}" alt="Trash"></button>' + 
                            '</div>' +
                        '</div>');
                });
                $('#adicionarPresenca').on('click', '.remove_field', function(e) {
                    count = 0;
                    e.preventDefault(); 
                    $(this).parent('div').remove();
                });
                $(document).on('click', '#fecharPresenca', function(e) {
                    count = 0;
                    e.preventDefault();
                    $("#adicionarPresenca h1").remove();
                    $("#adicionarPresenca form").remove();
                    $("#fecharPresenca").remove();
                    $('.buttonPresenca').css('display', 'block');
                    $('#modalAvaliacaoBtn').css('display', 'block');
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
                    $('#adicionarTopico').css('display', 'none');
                    $('#forumQuest').css('display', 'block');
                    if(i == 0){
                        $('#forumQuest').append('<form method="POST" id="postarNovoTopico" action="{{ route('monitorias.postar.topico', ['id' => $monitoria->id]) }}" enctype="multipart/form-data">' +
                                                '@csrf' +
                                                '<div id="novoTopico">' + 
                                                    '<label for="topico">Título</label>' +
                                                    '<input id="inputTitleForum" type="text" placeholder="Nome da dúvida" value="{{ old('topico') }}"  name="topico" >' +
                                                    '<label >Descrição da dúvida</label>' +
                                                    '<textarea placeholder="Descrição da dúvida" name="mensagem" form="postarNovoTopico">{{ old('mensagem') }}</textarea>' + 
                                                    '<div class="row">' +
                                                        '<label id="labelAvatar" for="avatarFile"><h5>Enviar foto</h5></label><input type="file" class="form-control-file" name="imagem" id="avatarFile" aria-describedby="fileHelp" buttonText="Your label here.">' +
                                                        '<button id="createTopico" type="submit"><h5>Finalizar pergunta</h5></button>' +
                                                        '<button type="button" id="fecharTopico"><img src="{{ asset("assets/svg/plus.svg") }}" alt="Plus"></button>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</form>');
                        i++;
                    }
                });
                $('#closetButton').on('click', function(){
                    $("#modalAvaliacao").css('display', 'none');
                })
                $(document).on('click', '#fecharTopico', function(e) {
                    e.preventDefault();
                    $("#postarNovoTopico").remove();
                    $('#adicionarTopico').css('display', 'block');
                    $('#forumQuest').css('display', 'none');
                    i = 0;
                });
            });
            $(window).load(function() {
                var display1 = "{{$errors->has('prontuarios')}}";
                var display2 = "{{session()->has('mensagem')}}";
                if(display1 == 1 || display2 == 1) {
                    $("#modalLista").css('display', 'block');
                }
                $(document).on('click',function(e){
                    if(!(($(e.target).closest("#modalLista").length > 0 ))){
                        $("#modalLista").css('display', 'none');
                    }
                });
                /*if(display1 == 1){
                    alert("{{$errors->first('prontuarios')}}");
                }
                if(display2 == 1) {
                    alert("{{session('mensagem')}}");
                }*/
            });
        </script>

        @section('links')
            <a href="{{ route('index') }}"> HOME </a>
            <a class="active" href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
            <a href="{{ route('calendario') }}"> @lang('lang.Calendario') </a>
            <a href="#quem somos"> @lang('lang.QuemSomos') </a>   
        @endsection 
        <?php
            $usuarioInscrito = false;
            $avaliado = false;
        ?>
        
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

            <div id="modal">
                <div class="modal-content">
                    <p>Todos os dados relacionadas a essa monitoria serão excluídos do sistema. Tem certeza que deseja mesmo cancelá-la?</p>
                    <div id="modalButton">
                        <button type="button" class="exit buttonModal">Não</button>
                        <form method="POST" class="formModal" action="{{ route('monitorias.cancelar') }}">
                            @csrf
                            <input type="hidden" name="monitoria_id" value="{{ $monitoria->id }}" />
                            <button type="submit" id="bttYes" > Sim </button>
                        </form>
                    </div>
                </div>
            </div>
            <div id="modalAvaliacao">
                <div class="modal-content">
                    <form id="formAvaliacao" method="POST" action="{{ route('monitorias.avaliar', ['id' => $monitoria->id]) }}">
                        @csrf
                        <label for="nota">Atribua uma nota de 1 a 10 para a monitoria</label>
                        <input type="number" name="nota" value="{{ old('nota') }}" min="1" max="10"/><br />
                        <label for="justificativa">Por que você atribuiu essa nota? Existe alguma sugestão de melhoria para essa monitoria?</label>
                        <textarea name="justificativa" value="{{ old('justificativa') }}" form="formAvaliacao"></textarea><br />
                        <div class="row">
                            <button type="button" id="closetButton">Fechar</button>                      
                            <button type="submit" id="sendButton">Enviar</button>
                        </div>
                    </form>

                </div>

            </div>

           <div class="row">
                <div>
                    <h6><b>Conteúdo</b>:<br><i>{{ $monitoria->conteudo }}</i></h6>
                    <h6><b>Descrição</b>:<br><i>{{ $monitoria->descricao }}</i></h6>
                </div>

                <div id="column">
                    <img src="{{ asset('assets/png/Monitorando2.png') }}" alt="Logo monitorando" id="monitorando">  
                    <div id="buttons">

                        

                        @if(Gate::allows('criador', $monitoria) || Gate::allows('monitor', $monitoria))
                            <div id="adicionarPresenca">
                                <button class="buttonPresenca" type="button"><h5>Lista de presença</h5></button>
                            </div>
                            <div id="modalLista">
                                {{ $errors->has('prontuarios') ? $errors->first('prontuarios') : '' }}
                                {{ session()->has('mensagem') ? session('mensagem') : '' }}
                            </div>
                            
                        @endif

                        @if(Gate::allows('criador', $monitoria) || Gate::allows('monitor', $monitoria))
                            <div id="monitoriaEdit">
                                <h5>Monitoria</h5>
                                <button type="button" class="button">
                                    <a href="{{ route('monitorias.editar', ['id' => $monitoria->id]) }}">
                                        <img src="{{ asset('/assets/svg/edit.svg') }}" alt="Local" id="edit">
                                    </a>
                                </button>
                                <button type="button" class="button" id="modalBtn">
                                    <img src="{{ asset('/assets/svg/trash.svg') }}" alt="Local" id="trash">
                                </button> 
                            </div>                     
                        @endif       
                        
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
                                    
                                {{ session()->has('sucesso') ? session('sucesso') : '' }}
                            @endif
                        @endif

                        @if(Auth::check())
                            <button type="button" id="adicionarTopico"  class="buttonParticipante">Fazer pergunta</button>
                        @endif

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

                        <?php
                            $usuarioInscrito = false;
                        ?>
                    </div>
                </div>
           </div>

           <div class="row">
                <div>
                    <div id="forum">
                        <h2><b>Fórum</b><h2>
                        
                        {{ session()->has('topico') ? session('topico') : '' }}
                        {{ $errors->has('topico') ? $errors->first('topico') : '' }}
                        {{ $errors->has('mensagem') ? $errors->first('mensagem') : '' }}
                        {{ $errors->has('imagem') ? $errors->first('imagem') : '' }}
                    
                        <div id="topicos">
                            {{ session()->has('editado') ? session('editado') : '' }}
                            @if($topicos->isEmpty())
                                <h2>Sem perguntas</h2>
                            @else
                                @foreach($topicos as $topico) 
                                        <?php
                                            $nome = null;
                                            $user = $topico->user_id;
                                        ?>
                                        @foreach($usuarios as $users)
                                            @if($users->id == $user)
                                            <?php $nome = $users->nome; ?>
                                            @endif
                                        @endforeach
                                        <div id="topico{{$topico->id}}">
                                            @if($topico->monitoria_id == $monitoria->id)
                                                    <a id="listForum" href="{{ route('monitorias.forum', ['id' => $monitoria->id, 'topico' => $topico->id]) }}">
                                                        <div class="row">
                                                            <div>
                                                                <h5>{{$nome}}</h5>
                                                                <h4>{{$topico->topico}}</h4>
                                                            </div>
                                                            <img src="{{ asset('assets/svg/right-arrow.svg') }}" alt="Right Arrow">  
                                                        </div>
                                                    </a>
                                                    <?php
                                                        $usuario = Auth::user();
                                                    ?>
                                                    @if(isset($usuario) && $usuario->id == $topico->user_id)
                                                        <button type="button" id="editarTopico{{$topico->id}}">Editar Tópico</button>
                                                        <button type="button" id="excluirTopico"><a href="{{ route('monitorias.excluir.topico', ['id' => $topico->id]) }}">Excluir tópico</a></button>
                                                        @foreach($mensagens->where('topico_id', $topico->id) as $mensagem)
                                                            <?php
                                                                $mensagemCriador = $mensagem;
                                                            ?>
                                                        @endforeach
                                                        <script>
                                                            $(document).ready(function() {
                                                                var editar = true;
                                                                $("#editarTopico{{$topico->id}}").click(function(e) {
                                                                    if(editar == true){
                                                                        e.preventDefault(); 
                                                                        $("#topico{{$topico->id}}").append('<form method="POST" id="editarTopico" action="{{ route('monitorias.editar.topico', ['id' => $topico->id, 'mensagem' => $mensagemCriador->id]) }}" enctype="multipart/form-data">' +
                                                                                                '@csrf' +
                                                                                                '<div id="novoTopico">' + 
                                                                                                    '<label for="topico">Tópico</label>' +
                                                                                                    '<input type="text" value="{{ $topico->topico ?? old('topico') }}" name="topico">' + 
                                                                                                    '<button type="button" id="fecharEdicaoTopico">Fechar</button>' +
                                                                                                    '<button type="submit">Editar Tópico</button>' +
                                                                                                '</div>' +
                                                                                            '</form>');
                                                                        editar = false;
                                                                    }
                                                                });
                                                                $(document).on('click', '#fecharEdicaoTopico', function(e) {
                                                                    e.preventDefault();
                                                                    $("#editarTopico").remove();
                                                                    editar = true;
                                                                });
                                                            });
                                                        </script>
                                                    @endif
                                            @endif       
                                        </div>    
                                @endforeach
                            @endif
                            

                        </div>
                    </div>       
                </div>

                <div id="right">
                    <div id="forumQuest">
                    </div>
                    @if(Gate::allows('criador', $monitoria))
                        <div id="listaChamada">
                            @if(!($participantes->isEmpty()))
                                <h2><b>Lista de Presença</b></h2>
                                    <div class="row">
                                        <h2>Nome</h2>
                                        <h2 id="titleProntuario">Prontuário</h2>  
                                        <br>
                                    </div>
                                    <tbody>
                                        @foreach($participantes as $participante)
                                        <div class="row">
                                                <a id="avatarChamada" href="{{ route('profile', ['id' => $participante->id]) }}">
                                                    <img id="profile" src="{{ asset('assets/svg/profile.svg')}}"/> 
                                                    <h3>{{$participante->nome}}</h3>
                                                    <h3 id="prontuario">{{$participante->prontuario}}</h3>

                                                </a>
                                                <form action="{{ route('monitorias.presenca', ['monitoriaId' => $monitoria->id, 'usuarioId' => $participante->id]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"><img src="{{ asset("assets/svg/trash.svg") }}" alt="Trash"></button>
                                                </form>
                                        </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    @endif
                </div>


           </div>
            <p>{{ isset($erro) ? $erro : '' }}</p>

           
        </section>
        
        <?php
            $usuario = Auth::user();
        ?>

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

        
    </body>

    </html>
<?php } ?>

@endsection