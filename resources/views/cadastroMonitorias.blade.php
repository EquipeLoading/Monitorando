<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title> @lang('lang.titleCadastroAluno')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}">
    <link rel="icon" href="{{ asset('assets/png/icon.png') }}">
    <!-- mediaquery -->
</head>

<body>

        <div id="cadastro">
            <form method="POST" action="{{ route('monitorias.cadastro', ['locale' => app()->getLocale()]) }}">
                @csrf
                <h1> @lang('lang.Cadastro') </h1>

                <p id="camp">
                    <label class="labelFont" for="disciplina"> @lang('lang.disciplinas') </label>
                    <input class="inputBorder"  name="disciplina" value="{{ old('disciplina') }}" type="text" />
                    {{ $errors->has('disciplina') ? $errors->first('disciplina') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="conteudo"> Conteúdo </label>
                    <input class="inputBorder" name="conteudo" value="{{ old('conteudo') }}" type="text" />
                    {{ $errors->has('conteudo') ? $errors->first('conteudo') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="data_horario"> Data e Horário </label>
                    <input class="inputBorder" name="data_horario" value="{{ old('data_horario') }}" type="datetime-local" />
                    {{ $errors->has('data_horario') ? $errors->first('data_horario') : '' }}
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
                    <input class="inputBorder" name="descricao" value="{{ old('descricao') }}" type="text" />
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