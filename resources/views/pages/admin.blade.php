@extends('layouts.app')

@section('title', 'AdminPage')

@section('content')
<div class="breadcrumb container">
        
        <span class="breadcrumb-item active">Admin Dashboard</span>
</div>
<div id="allusers-area">
    <div id="all-users">

        <h2>Select a User</h2>
        <a href="{{ route('createuser') }}" class="btn btn-primary">Create a new User</a>

        @if ($allusers && count($allusers) > 0)
            <div class="user-select">
                @foreach($allusers as $user)
                    @if (!$user->is_admin)
                        <a href="admin/{{$user->user_id}}">
                            <div class="user-icon-big" data-id="{{ $user->user_id }}">
                                <h5 class="noselect">{{ $user->name }}</h5>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        @else
            <h2>No Users Found.</h2>
        @endif

        <!-- Return to Profile Button -->
        <a href="{{ route('profile') }}" class="btn btn-primary">Return to Profile</a>

    </div>
</div>

@endsection
