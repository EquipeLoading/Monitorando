    <?php
        $name =  $nome;
        $allNames = explode(' ', $name);
        $name = $allNames[0].' '.$allNames[count($allNames)-1];
    ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title> Monitorando </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/index.css') }}">
    <link rel="icon" href="{{ asset('assets/png/icon.png') }}">

    <!-- mediaquery -->
</head>

<body>
    
    <div class="topnav">
        <a class="active" href="{{ route('index') }}"> HOME </a>
        <a href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
        <a href="#calendario"> @lang('lang.Calendario') </a>
        <a href="#quem somos"> @lang('lang.QuemSomos') </a>
        <button id="profile">
            <img src="{{ asset('/assets/svg/profile.svg') }}" alt="Profile" id="Perfil"> 
            <text>{{ $name }}</text>
        </button>
    </div>
    <img src="{{ asset('/img/banner.jpg') }}" alt="banner_monitorando" id="banner">
    <section>
        @foreach($monitorias as $monitoria)
            <?php 
                $monitoringName = $monitoria->disciplina;
                $monitoring = explode(' - ', $monitoringName);
                $monitoringName = $monitoring[count($monitoring)-1];
                $monitoring = $monitoring[0];
            ?>
            <div id="content">
                <hr>
                <div id="discipline">
                    <h3 id="titleDiscipline">{{ $monitoring }}</h3>
                    <?php if(!($monitoring === $monitoringName)){ ?>
                        <h3 id="nameDiscipline">{{ $monitoringName }}</h3>   
                    <?php }?>   
                </div>
            </div>
            <div id="card">
                <!-- <p>{{ $monitoria->conteudo }}</p> -->
                <p id="hour">{{ $monitoria->data_horario }}</p>
                <p class="users"> 
                    <?php 
                        $monitoringMonitor = $monitoria->monitor;
                        $monitoringM = explode(' e ', $monitoringMonitor);
                        $monitoringMonitor = $monitoringM[count($monitoringM)-1];
                        $monitoringM = $monitoringM[0];
                    ?>
                    <img src="{{ asset('assets/svg/user.svg') }}" id="user">
                    <text>{{ $monitoringMonitor }}</text>                   
                </p>
                <p class="users">
                    <?php if(!($monitoringM === $monitoringMonitor)){ ?>
                        <img src="{{ asset('assets/svg/user.svg') }}" id="user">
                        <text>{{ $monitoringM }}</text>
                </p>
                <?php } else{?>   
                    <p class="users"></p>
                <?php }?>
                <!-- <p>{{ $monitoria->local }}</p> -->
                <p id="limit">
                    <img src="{{ asset('assets/svg/user-group.svg') }}" id="user">
                    <text>Participantes {{ $monitoria->num_inscritos }}</text>
                </p>
                
                <p id="details">
                    <text>Inscrever-se</text>
                </p>
                <!-- <p>{{ $monitoria->descricao }}</p> -->
            </div>
        @endforeach
    </section>
</body>

</html>