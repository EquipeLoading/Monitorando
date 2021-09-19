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

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <label for="email">Informe um e-mail</label>
        <input type="text" name="email" />
        <p>{{ $errors->has('email') ? $errors->first('email') : '' }}</p>
        <label>Nova senha</label>
        <input type="password" name="password" />
        <p>{{ $errors->has('password') ? $errors->first('password') : '' }}</p>
        <label>Insira novamente a senha</label>
        <input type="password" name="password_confirmation" />
        <p>{{ $errors->has('password_confirmation') ? $errors->first('password_confirmation') : '' }}</p>
        <input type="hidden" name="token" value="{{ $token }}" />
        <button type="submit">Enviar</button>
    </form>

</body>

</html>