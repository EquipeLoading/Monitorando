@extends('topbar.topbar')

@section('conteudo')
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="utf-8" />
        <title> Monitorando - Monitorias </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/monitorias.css') }}">
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
                @if($mostrarBotao == true)
                    <div id="buttons">
                        <button type="button" class="monitoriaButton"><a href="{{ route('monitorias.cadastro') }}"> Cadastre uma monitoria </a></button>
                        <button type="button" class="monitoriaButton" ><a href="{{ route('monitorias.cancelar') }}"> Cancele uma monitoria </a></button>
                    </div>
                @endif
            </div>         
            <?php }?>

        </section>  

    </body>

    </html>
@endsection