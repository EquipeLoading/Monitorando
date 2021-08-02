<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title> Monitorando </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}">
    <link rel="icon" href="{{ asset('assets/png/icon.png') }}">

    <!-- mediaquery -->
</head>

<body>

    <div class="topnav">
        <a class="active" href="{{ route('index') }}"> HOME </a>
        <a href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
        <a href="#calendario"> @lang('lang.Calendario') </a>
        <a href="#quem somos"> @lang('lang.QuemSomos') </a>
        <p class="nomeIndex">{{ $nome }}</p>
    </div>

    <section>
        <img src="{{ asset('/img/banner.jpg') }}" alt="banner_monitorando" id="banner">
    </section>

    @foreach($monitorias as $monitoria)
        <h3>{{ $monitoria->disciplina }}</h3>
        <p>{{ $monitoria->conteudo }}</p>
        <p>{{ $monitoria->monitor }}</p>
        <p>{{ $monitoria->local }}</p>
        <p>{{ $monitoria->data_horario }}</p>
        <p>{{ $monitoria->num_inscritos }}</p>
        <p>{{ $monitoria->descricao }}</p>
    @endforeach
</body>

</html>