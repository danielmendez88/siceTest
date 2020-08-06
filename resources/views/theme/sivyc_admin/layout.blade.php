<!DOCTYPE html>
<html lang="es">

    <head>
        <title>@yield('title', '')</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <link rel="shortcut icon" href="{{ URL::asset('favicon.ico') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
        <!-- Google Fonts Roboto -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">


        <!-- CSS Implementing Plugins -->
        <link rel="stylesheet" href="{{asset("css/argon.css?v=1.2.0") }}">
        <link rel="stylesheet" href="{{asset("vendor/nucleo/css/nucleo.css") }}">
        <link rel="stylesheet" href="{{asset("vendor/@fortawesome/fontawesome-free/css/all.min.css") }}" type="text/css">
        <link rel="stylesheet" href="{{asset("css/mdb.min.css") }}">

    </head>

    <body>

        <!--MENU-->
        @include("theme.sivyc_admin.menu")
        <!--MENU-->

        <!-- Main content -->
        <div class="main-content" id="panel">
            <!-- Topnav -->
            <!--HEADER DE  LA PAGINA-->
            @include("theme.sivyc_admin.header")
            <!--HEADER DE LA PAGINA FIN-->

            <!-- PAGINA -->
            @yield("content")
            <!-- PAGINA FIN -->
        </div>

        <script src="{{asset("js/scripts/jquery.min.js")}}"></script>
        <script src="{{asset("vendor/bootstrap/dist/js/bootstrap.bundle.min.js")}}"></script>
        <!--argon-->
        <script src="{{asset("vendor/scrollbar/jquery.scrollbar.min.js") }}"></script>
        <script src="{{asset("vendor/js-cookie/js.cookie.js") }}"></script>
        <script src="{{asset("vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js") }}"></script>
        <script src="{{asset("js/scripts/argon.js?v=1.2.0") }}"></script>
        <script src="{{ asset("js/mdb.min.js") }}"></script>
        @yield("scripts_content")
    </body>

</html>

