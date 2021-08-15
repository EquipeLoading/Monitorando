@extends('topbar.topbar')

@section('conteudo')
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <title> Monitorando </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/monitorias.css') }}">
        <meta charset="utf-8" />
        <link rel="icon" href="{{ asset('assets/png/icon.png') }}">
        <!-- mediaquery -->
    </head>

    <body>

        <img src="{{ asset('/assets/svg/banner.svg') }}" alt="banner_monitorando" id="banner">

        <section>        
            <?php if(!empty($nome)){?>
                <div id="all-content">
                    <div id="content">
                        <hr>
                        <h3 id="userName">Ola <br> {{ $nome }}!</h3>   
                    </div>
                </div>         
            <?php }?>

        </section>  
    </body>

</html>
@endsection