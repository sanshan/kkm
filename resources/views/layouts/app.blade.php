<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav id="topMenu" class="navbar" role="navigation" aria-label="main navigation">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item" href="/">
                    {{ config('app.name', 'ККМ') }}
                </a>
                <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false"
                   data-target="navbarBasicExample">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>
            <div class="navbar-menu">
                <div class="navbar-start">
                    <a class="navbar-item">
                        @lang('pages.home')
                    </a>
                </div>
                <div class="navbar-end">
                    <div class="navbar-item">
                        @auth
                            <form id="logout-form" class="is-hidden" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                            <div class="buttons">
                                <a class="has-margin-right-5" href="#" role="button">
                                    {{ Auth::user()->name }}
                                </a>
                                <a class="button is-light" href="#"
                                   onclick="document.getElementById('logout-form').submit()">
                                    @lang('pages.Logout')
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <section id="mainContent" class="section">
        <div class="container">
            @yield('content')
        </div>
    </section>
</div>
</body>
</html>
