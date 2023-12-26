@extends('layouts.app')



@section('content')




    <div class="profileDiv">

        <div class="userprofileSetUp">

            <div class="textSpace">

                <div class="userprofileInfo">

                    <h1>{{ $user->name }}</h1>
                    
                    @if($user->is_blocked === TRUE)
		    <h5>This account has been blocked.</h5>
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

                <div class="textSpaceButtons">
		    
		    
		    
		    
                    <form action="{{ route('adm.editprofile', ['user_id' => $user->user_id]) }}" id="editProfileButtonText">
                    	<button type="submit" class="profileButton">EDIT PROFILE 
                    	</button>
                    	</form>
                    	@if($user->is_projcoord === TRUE)
                    	<form action="{{ route('admin.deleteUser', ['user_id' => $user->user_id]) }}" method="POST" onsubmit="return confirm('You can not delete a Project Coordinator. He must first be replaced.');" "id="editProfileButtonText">
			{{ csrf_field() }}
			<button type="submit" class="profileButton">DELETE PROFILE
			</button>
			</form>
                    	@else
                        <form action="{{ route('admin.deleteUser', ['user_id' => $user->user_id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');" "id="editProfileButtonText">
			{{ csrf_field() }}
			<button type="submit" class="profileButton">DELETE PROFILE
			</button>
			</form>
			@endif
			@if($user->is_blocked === FALSE)
			<form method="POST" action="{{ route('admin.blockUser', ['user_id' => $user->user_id]) }} "id="editProfileButtonText">
			{{ csrf_field() }}
			<button type="submit" class="profileButton">BLOCK PROFILE
			</button>
			</form>
                        @endif
                        
                        @if($user->is_blocked === TRUE)
			<form method="POST" action="{{ route('admin.unblockUser', ['user_id' => $user->user_id]) }} "id="editProfileButtonText">
			{{ csrf_field() }}
			<button type="submit" class="profileButton">UNBLOCK PROFILE
			</button>
			</form>
                        @endif

			

                </div>
                
                <a href="{{ route('admin') }}" class="btn btn-primary">Return to Admin Dashboard</a>
		
            </div>

		
        </div>

    </div>

@endsection
