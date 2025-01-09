<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        
        <!-- Incluindo o arquivo de estilo externo -->
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <header>
            <nav class="navbar navbar-expand-lg navbar-light container py-3">
                <a href="/" class="navbar-brand">
                    Carteira Financeira
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a href="/" class="nav-link">Home</a>
                        </li>
                        @if (Auth::check())
                            <li class="nav-item">
                                <a href="/Conta" class="nav-link">Conta bancária</a>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger navbar-btn">Logout: {{ Auth::user()->name }}</button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="/Login" class="navbar-brand">Entrar</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>

        <footer>
            <p class="mb-1">Anderson Ignácio Júnior &copy; 2025</p>
            <p class="mb-0">Carteira Financeira - Desafio Grupo Adriano Cobuccio</p>
        </footer>

        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>
</html>
