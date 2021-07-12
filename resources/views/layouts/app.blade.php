<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Is @yield('page_action', 'this') leftist? | Lefterboxd</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @guest
    <script>window.isLoggedIn = false;</script>
    @else
    <script>window.isLoggedIn = true;</script>
    @endguest
</head>
<body>
    <div id="app">
        <nav id="site-nav" class="navbar container" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <a class="navbar-item" href="{{ url('/') }}">
                    <img src="/logo.svg" class="logo" width="auto" height="25px" />
                    <span class="app-title">Lefterboxd</span>
                </a>

                <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="menu">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="menu" class="navbar-menu">
                <div class="navbar-start">

                </div>

                <div class="navbar-end">
                    @guest
                    <div class="navbar-item">
                        <div class="buttons">
                            <a class="button is-primary" href="{{ route('register') }}">
                                <strong>Sign up</strong>
                            </a>

                            <a class="button is-light" href="{{ route('login') }}">
                                Log in
                            </a>
                        </div>
                    </div>
                    @else
                    <div class="navbar-item">
                        <a class="button is-light" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                    @endguest
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>

        <footer id="site-footer">
            <div>A fan project to help make the world better.</div>
            <div>
                <a href="https://globehell.libsyn.com/">
                    <img src="/images/globehell.jpg" class="globe" alt="globe hell warning" />
                </a>
            </div>
        </footer>
    </div>
</body>
</html>
