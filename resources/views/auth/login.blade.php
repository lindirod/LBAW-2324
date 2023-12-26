@extends('layouts.app')

@section('content')
    <main class="general_container">
        <form method="POST" action="{{ route('login') }}" class="auth_form">
            {{ csrf_field() }}
            <div class="imgcontainer">
                <img src='/images/profiles/avatar.png' alt="Avatar" class="avatar">
            </div>
            <div class="container">
                <label for="email">E-mail</label>
                <input id="email" type="email" name="email" placeholder="Enter Email" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <span class="error">{{ $errors->first('email') }}</span>
                @endif

                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="Enter Password" required>

                @if ($errors->has('password'))
                    <span class="error">{{ $errors->first('password') }}</span>
                @endif

                <a href="{{ route('password.request') }}">Forgot your password?</a>

                <button type="submit" class="auth_submit">
                    Login
                </button>
                <a class="button button-outline" href="{{ route('register') }}">Don't you have an account? Sign up</a>

                @if(session('success'))
                    <div class="alert alert-success my-custom-alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </form>
        <div class="colimgcont">
            <h2 class="title_guest">Welcome to ProPlanner!</h2>
            <img src='/images/mockup_2.png' alt="Website Mockup" class="mockup">
            <h3 class="subtitle">Sign in to start your journey with us and turn project planning into an easy task! </h2>
        </div>
    </main>
@endsection
