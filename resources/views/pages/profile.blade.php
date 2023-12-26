@extends('layouts.app')

@section('content')

<div class="profileDiv">  
    @if(!($user->is_admin))
    <div class="breadcrumb container">
        <a class="breadcrumb-item" href="/homepage">
        <i class="fas fa-home"></i> Home</a>
        <span class="breadcrumb-item active">Profile Area</span>
    </div>
    @endif

        <div class="userprofileSetUp">
        <div class="textSpace">
            <div class="userprofileInfo">
            @if(auth()->id() === $user->user_id)
                <h2>Your Profile</h2>
            @else
                <h2>Colleague Profile</h2>
            @endif
            <hr class="userPageHR">
            <h1>{{ $user->name }}</h1>
            @if(!auth()->user()->is_admin && auth()->id() == $user->user_id)
            <form action="{{ route('deleteUser') }}" method="post" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                @csrf
                @method('POST')
                <button type="submit" id="deleteAccountButton">Delete Account</button>
            </form>
             @endif
            </div>
            <div class="form-group">
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
            <div class="userprofileInfo">
                <div class="divIconUserProfileP">
                    <p class="userEmail"><i class="fas fa-envelope iconUserProfile "></i> {{ $user->email }}</p>
                    <p class="username"><i class="fa-solid fa-at iconUserProfile"></i> {{ $user->username }}</p>
                    <p class="company"><i class="fa-solid fa-briefcase iconUserProfile"></i>
                        @foreach($user->companies as $company)
                            {{ $company->name }}
                            @if(!$loop->last)
                                {{ ',' }}
                            @endif
                        @endforeach
                    </p>
                </div>
            </div>
            @if(auth()->id() === $user->user_id)
                <div class="textSpaceButtons">
                <a class="profileButton" href="{{ url('editprofile') }}" id="editProfileButtonText">Edit Profile </a>
                @if(Auth::check() && auth()->user()->is_admin === FALSE)
                    <a class="profileButton" href="{{ url('projects') }}" id="editProfileButtonText">My projects</a>
                    <a class="profileButton" href="{{ url('tasks') }}" id="editProfileButtonText">My tasks </a>
                    <a class="profileButton" href="{{ url('favorites') }}" id="editProfileButtonText"><i class="fas fa-heart"></i> My Favorites </a>
                    <a class="profileButton" href="{{ url('archived') }}" id="editProfileButtonText"><i class="fa fa-folder"></i> Archived</a>
                @else
                    <a class="profileButton" href="{{ url('admin') }}" id="editProfileButtonText">Admin Dashboard </a>
                @endif
                </div>
            @endif
        </div>  
        <div class="photoSpace">
            <div id="profilePhoto">
                <div id="containerEditPhoto" >
                    <div class="profilePhotoCropper">
                        @if(empty($user->profile_image))
                            <img src = "/images/profiles/avatar.png" class = "roundPhoto" id = "tempProfilePhoto" alt="user-profile-image">
                        @else
                            <img src ="{{$user->profile_image}}" class = "roundPhoto" id = "tempProfilePhoto" alt="user-profile-image"> 
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
