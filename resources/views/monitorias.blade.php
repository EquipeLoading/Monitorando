<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title> Monitorando - Monitorias </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}">
    <link rel="icon" href="{{ asset('assets/png/icon.png') }}">
    <!-- mediaquery -->
</head>

<body>

    <div class="topnav">
        <a href="{{ route('index') }}"> HOME </a>
        <a class="active" href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
        <a href="#calendario"> @lang('lang.Calendario') </a>
        <a href="#quem somos"> @lang('lang.QuemSomos') </a>
    </div>

    <section>
        <img src="{{ asset('/img/banner.jpg') }}" alt="banner_monitorando" id="banner">
    </section>

    @if($mostrarBotao == true)
        <button type="button"><a href="{{ route('monitorias.cadastro') }}"> Cadastre uma monitoria </a></button>
    @endif
</body>

</html>