<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title> @lang('lang.titleVerificacaoEmail') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/verificarEmail.css') }}">
    <link rel="icon" href="{{ asset('assets/png/icon.png') }}">
    <!-- mediaquery -->
</head>

<body>

    {{-- <p>@lang('lang.mensagemDeVerificacao')</p> --}}
    <img src="{{ asset('assets/png/Monitorando.png') }}" alt="Logo monitorando" id="monitorando"> 
    <h3>
        Para darmos inicio a sua jornada no Monitorando da melhora forma possivel é necessário que <b>verifique o E-mail que te enviamos</b>. 
    </h3>

    <footer>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit">@lang('lang.botaoVerificacaoEmail')</button>
        </form>
    </footer>

    <p>{{ isset($mensagem) && $mensagem != '' ? $mensagem : '' }}</p>

</body>

</html>