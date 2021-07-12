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
        <p class="nomeIndex">{{ $nome }}</p>
    </div>

    <section>
        <img src="{{ asset('/img/banner.jpg') }}" alt="banner_monitorando" id="banner">
    </section>
</body>

</html>