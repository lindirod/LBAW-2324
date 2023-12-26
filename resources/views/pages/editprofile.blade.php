@extends('layouts.app')

@section('content')
<div class="breadcrumb container">
    @if(!($user->is_admin))
        <a class="breadcrumb-item" href="/homepage">
        <i class="fas fa-home"></i> Home</a>
    @endif
        <a class="breadcrumb-item" href="profile">
            Profile Area</a>
        <span class="breadcrumb-item active">Edit Profile</span>
</div>
<div class="editprofileDiv">
    <div class="userprofileEdition">
        <div class="textSpace">
            <div class="divIconUserProfileP">
                <h2>Edit Profile</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('editProfile') }}" id="editProfileForm" onsubmit="return validatePassword()" enctype="multipart/form-data">
                    @csrf
                <div class = "col">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }} (required)</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }} (required)</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>
                    
                    
                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }} (required)</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" minlength="4">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            {{ __('Update Profile') }}
                        </button>
    
                        <a href="javascript:void(0);" class="btn btn-secondary btn-lg" id="cancelButton" onclick="discardChanges()">
                        {{ __('Cancel') }}
                        </a>
                    </div>
                </div>
                <div class = "col">
                    <div id = "profilePhoto">
                            <p> Profile Picture </p>
                            <div id = "containerEditPhoto">
                                <div class = "profilePhotoCropper">
                                    @if(empty($user->profile_image))
                                        <img src = "/images/profiles/avatar.png" class = "roundPhoto" id = "tempProfilePhoto" alt="user-profile-pic">
                                    @else
                                        <img src ="{{$user->profile_image}}" class = "roundPhoto" id = "tempProfilePhoto" alt="user-profile-pic"> 
                                    @endif
                                </div>
                                <div class = "uploadImage">
                                    <input type="file"  accept="image/*" name="profile_image" id="profile_image"  onchange="loadFile(event)" style="display: none;">
                                    <div class = "editImageButton">
                                        <label for="profile_image" class= "deleteImageText" id= "uploadImageButton"> Edit</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class= "deleteImageText" id="deleteImageButtonID"  >
                            Delete Image
                        </button>
                    </div>

                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function validatePassword() {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('password_confirmation').value;

        if (password !== confirmPassword) {
            alert('Password and Confirm Password do not match, try again.');
            return false;
        }

        return true;
    }

    function discardChanges() {
    var confirmCancel = confirm('Are you sure you want to cancel? All changes will be discarded.');

    if (confirmCancel) {
        window.location.href = "{{ route('profile') }}";
    }
}

</script>
@endsection



