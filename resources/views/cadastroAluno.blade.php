<?php   
        $mobile = FALSE;
        $user_agents = array("iPhone","iPad","Android","webOS","BlackBerry","iPod","Symbian","IsGeneric");
        foreach($user_agents as $user_agent){
            if (strpos($_SERVER['HTTP_USER_AGENT'], $user_agent) !== FALSE) {
                $mobile = TRUE;
                $modelo = $user_agent;
                break;
            }
        }     
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title> @lang('lang.titleCadastroAluno')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/cadastroAluno.css') }}">
    <link rel="icon" href="{{ asset('assets/png/icon.png') }}">
    <!-- mediaquery -->
</head>

<body>
    
    <section>
        <img src="{{ asset('assets/png/Monitorando2.png') }}" alt="Logo monitorando" id="monitorando"> 
        <hr>    
        <form id="cadastro" method="POST" action="{{ route('cadastro.aluno', ['locale' => app()->getLocale()]) }}">
                @csrf
                <h1> @lang('lang.Cadastro') </h1>
                <p id="camp">
                    <label class="labelFont" for="nome"> @lang('lang.Nome') </label>
                    <input class="inputBorder"  name="nome" value="{{ old('nome') }}" type="text" />
                    {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="email"> E-mail </label>
                    <input class="inputBorder"  name="email" value="{{ old('email') }}" type="email"/>
                    {{ $errors->has('email') ? $errors->first('email') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="prontuario"> @lang('lang.prontuario') </label>
                    <input class="inputBorder"  name="prontuario" value="{{ old('prontuario') }}" type="text" placeholder="SPXXXXXXX" />
                    {{ $errors->has('prontuario') ? $errors->first('prontuario') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="turma">@lang('lang.turma')</label>
                    <select class="inputBorder"  name="turma_id">
                        @foreach($turmas as $turma)
                            <option value="{{ $turma->id }}" {{ old('turma_id') == $turma->id ? 'selected' : '' }}>{{ $turma->numero }}</option>
                        @endforeach
                    </select>
                    {{ $errors->has('turma') ? $errors->first('turma') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="senha"> @lang('lang.Senha') </label>
                    <input class="inputBorder" name="senha" value="{{ old('senha') }}" type="password" />
                    {{ $errors->has('senha') ? $errors->first('senha') : '' }}
                </p>

                <p id="camp">
                    <label class="labelFont" for="senha"> @lang('lang.ConfirmacaoDeSenha') </label>
                    <input class="inputBorder" name="confirmacao_senha" value="{{ old('confirmacao_senha') }}" type="password" />
                    {{ $errors->has('confirmacao_senha') ? $errors->first('confirmacao_senha') : '' }}
                </p>

                <p>
                    <button class="button_registre" type="submit"> @lang('lang.Registre-se') </button>
                </p>

            </form>
    </section>

</body>

</html>