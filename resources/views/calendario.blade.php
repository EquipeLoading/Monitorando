@extends('topbar.topbar')

@section('conteudo')

<!DOCTYPE html>
<html>
<head>
    <title>Monitorando - Calendário</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
</head>
<body>
    @section('links')
        <a href="{{ route('index') }}"> HOME </a>
        <a href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
        <a class="active" href="{{ route('calendario') }}"> @lang('lang.Calendario') </a>
        <a href="#quem somos"> @lang('lang.QuemSomos') </a>   
    @endsection 
  
<div class="container">
    <br />
    <h1 class="text-center text-primary"><u>Calendário</u></h1>
    <br />

    <div id="calendar"></div>

</div>
   
<script>

$(document).ready(function () {
    var calendar = $('#calendar').fullCalendar({
        header:{
            left:'prev,next today',
            center:'title',
            right:'month'
            //right:'month,agendaWeek,agendaDay'
        },
        events: [
            <?php if(isset($data)){ ?>
                <?php for($i = 0; $i < count($data); $i++) { ?>
                {
                    <?php
                        $id = 0;
                        foreach($data as $d) {
                            if($d->id == $data[$i]['id']) {
                                $id = $d->id;
                            }
                        }
                    ?>
                    url: '{{ route('monitorias.informacoes', ['id' =>$id]) }}',
                    title: '<?php echo $data[$i]['disciplina']; ?>',
                    start: '<?php echo $data[$i]['data']; ?>',
                    end: '<?php echo $data[$i]['data']; ?>'
                },
                <?php } ?>
            <?php } ?>
        ],
    });

});
  
</script>
  
</body>
</html>

@endsection
