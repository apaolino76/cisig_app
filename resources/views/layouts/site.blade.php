<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sistema.css') }}" rel="stylesheet">
</head>

<body class="antialiased">
    <header class="container-fluid bg-contatos sticky-top p-2">
        <section class="row d-flex flex-row justify-content-between align-items-center">
            <section class="col-12 text-center order-1 col-md-6 text-md-start order-md-0 ml-5">
                <a href="#"><i class="social-icon fa-brands fa-facebook fa-fw fa-lg" aria-hidden="true"></i></a>
                <a href="#"><i class="social-icon fa-brands fa-youtube fa-fw fa-lg" aria-hidden="true"></i></a>
                <a href="#"><i class="social-icon fa-brands fa-instagram fa-fw fa-lg" aria-hidden="true"></i></a>
                <a href="#"><i class="social-icon fa-brands fa-linkedin fa-fw fa-lg" aria-hidden="true"></i></a>
            </section>
            <section
                class="col-12 d-sm-flex flex-sm-column order-0 col-md-6 d-md-flex flex-md-row justify-content-md-between order-md-1">
                <section id="contato-telefonico" class="text-center">
                    <span>Fale com a UniSignorelli <i class="fa fa-phone fa-fw fa-lg"></i> (21) 3312-3000 </span>
                </section>
                <section id="contatos-whatsapp" class="text-center">
                    <span><i class="fa-brands fa-whatsapp fa-fw fa-lg"></i> Whatsapp (21) 96968-1125</span>
                </section>
            </section>
        </section>
    </header>

    <nav class="navbar navbar-expand-md bg-custom navbar-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('site.index') }}">
                <img src="{{ asset('img/LOGO_HP.png') }}" alt="Logotipo UniSignorelli" width="100" height="100"
                    class="d-inline-block align-text-middle">
                {{-- {{ config('app.name', 'Laravel') }} --}}
            </a>
            <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Graduação</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Pos-Graduação</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Cursos Sequenciais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Cursos Livres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Institucional</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Seja Parceiro</a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a href="{{ url('/home') }}" class="nav-link active">Home</a>
                        </li>
                        {{-- <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a> --}}
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link active">
                                <i class="fa fa-sign-in fa-lg"></i> {{ __('Login') }}
                            </a>
                        </li>
                        {{-- @if (Route::has('register'))
                            <li class="nav-item">
                                <a href="{{ route('register') }}"
                                    class="nav-link active">{{ __('Register') }}</a>
                            </li>
                        @endif --}}
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="vh-100">
        @yield('content')
    </main>

    <footer class="container-fluid signorelli-blue" id="main-footer">
        <section class="row">
            <section class="col" id="info-institucional">
                <h4>Sobre a Faculdade</h4>
                <ul class="footer-links-list">
                    <li>
                        <a href="#" alt="Apresentação da Faculdade Signorelli"
                            title="Apresentação da Faculdade Signorelli">Apresentação</a>
                    </li>
                    <li>
                        <a href="#" alt="Instalações da Faculdade Signorelli"
                            title="Instalações da Faculdade Signorelli">Instalações</a>
                    </li>
                    <li>
                        <a href="#" alt="Biblioteca da Faculdade Signorelli"
                            title="Biblioteca da Faculdade Signorelli">Biblioteca</a>
                    </li>
                    <li>
                        <a href="#" alt="Dirigentes da Faculdade Signorelli">Dirigentes</a>
                    </li>
                    <li>
                        <a href="#" alt="Corpo Docente da Faculdade Signorelli">Corpo Docente</a>
                    </li>
                    <li>
                        <a href="#" alt="Amparo Legal da Faculdade Signorelli">Amparo Legal</a>
                    </li>
                    <li>
                        <a href="#" alt="Fundação Mudes">Fundação Mudes</a>
                    </li>
                    <li>
                        <a href="#" alt="ISUPE e SOApE">ISUPE e SOApE</a>
                    </li>
                    <li>
                        <a href="#" alt="Pesquisa">Pesquisa</a>
                    </li>
                    <li>
                        <a href="#" alt="Revista Científica">Revista Científica</a>
                    </li>
                    <li>
                        <a href="#" alt="Avaliação Institucional">Avaliação Institucional</a>
                    </li>
                    <li>
                        <a href="#" alt="Atividades Complementares">Atividades Complementares</a>
                    </li>
                    <li>
                        <a href="#" alt="Editais - Faculdade Signorelli">Editais</a>
                    </li>
                </ul>

                <h4>Polos</h4>

                <ul class="footer-links-list">
                    <li>
                        <a href="/faculdade/polos/norte" alt="Polo - Norte">Norte</a>
                    </li>
                    <li>
                        <a href="/faculdade/polos/nordeste" alt="Polo - Nordeste">Nordeste</a>
                    </li>
                    <li>
                        <a href="/faculdade/polos/norte/centro-oeste" alt="Polo - Centro-oeste">Centro-oeste</a>
                    </li>
                    <li>
                        <a href="/faculdade/polos/norte/sudeste" alt="Polo - Sudeste">Sudeste</a>
                    </li>
                    <li>
                        <a href="/faculdade/polos/norte/sul" alt="Polo - Sul">Sul</a>
                    </li>
                </ul>

                <section class="">
                    <a class="border-link" alt="Mapa da Faculdade Signorelli" href="#" target="_self">Localize
                        no
                        mapa</a>
                </section>
            </section>
        </section>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

</html>
