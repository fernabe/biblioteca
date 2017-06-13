<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/styles.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app" class="wrapper">
        <nav id="navegacion" class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->nombre }} {{Auth::user()->apellido1}} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li data-toggle="modal" data-target="#ver-perfil">
                                        <a href="#">
                                            <span class="glyphicon glyphicon-user"></span> Perfil
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <span class="glyphicon glyphicon-log-out"></span> Salir
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
 
        <section id="section">
            <div id="contenido" class="container" style="padding-top:20px;">
                @yield('content')
            </div>
        </section>
    </div>
 
    <!--<footer id="footer">
        <div class='container'>
            <p class="text-center">LaBiblioteca</p>
        </div>
    </footer>-->

     <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script type="text/javascript">
     /*  $(document).ready(function(){
            var app =$('#app').height();
            var nav = $('#navegacion').height();
            var pie =$('#footer').height();
            console.log(app-nav-pie);
            var altura = app - nav - pie;
            $('#contenido').height(altura);
       });
       $(window).resize(function(){
            var app =$('#app').height();
            var nav = $('#navegacion').height();
            var pie =$('#footer').height();
            console.log(app-nav-pie);
            var altura = app - nav - pie;
            $('#contenido').height(altura);
       });*/
    </script>
</body>
</html>