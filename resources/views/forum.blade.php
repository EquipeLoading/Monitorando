@extends('topbar.topbar')

@section('conteudo')

    <!DOCTYPE html>
    <html lang="pt-br">

        <head>
            <meta charset="utf-8" />
            <title> Monitorando - {{ $topico->topico }} </title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="{{ asset('/css/index.css') }}">
            <link rel="icon" href="{{ asset('assets/png/icon.png') }}">
            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <!-- mediaquery -->
        </head>

        <body>
            <script>
                $(document).ready(function() {
                    $("#adicionarResposta").click(function(e) {
                        e.preventDefault(); 
                        $("#novaResposta").append('<form method="POST" action="{{ route('monitorias.forum', ['id' => $monitoria_id, 'topico' => $topico->id]) }}">' +
                                                        '@csrf' +
                                                        '<label for="resposta">Resposta</label>' +
                                                        '<textarea type="text" name="resposta">{{ old('resposta') }}</textarea>' + 
                                                        '<button type="submit">Enviar Resposta</button>' +
                                                    '</form>');
                        $("#adicionarResposta").remove();
                    });
                });
            </script>
            <div id="mensagens">
                {{ session()->has('editado') ? session('editado') : '' }}
                <h3>{{ $topico->topico }}</h3>
                @foreach($mensagens as $mensagem)
                    <p>{{ $mensagem->mensagem }}</p>
                    @if($mensagem->user_id == Auth::user()->id)
                        <button type="button" id="editarResposta{{$mensagem->id}}">Editar resposta</button>
                        <button type="button"><a href="{{ route('monitorias.excluir.mensagem', ['id' => $mensagem->id]) }}">Excluir resposta</a></button>
                        <script>
                            $(document).ready(function() {
                                var editar = true;
                                $("#editarResposta{{$mensagem->id}}").click(function(e) {
                                    e.preventDefault(); 
                                    $("#mensagens").append('<form method="POST" id="editarMensagem" action="{{ route('monitorias.editar.mensagem', ['id' => $mensagem->id]) }}" enctype="multipart/form-data">' +
                                                            '@csrf' +
                                                            '<div id="forumMensagem">' + 
                                                                '<textarea name="mensagem" form="editarMensagem">{{ $mensagem->mensagem ?? old('mensagem') }}</textarea>' + 
                                                                '<input type="file" class="form-control-file" name="imagem" id="avatarFile" aria-describedby="fileHelp">' +
                                                                '<small id="fileHelp" class="form-text text-muted"><br/>Insira uma imagem válida</small>' +
                                                                '<button type="submit">Editar Mensagem</button>' +
                                                            '</div>' +
                                                        '</form>');
                                });
                            });
                        </script>
                    @endif
                @endforeach
            </div>
            <div id="novaResposta">
                <button id="adicionarResposta" type="button">Adicionar uma resposta</button>
                {{ $errors->has('resposta') ? $errors->first('resposta') : '' }}
            </div>
        </body>

    </html>

@endsection