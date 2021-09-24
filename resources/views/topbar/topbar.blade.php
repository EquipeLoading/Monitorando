<?php
    $allNames = null;
    $name = null;
    $usuario = Auth::user();
    if(isset($usuario)){
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
                                <a class="menu-item" href="{{ route('profile') }}">
                                    Perfil
                                    <img src="{{ asset('/assets/svg/profile.svg') }}" alt="Profile" id="Perfil"> 
                                </a>
                                <a class="menu-item" href="{{ route('login') }}">
                                    Sair
                                    <img src="{{ asset('/assets/svg/logout.svg') }}" alt="Logout" id="logout">
                                </a>
                            </div>
                        </div>                  
                    </div>
                    <a class="active" href="{{ route('index') }}"> HOME </a>
                    <a href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
                    <a href="#calendario"> @lang('lang.Calendario') </a>
                    <a href="#quem somos"> @lang('lang.QuemSomos') </a>      
                <?php }else{ ?>
                    
                    <a class="active" href="{{ route('index') }}"> HOME </a>
                    <a href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
                    <a href="#calendario"> @lang('lang.Calendario') </a>
                    <a href="#quem somos"> @lang('lang.QuemSomos') </a>
                    <div id="buttonRegister">
                        <button class="button_new"><a href="{{ route('cadastro') }}"> @lang('lang.Registre-se') </a></button>
                    </div>
            
            <?php } ?>
            </div>
        </div>
        <div id="background">
            <span id="menuButton" onclick="openNav()"><img src="{{ asset('/assets/svg/menu.svg') }}" alt="Menu" id="menuSvg"></span>          
        <div>
    <?php }else{ ?>   
        <?php if(empty($name)){ ?>
            <div class="topnav">
                <a class="active" href="{{ route('index') }}"> HOME </a>
                <a href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
                <a href="#calendario"> @lang('lang.Calendario') </a>
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
                            <a class="menu-item"  href="{{ route('profile') }}">
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
                    <a class="active" href="{{ route('index') }}"> HOME </a>
                    <a href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
                    <a href="#calendario"> @lang('lang.Calendario') </a>
                    <a href="#quem somos"> @lang('lang.QuemSomos') </a>
                    
                </div> 
            <?php }?>
        
        
    <?php } ?>
        
    @yield('conteudo')
</body>