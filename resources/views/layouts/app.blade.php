<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'ProPlanner') }}</title>

    <!-- Styles -->
    <!--<link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">-->
    <link href="{{ url('css/navLogin.css') }}" rel="stylesheet">
    <link href="{{ url('css/common.css') }}" rel="stylesheet">
    <link href="{{ url('css/notif.css') }}" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/38229b6c34.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ url('js/app.js') }}" defer></script>
    <script type="text/javascript" src="{{ url('js/toggle.js') }}" defer></script>
    <script type="text/javascript" src="{{ url('js/popup.js') }}" defer></script>
    <script type="text/javascript" src="{{ url('js/filter_tasks.js') }}" defer></script>
    <script type="text/javascript" src="{{ url('js/remove_member.js') }}" defer></script>
    <script type="text/javascript" src="{{ url('js/filter_members.js') }}" defer></script>
    <script type="text/javascript" src="{{ url('js/filter_projtasks.js') }}" defer></script>
    <script type="text/javascript" src="{{ url('js/contacts.js') }}" defer></script>
    <script type="text/javascript" src="{{ url('js/invitation.js') }}" defer></script>
    <script type="text/javascript" src="{{ url('js/popup_proj.js') }}" defer></script>
    <script type="text/javascript" src="{{ url('js/filter_projects.js') }}" defer></script>
    @stack('styles')
</head>
<body>
    <nav>
    	@if(Auth::check() && auth()->user()->is_blocked === FALSE && auth()->user()->is_admin === FALSE)
        <a href="{{ url('homepage') }}"><img src="/images/logo.png" alt="logo"></a>
        @endif
        @if(Auth::check() && auth()->user()->is_blocked === TRUE)
        <a href="{{ url('blocked') }}"><img src="/images/logo.png" alt="logo"></a>
        @endif
        @if(Auth::check() && auth()->user()->is_admin === TRUE)
        <a href="{{ url('profile') }}"><img src="/images/logo.png" alt="logo"></a>
        @endif
        
        <ul class="navigation">
            @auth
                <li class="nav_elem">
           		@if(Auth::check() && auth()->user()->is_blocked === FALSE)
                    <form method="GET" action="{{ route('search') }}" class="search-form">
                        @csrf
                        <input id="search" type="text" name="search_query" class="small-search-bar" placeholder="Search">
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </li>
                <li class="nav_elem">
                    <a class="nav-link" href="{{ route('profile') }}">
                        <i class="fas fa-user"></i>
                        Profile
                    </a>
                </li>
                @if(!auth()->user()->is_admin)
                    @if(session('new_notifications'))
                        <div style="background-color: green; color: white; padding: 10px;">
                            You have new notifications! <span style="font-size: 20px;"></span>
                        </div>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('notifications') }}">
                            <i class="fas fa-bell"></i>
                            @if (session('unread_notifications'))
                                <span class="notification-dot"></span>
                            @endif
                        </a>
                        @endif
                    </li>
                @endif
                <li class="nav_elem"><a href="{{ url('/logout') }}">Logout <i class="fa-solid fa-right-from-bracket"></i></a></li>
            @endauth
            <div id="signup">
                @if(!Auth::check())
                    <a href="{{ url('/register') }}">Register</a>
                    <a href="{{ url('/login') }}">Login</a>
                @endif
            </div>
        </ul>
    </nav>
    <section>
        @yield('content')
    </section>
</body>
</html>
