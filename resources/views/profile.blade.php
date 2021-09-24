<!DOCTYPE html>
<html>
    <head>
        <title> Monitorando - Perfil </title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/profile.css') }}">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>

    <body>
        <script>

            $(document).ready(function() {
                var contador = 0;
                var edit = false;
                $(".buttonInline").click(function(e) {
                    e.preventDefault();
                    if(contador == 0) {
                        $('.inputField').attr('readonly', false);
                        $("#update").append('<button type="submit">Atualizar dados</button>');
                        $('#buttonEdit').remove();
                        $("#link").append('<button id="add_field_button" type="button">' +       
                                              '<img src="{{ asset("assets/svg/plus.svg") }}" alt="Plus">' +  
                                          '</button>');
                        $("#photoProfile").append('<button type="submit" name="apagarFoto" class="btn btn-warning">Apagar Foto</button>' +
                                                  '<input type="file" class="form-control-file" name="foto" id="avatarFile">');
                        contador++;
                        edit = true;
                    }
                });

                var max_campos = 3;
                var wrapper = $("#input_fields_wrap");
                var add_button = $("#add_field_button");

                var count = 1;
                $(wrapper).on('click', '#add_field_button', function(e){
                    e.preventDefault();
                    if(count < max_campos){
                        count++;
                        $("#input_fields_wrap").append('<div id="addLink">' + 
                                                '<input type="text" name="link[]"/>' + 
                                                '<button class="remove_field"><img src="{{ asset("assets/svg/trash.svg") }}" alt="Trash"></button>' + 
                                        '</div>');
                    }
                });

                $(wrapper).on("click",".remove_field", function(e){
                    if(edit == true){
                        e.preventDefault(); $(this).parent('div').remove(); count--;
                    }
                });
            });
            
        </script>
        <section>
            <?php
                $numTurma;
                $naoEncontrado = false;
            ?>
            
            @if(isset($usuario) && isset($perfilUsuario))
                @if($usuario->id == $perfilUsuario->id)
                    <div class="content">
                        <hr >
                        <h3 id="userName">Seus dados!</h3>   
                    </div>
                    <div id="all-content">
                        <div id="cardProfile">
                            <form id="update" method="POST" action="{{ route('profile', ['id' => $usuario->id]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div id="photoProfile">
                                    @if(isset($usuario->foto))
                                        <img id="profile" src="{{ $usuario->foto }}"/> 
                                    @else
                                        <img id="profile" src="{{ asset('assets/svg/profile.svg')}}"/> 
                                    @endif
                                    <button type="button" class="buttonInline"><img src="{{asset('assets/svg/edit.svg')}}"/></button>
                                    {{ $errors->has('foto') ? $errors->first('foto') : '' }}
                                </div>    
                                <div class="editLabel">
                                        <label>Nome</label>
                                        <div class="inputInline">
                                            <input name="nome" type="text" class="inputField" value="{{ $usuario->nome ?? old('nome') }}" readonly />
                                            <button type="button" class="buttonInline"><img src="{{asset('assets/svg/edit.svg')}}"/></button>
                                        </div>
                                        {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                                </div> 
                                <div id="slim">
                                        <div class="editLabel">
                                            <label>Prontuário</label>
                                            <div class="inputInline">
                                                <input name="prontuario" type="text" class="inputField" value="{{ $usuario->prontuario ?? old('prontuario') }}" readonly />
                                                <button type="button" class="buttonInline"><img src="{{asset('assets/svg/edit.svg')}}"/></button>
                                            </div>
                                            {{ $errors->has('prontuario') ? $errors->first('prontuario') : '' }}
                                        </div> 
                                        @if($usuario->tipo === 'Comum')
                                            <div class="editLabel">
                                                <label>Turma</label>
                                                <div class="inputInline">
                                                    @foreach($turmas as $turma)
                                                        @if($usuario->turma_id === $turma->id)
                                                            <?php
                                                                $numTurma = $turma->numero;
                                                            ?>
                                                        @endif
                                                    @endforeach
                                                    <input name="turma_id" type="text" class="inputField" value="{{ $numTurma ?? old('turma_id') }}" readonly />
                                                    <button type="button" class="buttonInline"><img src="{{asset('assets/svg/edit.svg')}}"/></button>
                                                </div>
                                                {{ $errors->has('turma_id') ? $errors->first('turma_id') : '' }}
                                            </div> 
                                        @elseif($usuario->tipo === 'Professor')
                                            <div class="editLabel">
                                                <label>Disciplinas</label>
                                                <div class="inputInline">
                                                    <input name="disciplinas" type="text" class="inputField" value="{{ $usuario->disciplinas ?? old('disciplinas') }}" readonly />
                                                    <button type="button" class="buttonInline"><img src="{{asset('assets/svg/edit.svg')}}"/></button>
                                                </div>
                                                {{ $errors->has('disciplinas') ? $errors->first('disciplinas') : '' }}
                                            </div> 
                                        @endif
                                </div>
                                <div class="editLabel">
                                    <label>E-mail</label>
                                    <div class="inputInline">
                                        <input name="email" type="text" class="inputField" value="{{ $usuario->email ?? old('email') }}" readonly />
                                        <button type="button" class="buttonInline"><img src="{{asset('assets/svg/edit.svg')}}"/></button>
                                    </div>
                                    {{ $errors->has('email') ? $errors->first('email') : '' }}
                                </div> 
                                <?php 
                                    $linksExternos = $usuario->linksExternos;
                                    $links = explode(' e ', $linksExternos);
                                    $i = 0
                                ?>
                                @if(isset($links))
                                    @foreach($links as $link)
                                        @if($i == 0)
                                            <div class="camp" id="input_fields_wrap">
                                                <label id="labelMonitores" class="labelFont" for="link"> Links externos </label>
                                                <div id="link">
                                                    <input class="inputField" id="inputLink" name="link[]" value="{{ $link ?? old('link[$i]') }}" type="text" readonly/>
                                                    <button type="button" id="buttonEdit" class="buttonInline"><img src="{{asset('assets/svg/edit.svg')}}"/></button>
                                                </div>
                                                {{ $errors->has('link') ? $errors->first('link') : '' }}
                                            </div>
                                            <?php
                                                $i++;
                                            ?>
                                        @else
                                            <script>
                                                $("#input_fields_wrap").append('<div id="link">' + 
                                                            '<input class="inputField" id="links" name="link[]" value="{{ $link ?? old("link[$i]") }}" type="text" readonly/>' + 
                                                            '<button id="trash" type="button" class="remove_field"><img src="{{asset("assets/svg/trash.svg")}}"/></button>' + 
                                                    '</div>');
                                                $(wrapper).on("click",".remove_field", function(e){
                                                    e.preventDefault(); $(this).parent('div').remove(); 
                                                 });                            
                                            </script>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="camp" id="input_fields_wrap">
                                        <label id="labelMonitores" class="labelFont" for="link"> Links externos </label>
                                        <div id="link">
                                            <input class="inputField" id="inputLink" name="link[]" value="" type="text" readonly/>
                                            <button type="button" id="buttonEdit" class="buttonInline"><img src="{{asset('assets/svg/edit.svg')}}"/></button>
                                        </div>
                                        {{ $errors->has('link') ? $errors->first('link') : '' }}
                                    </div>
                                @endif
                            </form>
                        </div>
                        <div id="two-content">
                            <div id="cardHistory">
                                <div class="content">
                                    <hr>
                                    <h3 id="userName">Histórico de <br> monitorias</h3> 
                                    <?php
                                        $cont = 0;
                                    ?>
                                    @if(!($monitoriasParticipadas->isEmpty()))
                                        @foreach($monitoriasParticipadas as $monitoria)
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
                                                </div>
                                                <div id="scroll">
                                                    @foreach ($monitoriasParticipadas->where('codigo', $monitoria->codigo) as $monitoriaCard)
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
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <p>Nenhum registro de participação em monitorias foi encontrado</p>
                                    @endif
                                    <h3>Monitorias em que você está inscrito</h3>
                                    @if(!($monitoriasInscrito->isEmpty()))
                                        <?php
                                            $cont = 0;
                                        ?>
                                        @foreach($monitoriasInscrito as $monitoria)
                                            <?php
                                                $repetida = false;
                                            ?>
                                            @if($cont === 0)
                                                <?php 
                                                    $monitoriaNome[$cont] = $monitoria->codigo;
                                                    $cont++;
                                                    $repetida = false;
                                                ?>
                                            @else
                                                @foreach($monitoriaNome as $monitoriaRepetida)
                                                    @if($monitoriaRepetida == $monitoria->codigo)
                                                        <?php
                                                            $repetida = true;
                                                            break;
                                                        ?>
                                                    @else
                                                        <?php
                                                            $monitoriaNome[$cont] = $monitoria->codigo;
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
                                                </div>
                                                <div id="scroll">
                                                    @foreach ($monitoriasInscrito->where('codigo', $monitoria->codigo) as $monitoriaCard)
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
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <p>Não foi encontrado registro de inscrição em nenhuma monitoria</p>
                                    @endif
                                </div>
                            </div>
                            <br>
                            <br>
                            <h3>Monitorias que estão esperando sua avaliação</h3>
                            @if(!($monitoriasParticipadas->isEmpty()))
                                <?php
                                    $cont = 0;
                                    $avaliado = true;
                                ?>
                                @foreach($monitoriasParticipadas as $monitoria)
                                    @foreach($monitoriasAvaliadas as $monitoriaAvaliada)
                                        @if($monitoriaAvaliada->id == $monitoria->id)
                                            <?php
                                                $avaliado = false;
                                                break;
                                            ?>
                                        @else
                                            <?php
                                                $avaliado = true;
                                            ?>
                                        @endif
                                    @endforeach
                                    <?php
                                        $repetida = false;
                                    ?>
                                    @if($cont === 0)
                                        <?php 
                                            $monitoriaCod[$cont] = $monitoria->codigo;
                                            $cont++;
                                            $repetida = false;
                                        ?>
                                    @else
                                        @foreach($monitoriaCod as $monitoriaRepetida)
                                            @if($monitoriaRepetida == $monitoria->codigo)
                                                <?php
                                                    $repetida = true;
                                                    break;
                                                ?>
                                            @else
                                                <?php
                                                    $monitoriaCod[$cont] = $monitoria->codigo;
                                                    $cont++;
                                                    $repetida = false;
                                                ?>
                                            @endif
                                        @endforeach
                                    @endif
                                    @if($avaliado == true)
                                        @if($repetida == false)
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
                                                @foreach ($monitoriasParticipadas->where('codigo', $monitoria->codigo) as $monitoriaCard)
                                                    @foreach($monitoriasAvaliadas as $monitoriaAvaliada)
                                                        @if($monitoriaAvaliada->id == $monitoriaCard->id)
                                                            <?php
                                                                $avaliado = false;
                                                                break;
                                                            ?>
                                                        @else
                                                            <?php
                                                                $avaliado = true;
                                                            ?>
                                                        @endif
                                                    @endforeach
                                                    @if($avaliado == true)
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
                                                            </div>
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @else
                                            <?php
                                                $naoEncontrado = true;
                                            ?>
                                        @endif
                                    @else
                                        <?php
                                            $naoEncontrado = true;
                                        ?>
                                    @endif
                                @endforeach
                            @else
                                <?php
                                    $naoEncontrado = true;
                                ?>
                            @endif 
                            @if($naoEncontrado == true)
                                <p>Não foi encontrada nenhuma monitoria esperando a sua avaliação</p>
                            @endif
                            <div id="cardCalendary">
                            </div>
                        </div>
                    </div>
                @else
                    <div id="all-content">
                        <div id="cardProfile">
                            <div id="photoProfile">
                                @if(isset($perfilUsuario->foto))
                                        <img id="profile" src="{{ $perfilUsuario->foto }}"/> 
                                @else
                                    <img id="profile" src="{{asset('assets/svg/profile.svg')}}"/> 
                                @endif
                            </div>
                            <div class="editLabel">
                                <label>Nome</label>
                                <div class="inputInline">
                                    <input name="nome" type="text" class="inputField" value="{{ $perfilUsuario->nome }}" readonly />
                                </div>
                            </div>
                            <div id="slim">
                                <div class="editLabel">
                                    <label>Prontuário</label>
                                    <div class="inputInline">
                                        <input name="prontuario" type="text" class="inputField" value="{{ $perfilUsuario->prontuario }}" readonly />
                                    </div>
                                </div> 
                                @if($perfilUsuario->tipo === 'Comum')
                                    <div class="editLabel">
                                        <label>Turma</label>
                                        <div class="inputInline">
                                            @foreach($turmas as $turma)
                                                @if($perfilUsuario->turma_id === $turma->id)
                                                    <?php
                                                        $numTurma = $turma->numero;
                                                    ?>
                                                @endif
                                            @endforeach
                                            <input name="turma_id" type="text" class="inputField" value="{{ $numTurma }}" readonly />
                                        </div>
                                    </div> 
                                @elseif($perfilUsuario->tipo === 'Professor')
                                    <div class="editLabel">
                                        <label>Disciplinas</label>
                                        <div class="inputInline">
                                            <input name="disciplinas" type="text" class="inputField" value="{{ $perfilUsuario->disciplinas}}" readonly />
                                        </div>
                                    </div> 
                                @endif
                            </div>
                            <div class="editLabel">
                                <label>E-mail</label>
                                <div class="inputInline">
                                    <input name="email" type="text" class="inputField" value="{{ $perfilUsuario->email }}" readonly />
                                </div>
                            </div> 
                            <div class="editLabel">
                                <label>Link externo</label>
                                <div id="link">
                                    <input name="link[]" type="text" class="inputField" readonly />
                                </div>
                            </div> 
                            <div class="editLabel">
                                <label>Link externo</label>
                                <div id="link">
                                    <input name="link[]" type="text" class="inputField" readonly />
                                </div>
                            </div> 
                    </div>
                        {{-- <div id="two-content">
                            <div id="cardHistory">
                                <div class="content">
                                    <hr>
                                    <h3 id="userName">Histórico de <br> monitorias</h3>   
                                </div>
                            </div>
                            <div id="cardCalendary">
                            </div>
                        </div> --}}
                    </div>
                @endif
            @else
                <p>Não foi possível encontrar o perfil solicitado</p>
            @endif
        </section>
    </body>
</html>