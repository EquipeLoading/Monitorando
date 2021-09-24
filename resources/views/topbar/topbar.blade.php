<?php
    use App\Models\User;
    $allNames = null;
    $name = null;
    $usuario = null;
    $usuarios = User::all();
    if(isset(Auth::user()->id)){
        $usuario = Auth::user();
        $allNames =  $usuario->nome;
        $name = explode(' ', $allNames);
        $allNames = $name[count($name)-1];
        $name = $name[0];
    }


        $mobile = FALSE;
        $user_agents = array("iPhone","iPad","Android","webOS","BlackBerry","iPod","Symbian","IsGeneric");
        foreach($user_agents as $user_agent){
            if (strpos($_SERVER['HTTP_USER_AGENT'], $user_agent) !== FALSE) {
                $mobile = TRUE;
                $modelo = $user_agent;
                break;
            }
        } 
?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script>
        function openNav() {
            document.getElementById("menuButton").style.display = 'none';
            document.getElementById("myNav").style.width = "70%";
        }
        function closeNav() {
            document.getElementById("menuButton").style.display = 'block';
            document.getElementById("myNav").style.width = "0%";
        }

        $(function () {
            border = 1;
            $(".profile").click(function () {
                if(border == 1){
                    $(this).css('border-bottom-left-radius', '0');
                    $(this).css('border-bottom-right-radius', '0');
                    $(this).css('border-top-left-radius', '3vh');
                    $(this).css('border-top-right-radius', '3vh');
                    $(this).css('transition', 'border-radius 0s');
                    $('#arrow').css('transform', 'rotate(-90deg)');
                    $('#arrow').css('transition', 'transform .3s linear');

                    border--;
                } else{
                    $('#arrow').css('transform', 'rotate(90deg)');
                    $('#arrow').css('transition', 'transform .3s linear');
                    $(this).css('transition', 'border-radius .7s cubic-bezier(1, 0, 1, 1)');
                    $(this).css('border-radius', '7vh');
                    border++;
                }
                $(this).next().toggleClass("collapsed");
            });
        });


        function hoverTop(count){
        //     session_start();
        //     $id = count;
        //     $_SESSION['dados'] = $id;
        //    console.log($_SESSION['dados'] + "os dados aqui");

            if(count == 0 ){
                document.getElementById('home').classList.add("active");
                document.getElementById('monitoria').classList.remove("active");
                document.getElementById('calendario').classList.remove("active");
                document.getElementById('quemSomos').classList.remove("active");
            } else if(count == 1){
                document.getElementById('home').classList.remove("active");
                document.getElementById('monitoria').classList.add("active");
                document.getElementById('calendario').classList.remove("active");
                document.getElementById('quemSomos').classList.remove("active");
                count = 1;
            } else if(count == 2){
                document.getElementById('home').classList.remove("active");
                document.getElementById('monitoria').classList.remove("active");
                document.getElementById('calendario').classList.add("active");
                document.getElementById('quemSomos').classList.remove("active");
            } else if(count == 3){
                document.getElementById('home').classList.remove("active");
                document.getElementById('monitoria').classList.remove("active");
                document.getElementById('calendario').classList.remove("active");
                document.getElementById('quemSomos').classList.add("active");
            }

        }
    </script>
    
<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/topbar.css') }}">
</head>

