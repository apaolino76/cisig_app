<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app-custom.css') }}" rel="stylesheet">    
</head>

<body class="antialiased d-flex flex-column min-vh-100 bg-custom-body">
    <nav class="navbar navbar-expand-md navbar-dark sticky-top bg-custom-header">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('img/LOGO_HP.png') }}" alt="Logotipo UniSignorelli" width="100" height="100"
                    class="d-inline-block align-text-middle">
                {{ config('app.name', 'Laravel') }}
            </a>

            <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('register') }}">
                                    <i class="fa-regular fa-file-lines fa-fw fa-lg" aria-hidden="true"></i> {{ __('Register') }}
                                </a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle active" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa-sharp fa-solid fa-user-gear fa-fw fa-lg" aria-hidden="true"></i> {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out fa-fw fa-lg" aria-hidden="true"></i> {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="container-fluid">
        @if((isset($errors) && count($errors) > 0) || session("pSucesso") || session("pAviso") || session("pErro")) 
        <div class="{{ session("pSucesso") ? "alert alert-success alert-dismissible fade show mt-2 mb-0" : (session("pAviso") ? "alert alert-warning alert-dismissible fade show mt-2 mb-0" : "alert alert-danger alert-dismissible fade show mt-2 mb-0") }}" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            @if(session("pSucesso"))
                <i class="fa-regular fa-circle-check fa-fw fa-lg" aria-hidden="true"></i>
                <strong>Info!</strong> {{ session("pSucesso") }}
            @elseif(session("pAviso"))
                <i class="fa fa-exclamation-triangle fa-fw fa-lg" aria-hidden="true"></i>
                <strong>Aviso!</strong> {{ session("pAviso") }}            
            @else
                <i class="fa fa-exclamation-triangle fa-fw fa-lg" aria-hidden="true"></i>
                @forelse($errors->all() as $error)
                    <strong>Erro!</strong> {{ $error }}
                @empty
                    <strong>Erro!</strong> {{ session("pErro") }}
                @endforelse
            @endif
        </div>                
        @endif
        <div class="row justify-content-center py-4">
            @if (Auth::check())
                @include('admin.sidebar')
            @endif

            <div class="col-md-10">
                @yield('content')
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-center navbar-dark mt-auto">
        <!-- Grid container -->
        <div class="container-fluid">
            <!-- Section: Social media -->
            <section class="p-1">
                <!-- Facebook -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
                    <i class="fa-brands fa-facebook fa-fw fa-lg"></i>
                </a>

                <!-- Twitter -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
                    <i class="fa-brands fa-twitter fa-fw fa-lg"></i>
                </a>

                <!-- Instagram -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
                    <i class="fa-brands fa-instagram fa-fw fa-lg"></i>
                </a>
            </section>
            <!-- Section: Social media -->
        </div>
        <!-- Grid container -->

        <!-- Copyright -->
        <div class="text-center p-2 text-white">
            © 2022 Copyright:
            <a class="text-white" href="#">UniSignorelli</a>
        </div>
        <!-- Copyright -->
    </footer>

    <!-- Scripts -->
<!--    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script type="text/javascript">
        $(document).ready(function(){
            setTimeout(function() {
                $(".alert").alert('close');
            }, 7000);

            $('[data-toggle="tooltip"]').tooltip();

            @stack('scripts')
        });
    </script>
</body>

</html>
