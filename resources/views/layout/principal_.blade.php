<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAPI - @yield('titulo')</title>
</head>

<body>

    <header>
        @section('navbar')
            @include('layout._includes._navbar')
         <p>Aqui vamos </p>ter o nosso NavBar</p>
        @show
        <hr>
    </header>

    <main>
        <div>
            @yield('conteudo')
        </div>
    </main>
    <footer>
        <hr>
        @section('footer')
         @include('layout._includes._footer')
        @show
    </footer>

</body>

</html>