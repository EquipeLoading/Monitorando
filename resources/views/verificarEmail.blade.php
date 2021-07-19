<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title> @lang('lang.titleVerificacaoEmail') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}">
    <link rel="icon" href="{{ asset('assets/png/icon.png') }}">
    <!-- mediaquery -->
</head>

<body>

    <p>@lang('lang.mensagemDeVerificacao')</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">@lang('lang.botaoVerificacaoEmail')</button>
    </form>

    <p>{{ isset($mensagem) && $mensagem != '' ? $mensagem : '' }}</p>

</body>

</html>