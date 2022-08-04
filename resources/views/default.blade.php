<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <title>@yield('title')</title>
</head>
<header>
    <nav id="navbar_top" class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <p class="navbar-brand">ERP JABB</p>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="main_nav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{route('all.enterprise')}}"> Empresas </a></li>
                    <li class="nav-item"><a class="nav-link" href="#"> Produtos </a></li>
                    <li class="nav-item"><a class="nav-link" href="#"> Logs </a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<body>
    @yield('content')
</body>
<footer>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    @yield('scripts')
</footer>
</html>