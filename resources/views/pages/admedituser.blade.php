@extends('layouts.app')

@section('content')
<div class="editprofileDiv">
    <div class="userprofileEdition">
        <div class="textSpace">
            <div class="divIconUserProfileP">
                <h2>Edit Profile</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="/admin/{{ $user->user_id }}/admedituser" id="editProfileForm" onsubmit="return validatePassword()">
                    @csrf

                    
                    <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                            </div>
                        </div>

			<p>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>
                        
                    <p>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            {{ __('Update Profile') }}
                        </button>

                        <a href="javascript:void(0);" class="btn btn-secondary btn-lg" id="cancelButton" onclick="discardChanges()">
                        {{ __('Cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    

    function discardChanges() {
    var confirmCancel = confirm('Are you sure you want to cancel? All changes will be discarded.');

    if (confirmCancel) {
        window.location.href = "{{ route('admin') }}";
    }
}

</script>
@endsection



