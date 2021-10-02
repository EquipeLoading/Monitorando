<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>404 Error</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/404.css') }}">
        <link rel="icon" href="{{ asset('assets/png/icon.png') }}">

    </head>

    <body>
        <img src="{{asset('assets/svg/404.svg') }}">
        <a href="{{ route('index') }}"><h2>Voltar</h2></a>
    </body>
</html>