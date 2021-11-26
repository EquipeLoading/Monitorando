@extends('topbar.topbar')

@section('conteudo')
<!DOCTYPE html>
    <html>
        <head>
            <title> Monitorando - Quem Somos </title>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="{{ asset('/css/quemSomos.css') }}">
            
        </head>

        <body>
            @section('links')
                <a href="{{ route('index') }}"> HOME </a>
                <a href="{{ route('monitorias') }}"> @lang('lang.Monitorias') </a>
                @if(Auth::check())
                    <a href="{{ route('calendario') }}"> @lang('lang.Calendario') </a>
                @endif
                <a class="active"  href="{{ route('quem.somos') }}"> @lang('lang.QuemSomos') </a>   
            @endsection 

            <section>
                <h1>QUEM SOMOS?</h1><br />
                <p>Olá, alunos/professores! Sejam muito bem-vindos ao site do Monitorando!</p>
                <p>A Equipe Loading é composta por estudantes do curso Técnico em Informática integrado ao Ensino Médio, no Instituto Federal de Educação, Ciência e Tecnologia de São Paulo, da turma de 2018. Atualmente estamos no 4º ano do curso, e o Projeto Monitorando é nosso Trabalho de Conclusão de Curso, realizado na disciplina de Prática para Desenvolvimento de Sistemas.</p>
                <p> A equipe é composta por seis alunos:</p>
                <ul>
                    <li>Ana Beatriz Silva Nascimento</li>
                    <li>Fernanda Cesar da Silva</li>
                    <li>Gustavo Angelozi Frederico</li>
                    <li>Larissa Yumi Ohashi</li>
                    <li>Mariana Souza Santos</li>
                    <li>Wilson de Souza Oliveira Junior</li>
                </ul>
                <h2>Projeto Monitorando</h2><br />
                <p>O Monitorando é uma plataforma on-line, acessível de qualquer navegador web com acesso à internet, onde todos os estudantes e monitores conseguem visualizar através de seu smartphone todas as monitorias agendadas, horários, e salas/laboratórios. Podendo filtrar as monitorias de acordo com seu curso e ano, para facilitar a localização. Além disso, os estudantes podem conversar diretamente com os monitores, através do fórum, para maiores esclarecimentos a respeito das monitorias. </p>
                <p>O nosso maior objetivo, está em levar a informação para todos os estudantes de forma fácil e rápida. Para que todos tenham acesso às monitorias e possam sanar todas as suas dúvidas a respeito de qualquer disciplina de forma prática.</p><br />
                <h2>Logo - Monitorando</h2><br />
                <img id="imgMonitorando" src="{{ asset('/assets/png/Monitorando.png') }}"/><br />
                <p>Nossa logo é representada por um monitor (silhueta com preenchimento na cabeça) responsável por transmitir conhecimento para o estudante (silhueta sem preenchimento na cabeça). O preenchimento faz alusão ao conhecimento (que o monitor possui, e o aluno não). E a silhueta de ambos os corpos unidos formam um "M" que se refere ao nome do nosso projeto, o Monitorando.</p><br />
                <h2>Nossos Canais</h2><br />
                <p>Nossos canais foram criados com o objetivo de atualizarmos as pessoas que acompanharam nosso projeto, com todas as alterações e progressões feitas durante o desenvolvimento, do início ao fim. Esperamos que gostem!</p><br />
                <p>• Blog: <a href="https://blogmonitorando.blogspot.com">https://blogmonitorando.blogspot.com</a></p>
                <p>• YouTube: <a href="https://www.youtube.com/channel/UC4h1uvG3epGzdxZNYYyVrBQ">https://www.youtube.com/channel/UC4h1uvG3epGzdxZNYYyVrBQ</a></p>
                <p>• SVN: <a href="https://svn.spo.ifsp.edu.br/viewvc/A6PGP/A2021-PDS413/EquipeLoading/">https://svn.spo.ifsp.edu.br/viewvc/A6PGP/A2021-PDS413/EquipeLoading/</a></p>
            </section>
        </body>
    </html>
@endsection