<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title> Monitorando </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}">
    <!-- mediaquery -->
</head>

<body>

    <div class="topnav">
        <a class="active" href="#home"> HOME </a>
        <a href="#monitorias"> @lang('lang.Monitorias') </a>
        <a href="#calendario"> @lang('lang.Calendario') </a>
        <a href="#quem somos"> @lang('lang.QuemSomos') </a>
        <button class="button_on"><a href="{{ route('login', ['locale' => app()->getLocale()]) }}"> @lang('lang.Entrar') </a></button>
        <button class="button_new"><a href="{{ route('cadastro', ['tipo' => 'principal', 'locale' => app()->getLocale()]) }}"> @lang('lang.Registre-se') </a></button>
    </div>
    
    <section>
        <img src="{{ asset('/img/banner.jpg') }}" alt="banner_monitorando" id="banner">
        <div id="cadastro">
            <form method="POST" action="{{ route('cadastro.aluno', ['locale' => app()->getLocale()]) }}">
                @csrf
                <h1> @lang('lang.Cadastro') </h1>

                <p id="camp">
                    <label class="labelFont" for="nome"> @lang('lang.Nome') </label>
                    <input class="inputBorder" id="email" name="nome" value="{{ old('nome') }}" type="text" />
                    {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="email"> E-mail </label>
                    <input class="inputBorder" id="email" name="email" value="{{ old('email') }}" type="text"/>
                    {{ $errors->has('email') ? $errors->first('email') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="prontuario"> Prontuário </label>
                    <input class="inputBorder" id="email" name="prontuario" value="{{ old('prontuario') }}" type="text" placeholder="SPXXXXXXX" />
                    {{ $errors->has('prontuario') ? $errors->first('prontuario') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="turma">Turma</label>
                    <select class="inputBorder" id="email" name="turma_id">
                        @foreach($turmas as $turma)
                            <option value="{{ $turma->id }}" {{ old('turma_id') == $turma->id ? 'selected' : '' }}>{{ $turma->numero }}</option>
                        @endforeach
                    </select>
                    {{ $errors->has('turma') ? $errors->first('turma') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="senha"> @lang('lang.Senha') </label>
                    <input class="inputBorder" id="senha" name="senha" value="{{ old('senha') }}" type="password" />
                    {{ $errors->has('senha') ? $errors->first('senha') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="senha"> @lang('lang.ConfirmacaoDeSenha') </label>
                    <input class="inputBorder" id="senha" name="confirmacao_senha" value="{{ old('confirmacao_senha') }}" type="password" />
                    {{ $errors->has('confirmacao_senha') ? $errors->first('confirmacao_senha') : '' }}
                </p>

                <p>
                    <button class="button_login" type="submit"> @lang('lang.Registre-se') </button>
                </p>

            </form>
        </div>
    </section>

</body>

</html>