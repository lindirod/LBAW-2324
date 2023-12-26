
<h3>Add members</h3>
@if(session('success'))
    <div class="alert alert-success my-custom-alert">
        {{ session('success') }}
    </div>
@endif
<form id="add_members" method="POST" action="{{ route('projects.members', ['proj_id' => $project->proj_id]) }}" class="add_members">
    {{ csrf_field() }}
    @foreach ($allusers as $user)
        @if(auth()->id() != $user->user_id && !($project->isMember($user->user_id)) && !($user->is_admin))
            <div class="user-checkbox">
                <input type="checkbox" name="user_ids[]" id="user_{{ $user->user_id }}" value="{{ $user->user_id }}">
                <label class="label-add_members" for="user_{{ $user->user_id }}"><span id="member_name">{{ $user->name }}</span></label>
            </div>
        @endif
    @endforeach
    <input type="hidden" name="user_id" value="{{ $user->user_id }}">
    <button type="submit" id="save-members">
        <i class="fa-solid fa-circle-plus"></i>
    </button>
    <p id="addMembers-status"></p>
</form>



