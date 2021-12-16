<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title> Monitorando - Mudar senha </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/senha.css') }}">
    <link rel="icon" href="{{ asset('assets/png/icon.png') }}">
    <!-- mediaquery -->
</head>

<body>
    <div id="topBar">
        <h1>Monitorando</h1>
    </div>

    <form method="POST" action="{{ route('password.update') }}">
        <h2>Redefina sua senha.</h2>
        <hr>
        @csrf
        <!--<label for="email">Informe um e-mail</label>
        <input type="text" name="email" placeholder="email@gmail.com"/>
        <p>{{ $errors->has('email') ? $errors->first('email') : '' }}</p>-->
        
        <label>Nova senha</label>
        <input type="password" name="password" placeholder="*******"/>
        <p>{{ $errors->has('password') ? $errors->first('password') : '' }}</p>

        <label>Insira novamente a senha</label>
        <input type="password" name="password_confirmation" placeholder="*******"/>
        <p>{{ $errors->has('password_confirmation') ? $errors->first('password_confirmation') : '' }}</p>
        
        <input type="hidden" name="token" value="{{ $token }}" />
        <input type="hidden" name="email" value="{{ session('email') }}" />
        <button class="buttonResetar margin" type="submit"><h3>Enviar</h3></button>
    </form>

</body>

</html>