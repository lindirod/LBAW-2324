@extends('layouts.app')

@section('content')
<main class="general_container">
  <form method="POST" action="{{ route('createuser') }}" class="auth_form">
      {{ csrf_field() }}
      <div class="imgcontainer">
          <img src='images/avatar.png' alt="Avatar" class="avatar">
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
        <input id="username" type="text" name="username" placeholder="Enter username" required>
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
          <label for="password">Password</label>
          <input id="password" type="password" name="password" placeholder="Enter Password" required>
          @if ($errors->has('password'))
              <span class="error">
                  {{ $errors->first('password') }}
              </span>
          @endif
          <label for="password-confirm">Confirm Password</label>
          <input id="password-confirm"  placeholder="Confirm your password" type="password" name="password_confirmation" required>

          <button type="submit" class="auth_submit">
            Create User
          </button>
      </div>
  </form>
  <div class="colimgcont">
      <h2 class="subtitle">Insert the details of the new User! </h2>
  </div>
</main>
@endsection