<body>
    <?php if($mobile){ ?>
        <div id="myNav" class="overlay">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <div class="overlay-content">
                 <?php if(!empty($name)){ ?>
                    <div id="profileContainer">
                        <button class="profile">
                            <img src="{{ asset('/assets/svg/profile.svg') }}" alt="Profile" id="Perfil">                
                                <?php if(!($name !== $allNames)){ ?>
                                    <text>{{ $name }}</text>
                                <?php } else{?>
                                    <text>{{ $name . " " . $allNames }}</text>
                                <?php } ?>
                            <img src="{{ asset('/assets/svg/right-arrow.svg') }}" alt="arrow" id="arrow">
                        </button>
                        <div class="collapsible-wrapper collapsed">
                            <div class="collapsible">
                                <a class="menu-item" href="{{ route('profile', ['id' => $usuario->id]) }}">
                                    Perfil
                                    <img src="{{ asset('/assets/svg/profile.svg') }}" alt="Profile" id="Perfil"> 
                                </a>
                                <form class="menu-item" method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit">
                                        Sair
                                        <img src="{{ asset('/assets/svg/logout.svg') }}" alt="Logout" id="logout">
                                    </button>
                                </form>
                            </div>
                        </div>                  
                    </div>
                    <a class="active" href="{{ route('index') }}"> HOME </a>
                    <a href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
                    <a href="{{ route('calendario') }}"> @lang('lang.Calendario') </a>
                    <a href="#quem somos"> @lang('lang.QuemSomos') </a>    
                    <div id="topFilter">
                        <form id="formSearch" action="{{ route('pesquisar') }}" method="GET">
                            <button id="search" type="submit"><img src="{{ asset('assets/svg/search.svg')}}"></button>
                            <input id="inputSearch" type="text" placeholder="Pesquisa.." name="pesquisa">
                        </form>
                    </div>
                <?php }else{ ?>
                    
                    <a class="active" href="{{ route('index') }}"> HOME </a>
                    <a href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
                    <a href="{{ route('calendario') }}"> @lang('lang.Calendario') </a>
                    <a href="#quem somos"> @lang('lang.QuemSomos') </a>
                    <div id="buttonRegister">
                        <button class="button_new"><a href="{{ route('cadastro') }}"> @lang('lang.Registre-se') </a></button>
                    </div>
            
            <?php } ?>
                    <div id="topFilter">
                        <form id="formSearch" action="{{ route('pesquisar') }}" method="GET">
                            <button id="search" type="submit"><img src="{{ asset('assets/svg/search.svg')}}"></button>
                            <input id="inputSearch" type="text" placeholder="Pesquisa.." name="pesquisa">
                        </form>
                    </div>
               
            </div>
        </div>
        <div id="background">
            <span id="menuButton" onclick="openNav()"><img src="{{ asset('/assets/svg/menu.svg') }}" alt="Menu" id="menuSvg"></span>          
        <div>
        {{-- @if(session()->has('search'))
            @if(session('pesquisaUsuarios')->isEmpty() && session('pesquisaMonitorias')->isEmpty())
                <p>Nenhum resultado foi encontrado para o termo "{{session('search')}}"</p>
            @else
                @if(!session('pesquisaUsuarios')->isEmpty())
                    @foreach(session('pesquisaUsuarios') as $resultadoUsuarios)
                        <a id="{{$resultadoUsuarios->id}}" class="modalBtn" href="{{ route('profile', ['id' => $resultadoUsuarios->id]) }}">
                            <p>{{$resultadoUsuarios->nome}}</p>
                            <p>{{$resultadoUsuarios->prontuario}}</p>
                        </a>
                    @endforeach
                @endif
                @if(!session('pesquisaMonitorias')->isEmpty())
                    @foreach(session('pesquisaMonitorias') as $resultadoMonitorias)
                        <div id="content-all">
                            <a id="{{$resultadoMonitorias->id}}" class="modalBtn" href="{{ route('monitorias.informacoes', ['id' => $resultadoMonitorias->id]) }}">
                                <div id="card">
                                    <?php 
                                        $date = new DateTime($resultadoMonitorias->data);
                                        $n = $date->getTimestamp();
                                        $data = date('D', $n);
                                        $semana = array(
                                            'Sun' => 'Domingo',
                                            'Mon' => 'Segunda-Feira',
                                            'Tue' => 'Terça-Feira',
                                            'Wed' => 'Quarta-Feira',
                                            'Thu' => 'Quinta-Feira',
                                            'Fri' => 'Sexta-Feira',
                                            'Sat' => 'Sábado'
                                        );
                                
                                    ?>
                                    <p id="date">{{ date("d/m", $n) . " • " . $semana["$data"]}}</p>
                                    <p id="hour">{{$resultadoMonitorias->hora_inicio." - ".$resultadoMonitorias->hora_fim}} </p>
                                    <p>{{ $resultadoMonitorias->conteudo }}</p>
                                    <p class="users"> 
                                        <?php 
                                            $monitoringMonitor = $resultadoMonitorias->monitor;
                                            $monitoringM = explode(' e ', $monitoringMonitor);
                                            $monitoringMonitor = $monitoringM[count($monitoringM)-1];
                                            $monitoringM = $monitoringM[0];
                                            $monitor1 = $usuarios->where('prontuario', $monitoringMonitor)->first();
                                            $monitor2 = $usuarios->where('prontuario', $monitoringM)->first();
                                        ?>
                                        <img src="{{ asset('assets/svg/user.svg') }}" id="user">
                                        @if(isset($monitor1))
                                            <text>{{ $monitor1->nome }}</text>    
                                        @else
                                            <text>{{ $monitoringMonitor }}</text>    
                                        @endif
                                    </p>
                                    <?php if(!($monitoringM === $monitoringMonitor)){ ?>
                                        <p class="users">
                                            <img src="{{ asset('assets/svg/user.svg') }}" id="user">
                                            @if(isset($monitor2))
                                                <text>{{ $monitor2->nome }}</text>
                                            @else
                                                <text>{{ $monitoringM }}</text>    
                                            @endif
                                        </p>
                                    <?php } else{?>   
                                        <p id="blank"></p>
                                    <?php }?>
                                    <p>{{ $resultadoMonitorias->local }}</p> 
                                    <p id="limit">
                                        <img src="{{ asset('assets/svg/user-group.svg') }}" id="user">
                                        <text>Participantes {{ $resultadoMonitorias->num_inscritos }}</text>
                                    </p>
                                    <p>{{ $resultadoMonitorias->descricao }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            @endif
        @else
            @yield('conteudo')
        @endif --}}
    <?php }else{ ?>   
        <?php if(empty($name)){ ?>
            <div class="topnav">
                <a class="active" href="{{ route('index') }}"> HOME </a>
                <a href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
                <a href="{{ route('calendario') }}"> @lang('lang.Calendario') </a>
                <a href="#quem somos"> @lang('lang.QuemSomos') </a>
                <div id="buttonRegister">
                    <button class="button_new"><a href="{{ route('cadastro') }}"> @lang('lang.Registre-se') </a></button>
                </div>
            </div> 
            <?php }else{ ?>              
                <div id="profileContainer">
                    <button class="profile" >
                        <img src="{{ asset('/assets/svg/profile.svg') }}" alt="Profile" id="Perfil"> 
                        <?php if(!($name !== $allNames)){ ?>
                            <text>{{ $name }}</text>
                        <?php } else{?>
                            <text>{{ $name . " " . $allNames }}</text>
                        <?php } ?>
                        
                    </button>
                    <div class="collapsible-wrapper collapsed">
                        <div class="collapsible">
                            <a class="menu-item"  href="{{ route('profile', ['id' => $usuario->id]) }}">
                                Perfil
                                <img src="{{ asset('/assets/svg/profile.svg') }}" alt="Profile" id="Perfil"> 
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">
                                    Sair
                                    <img src="{{ asset('/assets/svg/logout.svg') }}" alt="Logout" id="logout">
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="topnav">
                    <div id="topFilterAll">
                        <form id="formSearchAll" action="{{ route('pesquisar') }}" method="GET">
                            <button id="searchAll" type="submit"><img src="{{ asset('assets/svg/search.svg')}}"></button>
                            <input id="inputSearchAll" type="text" placeholder="Pesquisa.." name="pesquisa">
                        </form>
                    </div>
                    <div id="center">
                        <a id="home" class="active" onclick="hoverTop(0)" href="{{ route('index') }}"> HOME </a>
                        <a id="monitoria" onclick="hoverTop(1)" href="{{ route('monitorias')}}"> @lang('lang.Monitorias') </a>
                        <a id="calendario" onclick="hoverTop(2)" href="{{ route('calendario') }}"> @lang('lang.Calendario') </a>
                        <a id="quemSomos" onclick="hoverTop(3)" href="#quem somos"> @lang('lang.QuemSomos') </a>
                    </div>
                    
                </div> 
            <?php }?>
        
        @if(session()->has('search'))
            @if(session('pesquisaUsuarios')->isEmpty() && session('pesquisaMonitorias')->isEmpty())
                <p>Nenhum resultado foi encontrado para o termo "{{session('search')}}"</p>
            @else
                @if(!session('pesquisaUsuarios')->isEmpty())
                    @foreach(session('pesquisaUsuarios') as $resultadoUsuarios)
                        <a id="{{$resultadoUsuarios->id}}" class="modalBtn" href="{{ route('profile', ['id' => $resultadoUsuarios->id]) }}">
                            <p>{{$resultadoUsuarios->nome}}</p>
                            <p>{{$resultadoUsuarios->prontuario}}</p>
                        </a>
                    @endforeach
                @endif
                @if(!session('pesquisaMonitorias')->isEmpty())
                    @foreach(session('pesquisaMonitorias') as $resultadoMonitorias)
                        <div id="content-all">
                            <a id="{{$resultadoMonitorias->id}}" class="modalBtn" href="{{ route('monitorias.informacoes', ['id' => $resultadoMonitorias->id]) }}">
                                <div id="card">
                                    <?php 
                                        $date = new DateTime($resultadoMonitorias->data);
                                        $n = $date->getTimestamp();
                                        $data = date('D', $n);
                                        $semana = array(
                                            'Sun' => 'Domingo',
                                            'Mon' => 'Segunda-Feira',
                                            'Tue' => 'Terça-Feira',
                                            'Wed' => 'Quarta-Feira',
                                            'Thu' => 'Quinta-Feira',
                                            'Fri' => 'Sexta-Feira',
                                            'Sat' => 'Sábado'
                                        );
                    
                                    ?>
                                    <p id="date">{{ date("d/m", $n) . " • " . $semana["$data"]}}</p>
                                    <p id="hour">{{$resultadoMonitorias->hora_inicio." - ".$resultadoMonitorias->hora_fim}} </p>
                                    <p>{{ $resultadoMonitorias->conteudo }}</p>
                                    <p class="users"> 
                                        <?php 
                                            $monitoringMonitor = $resultadoMonitorias->monitor;
                                            $monitoringM = explode(' e ', $monitoringMonitor);
                                            $monitoringMonitor = $monitoringM[count($monitoringM)-1];
                                            $monitoringM = $monitoringM[0];
                                            $monitor1 = $usuarios->where('prontuario', $monitoringMonitor)->first();
                                            $monitor2 = $usuarios->where('prontuario', $monitoringM)->first();
                                        ?>
                                        <img src="{{ asset('assets/svg/user.svg') }}" id="user">
                                        @if(isset($monitor1))
                                            <text>{{ $monitor1->nome }}</text>    
                                        @else
                                            <text>{{ $monitoringMonitor }}</text>    
                                        @endif
                                    </p>
                                    <?php if(!($monitoringM === $monitoringMonitor)){ ?>
                                        <p class="users">
                                            <img src="{{ asset('assets/svg/user.svg') }}" id="user">
                                            @if(isset($monitor2))
                                                <text>{{ $monitor2->nome }}</text>
                                            @else
                                                <text>{{ $monitoringM }}</text>    
                                            @endif
                                        </p>
                                    <?php } else{?>   
                                        <p id="blank"></p>
                                    <?php }?>
                                    <p>{{ $resultadoMonitorias->local }}</p> 
                                    <p id="limit">
                                        <img src="{{ asset('assets/svg/user-group.svg') }}" id="user">
                                        <text>Participantes {{ $resultadoMonitorias->num_inscritos }}</text>
                                    </p>
                                    <p>{{ $resultadoMonitorias->descricao }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            @endif
        @else
            @yield('conteudo')
        @endif
        
    <?php } ?>
        
</body>