@if($project->coord_id === auth()->id())
    @if(count($project->member) > 1)
        <form method="POST" action="{{ route('projects.changeCoordinator', ['proj_id' => $project->proj_id]) }}">
            {{ csrf_field() }}
            <label for="newCoordinator">Select new coordinator:</label>
            <select name="newCoordinator" id="newCoordinator" style="border-radius: 5px; font-family: 'Red Hat Display', sans-serif;">
                @foreach ($project->member as $member)
                    @if($project->coord_id != $member->user_id)
                        <option style="font-family: 'Red Hat Display', sans-serif;" value="{{ $member->user_id }}">{{ $member->name }}</option>
                    @endif
                @endforeach 
            </select>
            <button type="submit" class="change-coord-button">
                Change coordinator
            </button>
        </form>
    @endif
@endif