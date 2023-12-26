@extends('layouts.app')

@section('content')

<header>
@if(session('success'))
    <div class="alert alert-success my-custom-alert">
        {{ session('success') }}
    </div>
@endif
    <h1>ProPlanner</h1>
    <h3>ProPlanner: A Centralized Solution that unifies your teams for seamless planning, tracking, and collaboration on any project</h3>
    <div id="signup">
        @if(!Auth::check())
        <a href="{{ url('/register') }}">Register</a>
        <a href="{{ url('/login') }}">Login</a>
        @endif
    </div>
</header>
<nav id="menu">
        <h2>
            <img src="images/FAQ.png" alt="Frequently Asked Questions image">
            <a href="{{ url('/faq') }}"><i class="fa-solid fa-arrow-right"></i></a>
        </h2>
        <h2>
            <img src="images/About.png" alt="About Us Image">
            <a href="{{ url('/about_us') }}"><i class="fa-solid fa-arrow-right"></i></a>
        </h2>
        <h2>
            <img src="images/Contacts.png" alt="Contacts Image">
            <a href="{{ url('/contact-us') }}"><i class="fa-solid fa-arrow-right"></i></a>
        </h2>
</nav> 
@push('styles')
<link href="{{ url('css/homepage.css') }}" rel="stylesheet">
@endpush

@endsection