<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title> Monitorando - Editar Monitoria</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/cadastroMonitorias.css') }}">
    <link rel="icon" href="{{ asset('assets/png/icon.png') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- mediaquery -->
    <script>


        $(document).ready(function() {        
            $("#codigo").change(function(){
                $(this).val($(this).val().toUpperCase());
            });
            $("#codigo").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url:"{{route('monitorias.autocomplete')}}",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token:"{{ csrf_token() }}",
                            codigo: request.term
                        }, 
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $("#codigo").val(ui.item.label);
                    $("#disciplina").val(ui.item.value);
                    return false;
                }
            });
            
            var wrapper = $("#input_fields_wrap");
            var add_button = $("#add_field_button");
            
            $(add_button).click(function(e){
                e.preventDefault();
                    $(wrapper).append('<div id="addUser">' + 
                                            '<input class="inputBorder" id="monitor_id" name="monitores[]" type="text"/>' + 
                                            '<a id="imgTrash" class="remove_field"><img  src="{{ asset("assets/svg/trash.svg") }}" alt="Trash"></a>' + 
                                       '</div>');
            });
            $(wrapper).on("click",".remove_field", function(e){
                e.preventDefault(); $(this).parent('div').remove(); 
            });
           
        });
    </script>
</head>

<body>
    <script type="text/javascript">   
        window.onload = function() {
            jQuery('#codigo').attr('maxlength','5');
        }
    </script>
    <section>
        <img src="{{ asset('assets/png/Monitorando2.png') }}" alt="Logo monitorando" id="monitorando">  
        <div id="cadastro" class="ui-widget">
            <form method="POST" action="{{ route('monitorias.editar', ['id' => $monitoria->id, 'monitoria' => $monitoria]) }}">
                @csrf
                @method('PUT')
                <h1> E D I T A R<br />D A D O S </h1>

                <p class="camp">
                    <label class="labelFont" for="codigo"> Código da Disciplina </label>
                    <input id="codigo" class="inputBorder"  name="codigo" value="{{ $monitoria->codigo ?? old('codigo') }}" type="text" placeholder="Ex: LPL" />
                    {{ $errors->has('codigo') ? $errors->first('codigo') : '' }}
                </p>

                <p class="camp" >
                    <label class="labelFont" for="disciplina"> @lang('lang.disciplinas') </label>
                    <input id="disciplina" class="inputBorder"  name="disciplina" value="{{ $monitoria->disciplina ?? old('disciplina') }}" type="text" />
                    {{ $errors->has('disciplina') ? $errors->first('disciplina') : '' }}
                </p>

                <p class="camp">
                    <label class="labelFont" for="conteudo"> Conteúdo </label>
                    <input class="inputBorder" name="conteudo" value="{{ $monitoria->conteudo ?? old('conteudo') }}" type="text" />
                    {{ $errors->has('conteudo') ? $errors->first('conteudo') : '' }}
                </p>

                <p class="camp">
                    <label class="labelFont" for="data"> Data </label>
                    <input class="inputBorder" name="data" value="{{ $monitoria->data ?? old('data') }}" type="date" />
                    {{ $errors->has('data') ? $errors->first('data') : '' }}
                </p>

                <div id="time">
                   <div>
                        <label class="labelFont" for="hora_inicio"> Horário inicial </label>
                        <input class="inputBorder" name="hora_inicio" value="{{ $monitoria->hora_inicio ?? old('hora_inicio') }}" type="time" />
                        {{ $errors->has('hora_inicio') ? $errors->first('hora_inicio') : '' }}
                   </div>

                   <div id="left">
                        <label class="labelFont" for="hora_fim"> Horário final </label>
                        <input class="inputBorder" name="hora_fim" value="{{ $monitoria->hora_fim ?? old('hora_fim') }}" type="time" />
                        {{ $errors->has('hora_fim') ? $errors->first('hora_fim') : '' }}      
                   </div>            
                </div>

                <p class="camp">
                    <label class="labelFont" for="local"> Local </label>
                    <input class="inputBorder"  name="local" value="{{ $monitoria->local ?? old('local') }}" type="text"/>
                    {{ $errors->has('local') ? $errors->first('local') : '' }}
                </p>

                <?php 
                    $monitoringMonitor = $monitoria->monitor;
                    $monitoringM = explode(' e ', $monitoringMonitor);
                    $i = 0
                ?>
                @foreach($monitoringM as $monitor)
                    @if($i == 0)
                        <div class="camp" id="input_fields_wrap">
                            <label id="labelMonitores" class="labelFont" for="monitores[$i]"> Prontuário do Monitor </label>
                            <div id="addUser">
                                <input class="inputBorder" id="monitor_id" name="monitores[]" value="{{ $monitor ?? old('monitores[$i]') }}" type="text"/>
                                <button id="add_field_button" type="button" onclick="addButton()">        
                                    <img src="{{ asset('assets/svg/plus.svg') }}" alt="Plus">  
                                </button>
                            </div>
                            {{ $errors->has('monitores[$i]') ? $errors->first('monitores[$i]') : '' }}
                        </div>
                        <?php
                            $i++;
                        ?>
                    @else
                        <script>
                            $(document).ready(function() {
                                $("#input_fields_wrap").append('<div id="addUser">' + 
                                            '<input class="inputBorder" id="monitor_id" name="monitores[]" value="{{ $monitor ?? old('monitores[$i]') }}" type="text"/>' + 
                                            '<a id="imgTrash" class="remove_field"><img  src="{{ asset("assets/svg/trash.svg") }}" alt="Trash"></a>' + 
                                       '</div>');
                                $(wrapper).on("click",".remove_field", function(e){
                                    e.preventDefault(); $(this).parent('div').remove(); 
                                });                            
                            });
                        </script>
                    @endif
                @endforeach

                <p class="camp">
                    <label class="labelFont" for="descricao"> Descrição </label>
                    <input class="inputBorder" name="descricao" value="{{ $monitoria->descricao ?? old('descricao') }}" type="text"/>
                    {{ $errors->has('descricao') ? $errors->first('descricao') : '' }}
                </p>

                <p>
                    <button id="button_cadastro" type="submit"> Alterar </button>
                </p>

            </form>
        </div>
    </section>

</body>

</html>