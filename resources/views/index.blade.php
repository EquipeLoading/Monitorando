@extends('topbar.topbar')

@section('conteudo')
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <title> Monitorando </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/monitorias.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/textIndex.css') }}">
        
        <meta charset="utf-8" />
        <link rel="icon" href="{{ asset('assets/png/icon.png') }}">
        <!-- mediaquery -->
    </head>

    <body>
        @section('links')
            <a class="active" href="{{ route('index') }}"> HOME </a>
            <a href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
            <a href="{{ route('calendario') }}"> @lang('lang.Calendario') </a>
            <a href="{{ route('quem.somos') }}"> @lang('lang.QuemSomos') </a>   
        @endsection 
        <img src="{{ asset('/assets/svg/banner.svg') }}" alt="banner_monitorando" id="banner">

        <section>        
            

        </section>  

        <div class="info1">
            <h2>
                Monitorando
            </h2>
            <p> @lang('lang.Paragrafo1')</p>
        </div>
        <div class="info">
            <h2> @lang('lang.Praticidade') </h2>
            <p> @lang('lang.Paragrafo2')</p>
            <h3> @lang('lang.Vergonha') </h3>
            <p>@lang('lang.Paragrafo3')</p>
        </div>
    </body>

</html>
@endsection