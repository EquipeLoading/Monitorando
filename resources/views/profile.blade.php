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
            var max_campos = 10;
            var wrapper = $("#input_fields_wrap");
            var add_button = $("#buttonAdd");

            var count = 1;
            $(add_button).click(function(e){
                e.preventDefault();
                if(count < max_campos){
                    count++;
                    $(wrapper).append('<div id="link">' + 
                                            '<input type="text"/>' + 
                                            '<button class="remove_field"><img  src="{{ asset("assets/svg/trash.svg") }}" alt="Trash"></button>' + 
                                       '</div>');
                }
            });
            $(wrapper).on("click",".remove_field", function(e){
                e.preventDefault(); $(this).parent('div').remove(); count--;
            });
            $(document).ready(function() {
                var contador = 0;
                $(".buttonInline").click(function(e) {
                    e.preventDefault();
                    if(contador == 0) {
                        $('.inputField').attr('readonly', false);
                        $("#update").append('<button type="submit">Atualizar dados</button>');
                        contador++;
                    }
                });
            });
        </script>
        <section>
            <?php
                $numTurma;
            ?>
            <div class="content">
                <hr >
                <h3 id="userName">Seus dados!</h3>   
            </div>
            <div id="all-content">
                <div id="cardProfile">
                    <div id="photoProfile">
                        <img id="profile" src="{{asset('assets/svg/profile.svg')}}"/> 
                        <button><img src="{{asset('assets/svg/edit.svg')}}"/></button>
                    </div>
                    <form id="update" method="POST" action="{{ route('profile') }}">
                        @csrf
                        @method('PUT')
                        <div class="editLabel">
                                <label>Nome</label>
                                <div class="inputInline">
                                    <input name="nome" type="text" class="inputField" value="{{ $usuario->nome }}" readonly />
                                    <button type="button" class="buttonInline"><img src="{{asset('assets/svg/edit.svg')}}"/></button>
                                </div>
                                {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                        </div> 
                        <div id="slim">
                                <div class="editLabel">
                                    <label>Prontuário</label>
                                    <div class="inputInline">
                                        <input name="prontuario" type="text" class="inputField" value="{{ $usuario->prontuario }}" readonly />
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
                                            <input name="turma_id" type="text" class="inputField" value="{{ $numTurma }}" readonly />
                                            <button type="button" class="buttonInline"><img src="{{asset('assets/svg/edit.svg')}}"/></button>
                                        </div>
                                        {{ $errors->has('turma_id') ? $errors->first('turma_id') : '' }}
                                    </div> 
                                @elseif($usuario->tipo === 'Professor')
                                    <div class="editLabel">
                                        <label>Disciplinas</label>
                                        <div class="inputInline">
                                            <input name="disciplinas" type="text" class="inputField" value="{{ $usuario->disciplinas }}" readonly />
                                            <button type="button" class="buttonInline"><img src="{{asset('assets/svg/edit.svg')}}"/></button>
                                        </div>
                                        {{ $errors->has('disciplinas') ? $errors->first('disciplinas') : '' }}
                                    </div> 
                                @endif
                        </div>
                        <div class="editLabel">
                            <label>E-mail</label>
                            <div class="inputInline">
                                <input name="email" type="text" class="inputField" value="{{ $usuario->email }}" readonly />
                                <button type="button" class="buttonInline"><img src="{{asset('assets/svg/edit.svg')}}"/></button>
                            </div>
                            {{ $errors->has('email') ? $errors->first('email') : '' }}
                        </div> 
                        <div class="editLabel" id="input_fields_wrap">
                            <label>Link externo</label>
                            <div id="link">
                                <input name="link[]" type="text" class="inputField" readonly />
                                <button type="button" class="buttonInline"><img src="{{asset('assets/svg/edit.svg')}}"/></button>
                                <button id="buttonAdd"><img src="{{asset('assets/svg/plus.svg')}}"/></button>
                            </div>
                        </div> 
                        <div class="editLabel" id="input_fields_wrap">
                            <label>Link externo</label>
                            <div id="link">
                                <input name="link[]" type="text" class="inputField" readonly />
                                <button type="button" class="buttonInline"><img src="{{asset('assets/svg/edit.svg')}}"/></button>
                                <button id="trash"><img src="{{asset('assets/svg/trash.svg')}}"/></button>
                            </div>
                        </div> 
                    </form>
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
        </section>
    </body>
</html>