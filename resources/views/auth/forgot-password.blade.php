@extends('layouts.app')

@section('content')
<div class="forgot-page">
    <form method="POST" action="{{ url('/forgot-password') }}">
        @csrf
        <h2>Reset your password</h2>
        <p id="forgot-password">We'll send you an email to the one you provided, with a link to reset your password.</p>
        @if (\Session::has('status'))
            <span class="alert-success">
            {!! \Session::get('status') !!}
            </span>
        @endif
        <label for="email">Email:</label>
        <input id="email" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
        <button class = "sendButton" type="submit">
            Send Recovery Email
        </button>    
    </form>
</div>
@endsection
