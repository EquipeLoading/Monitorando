<!DOCTYPE html>
<html>
    <head>
        <title> Monitorando - Perfil </title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/profile.css') }}">
    </head>
    <body>
        <section>
            <div id="content">
                <hr>
                <h3 id="userName">Seus dados!</h3>   
            </div>

            <div id="photoProfile">
                <img id="profile" src="{{asset('assets/svg/profile.svg')}}"/> 
                <button><img src="{{asset('assets/svg/edit.svg')}}"/></button>
            </div>
            <form>
               <div class="editLabel">
                    <label>Nome</label>
                    <div class="inputInline">
                        <input/>
                        <button class="buttonInline"><img src="{{asset('assets/svg/edit.svg')}}"/></button>
                    </div>
               </div> 
            </form>
        </section>
    </body>
</html>