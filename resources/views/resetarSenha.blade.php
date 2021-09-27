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
    <script>
            $(document).ready(function(){
                $('#sendSenha').on('click', function() {
                        $(".modalResetSenha").css('display', 'block');
                    });
                });
    </script>
    <div id="topBar">
        <h1>Monitorando</h1>
    </div>

    <div class="modalResetSenha">
        aaa
        {{ session()->has('status') ? session('status') : '' }}
        {{ $errors->has('email') ? $errors->first('email') : '' }}
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        <h2>Encontre sua conta.</h2>
        <hr>
        @csrf
        <div class="column">
            <label>Insira seu email para procurar a sua conta.</label>
            <input type="text" name="email" placeholder="email@gmail.com"/>
            <div class="row">
                <a class="buttonResetar" id="buttonVoltar" href="{{ route('login') }}"><h3>Voltar</h3></a>
                <button id="sendSenha" class="buttonResetar" type="submit"><h3>Enviar</h3></button>
            </div>
        </div>
    </form>

    

</body>

</html>