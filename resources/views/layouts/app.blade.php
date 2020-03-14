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

    <!-- Fonts 
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">-->
</head>
<body>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    
    <div id="app">
        <b-navbar toggleable="lg" type="dark" variant="info">
            <b-navbar-brand href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</b-navbar-brand>
        
            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
        
            <b-collapse id="nav-collapse" is-nav>
                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <b-nav-item href="{{ route('login') }}">{{ __('Login') }}</b-nav-item>
                        @if (Route::has('register'))
                            <b-nav-item href="{{ route('register') }}">{{ __('Register') }}</b-nav-item>
                        @endif
                    @else
                            <b-nav-item-dropdown text="{{ Auth::user()->name }}" right>
                                <b-dropdown-item href="#" @click="logout">
                                    {{ __('Logout') }}
                                </b-dropdown-item>
                            </b-nav-item-dropdown>
                    @endguest
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
