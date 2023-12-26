@if (($user->user_id === $task->project->coord_id) && $task->status !== 'Completed') 
    <form method="POST" action="{{ route('tasks.assignMember', ['id' => $task->task_id]) }}">
        {{ csrf_field() }}
        <label for="member">Select new member:</label>
        <select name="member" id="member">
            @foreach ($task->project->member as $member)
                <option value="{{ $member->user_id }}">{{ $member->name }}</option>
            @endforeach 
        </select>
        <button type="submit" class="button-assign" role="button" id="button">Assign to member</button>
    </form>
@endif