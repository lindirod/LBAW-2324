@extends('layouts.app')

@section('content')
<main class="general_container">
  <form method="POST" action="{{ route('register') }}" class="auth_form">
      {{ csrf_field() }}
      <div class="imgcontainer">
          <img src='/images/profiles/avatar.png' alt="Avatar" class="avatar">
      </div>
      <div class="container">
        <label for="name">Name (required)</label>
        <input id="name" type="text" name="name" placeholder="Enter name" value="{{ old('name') }}" required autofocus>
        @if ($errors->has('name'))
          <span class="error">
              {{ $errors->first('name') }}
          </span>
        @endif
        <label for="username">Username (required)</label>
        <input id="username" type="text" name="username" placeholder="Enter username" required autofocus>
        @if ($errors->has('username'))
          <span class="error">
              {{ $errors->first('username') }}
          </span>
        @endif
          <label for="email">E-mail (required)</label>
          <input id="email" type="email" name="email" placeholder="Enter Email" value="{{ old('email') }}" required autofocus>
          @if ($errors->has('email'))
              <span class="error">
              {{ $errors->first('email') }}
              </span>
          @endif
          <label for="password">Password (required)</label>
          <input id="password" type="password" name="password" placeholder="Enter Password" required autofocus>
          <!--
          <div class="password-toggle">
              <i class="fas fa-eye-slash" id="togglePassword"></i>
          </div>
          -->

          @if ($errors->has('password'))
              <span class="error">
                  {{ $errors->first('password') }}
              </span>
          @endif
          <label for="password-confirm">Confirm Password</label>
          <input id="password-confirm"  placeholder="Confirm your password" type="password" name="password_confirmation" required>

          <button type="submit" class="auth_submit">
            Register
          </button>
          <a class="button button-outline" href="{{ route('login') }}">Login</a>
      </div>
  </form>
  <div class="colimgcont">
      <h2 class="title_guest">Welcome to ProPlanner!</h2>
      <img src='/images/mockup.png' alt="Website Mockup" class="mockup">
      <h3 class="subtitle">Sign up to start your journey with us and turn project planning into an easy task! </h3>
  </div>
</main>
@endsection