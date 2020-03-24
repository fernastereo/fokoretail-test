<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
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
<body class="h-100">
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    
    <div id="app" class="h-100">
        <b-navbar toggleable="lg" type="light" variant="primary">
            <b-navbar-brand href="{{ url('/home') }}">{{ config('app.name', 'Laravel') }}</b-navbar-brand>
        
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
                                <b-dropdown-item href="{{ route('invitation.invite') }}">
                                    {{ __('Invite a Friend') }}
                                </b-dropdown-item>
                                <b-dropdown-item href="{{ route('profile.edit') }}">
                                    {{ __('Profile') }}
                                </b-dropdown-item>
                                <b-dropdown-item href="#" @click="logout">
                                    {{ __('Logout') }}
                                </b-dropdown-item>
                            </b-nav-item-dropdown>
                    @endguest
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>

        <main class="py-1" style="height: calc(100vh - 56px);">
            @yield('content')
        </main>
    </div>
</body>
</html>
