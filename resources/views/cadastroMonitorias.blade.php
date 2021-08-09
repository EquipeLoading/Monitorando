<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title> Monitorando - Cadastro Monitorias</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}">
    <link rel="icon" href="{{ asset('assets/png/icon.png') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- mediaquery -->
    <script>
        $(document).ready(function() {
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
        });
    </script>
</head>

<body>

        <div id="cadastro" class="ui-widget">
            <form method="POST" action="{{ route('monitorias.cadastro') }}">
                @csrf
                <h1> @lang('lang.Cadastro') </h1>

                <p id="camp">
                    <label class="labelFont" for="codigo"> Código da Disciplina </label>
                    <input id="codigo" class="inputBorder"  name="codigo" value="{{ old('codigo') }}" type="text" placeholder="Ex: LPL" />
                    {{ $errors->has('codigo') ? $errors->first('codigo') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="disciplina"> @lang('lang.disciplinas') </label>
                    <input id="disciplina" class="inputBorder"  name="disciplina" value="{{ old('disciplina') }}" type="text" readonly/>
                    {{ $errors->has('disciplina') ? $errors->first('disciplina') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="conteudo"> Conteúdo </label>
                    <input class="inputBorder" name="conteudo" value="{{ old('conteudo') }}" type="text" />
                    {{ $errors->has('conteudo') ? $errors->first('conteudo') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="data"> Data </label>
                    <input class="inputBorder" name="data" value="{{ old('data') }}" type="date" />
                    {{ $errors->has('data') ? $errors->first('data') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="hora_inicio"> Horário inicial </label>
                    <input class="inputBorder" name="hora_inicio" value="{{ old('hora_inicio') }}" type="time" />
                    {{ $errors->has('hora_inicio') ? $errors->first('hora_inicio') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="hora_fim"> Horário final </label>
                    <input class="inputBorder" name="hora_fim" value="{{ old('hora_fim') }}" type="time" />
                    {{ $errors->has('hora_fim') ? $errors->first('hora_fim') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="local"> Local </label>
                    <input class="inputBorder"  name="local" value="{{ old('local') }}" type="text"/>
                    {{ $errors->has('local') ? $errors->first('local') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="monitor"> Monitor </label>
                    <input class="inputBorder"  name="monitor" value="{{ old('monitor') }}" type="text"/>
                    {{ $errors->has('monitor') ? $errors->first('monitor') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="descricao"> Descrição </label>
                    <textarea class="inputBorder" name="descricao" value="{{ old('descricao') }}" type="text"></textarea>
                    {{ $errors->has('descricao') ? $errors->first('descricao') : '' }}
                </p>

                <p>
                    <button class="button_login" type="submit"> Cadastrar </button>
                </p>

            </form>
        </div>
    </section>

</body>

</html>