<form id="update-form" action="/api/projects/{{ $project->proj_id }}/edit" method="post">
        @csrf
        @method('PUT')
        <img id="close-update-form" src="/images/close.png" alt="close-edit">
        <h2 style="text-align: center;">Edit Project</h2>
        <div id="update-name-selection">
            <label for="update-project-name">Name (required)</label>
            <input id="update-project-name" type="text" name="name" placeholder="Project Name" required>
        </div>

    <div class="fields">
        <div id="update-task-date">
            <label for="update-project-date-input">Due date (required)</label>
            <input name="due_date" type="date" id="update-project-date-input" min="{{$project->due_date}}" value="due_date" required>
        </div>
    </div>
    <div id="update-description">
        <label for="update-project-description-input">New description (required)</label>
        <textarea name="description" id="update-project-description-input" style="border-radius: 5px;" value="description" required></textarea>
    </div>
    <button id="editProjectButton" class="button" type="submit">Submit changes</button>
    
</form>