@if($project->member->contains(auth()->id()))
    <form method="POST" action="{{ route('projects.leaveProject', ['proj_id' => $project->proj_id]) }}">
        {{ csrf_field() }}
        <button type="submit" class="save-button">Leave Project</button>
    </form>
@endif
