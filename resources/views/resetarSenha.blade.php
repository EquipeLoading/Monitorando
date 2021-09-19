<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title> Monitorando - Mudar senha </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}">
    <link rel="icon" href="{{ asset('assets/png/icon.png') }}">
    <!-- mediaquery -->
</head>

<body>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <label>Informe um e-mail</label>
        <input type="text" name="email" />
        <button type="submit">Enviar</button>
    </form>

    <p>{{ session()->has('status') ? session('status') : '' }}</p>
    <p>{{ $errors->has('email') ? $errors->first('email') : '' }}</p>

</body>

</html>