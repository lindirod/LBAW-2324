<form id="edit-form" action="/tasks/{{ $task->task_id }}/edit" method="post">
    @csrf
    @method('PUT')
    <img id="close-edit-form" src="/images/close.png" alt="close-edit">
    <div id="edit-form-header" style="text-align: center;">
        <h2>Edit task</h2>
    </div>
    <div class="fields-task">
        <div id="edit-name-selection">
        <label for="edit-task-name">Name (required)</label>
        <input id="edit-task-name" type="text" name="name" placeholder="Task Name" required>
        </div>
        <div id="edit-task-date">
            <label for="edit-task-date-input">Due date (required)</label>
            <input name="due_date" type="date" id="edit-task-date-input" max="{{$project->due_date}}" value="due_date" required>
            <i title="Make sure to choose a date later than today, to create the task with success" class="fa-solid fa-circle-info"></i>
        </div>
        <div id="edit-member-selection">
            <div id="edit-member-selection-option">
                <label for="new_member">Assign to</label>
                <select name="new_member" class="edit-member-option" data-id="{{$project->member}}">
                    @foreach($project->member as $member)
                        <option value="{{ $member->user_id }}">{{$member->name}}</option>
                    @endforeach 
                </select>
            </div>
        </div>
        <div id="edit-status">
            <label for="status">Update status</label>
            <select id="status" name="status" class="status">
                <option value="To-do" {{ $task->status == 'To-do' ? 'selected' : '' }}>To-do</option>
                <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        <button id="editTaskButton" class="button">Submit changes</button>
    </div>
    
</form>