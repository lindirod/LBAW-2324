<h3>Remove Members</h3>
    <form id="remove_members" method="POST" action="{{ route('projects.removeMember', ['proj_id' => $project->proj_id]) }}" class="remove_members">
        @method('DELETE')
        {{ csrf_field() }}
        @foreach ($project->member as $member)
            @if($project->coord_id != $member->user_id)
                <div class="checkbox-container">
                    <input type="checkbox" name="selectedMembers[]" id="member_{{ $member->user_id }}" value="{{ $member->user_id }}">
                    <label class="checkbox-label" for="member_{{ $member->user_id }}"><span id="member_name">{{ $member->name }}</span></label>
                </div>
            @endif
        @endforeach 
        <button onclick="removeMembers()" class="remove-button" id="save-members">
            <i class="fas fa-trash"></i>
        </button>
    </form>