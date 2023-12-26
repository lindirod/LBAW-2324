<div class ="popup-task" id ="popup-task">
    <form method="POST" action="{{ route('tasks.create', ['proj_id' => $project->proj_id]) }}" class="popup-content-task">
    @method('PUT')
    {{ csrf_field() }}


    <img src="../images/close.png" alt ="Close" class="close-popup">
                <h2 class="write">Create a new task</h2><br>
                <div class="name-task">
                    <label for="title"><b>Name (required)</b></label>
                    <input type="text" id="title" name="name" placeholder="Enter name for the task" required>
                </div>
                <div class="two-column-task">
                    <div class="two-column-members">
                        <label for="member">Assign to</label>
                            <select id="member" name="member">
                                @foreach($project->member as $member)
                                    <option value="{{ $member->user_id }}">{{$member->name}}</option>
                                @endforeach 
                            </select>
                    </div>
                    <div class="two-column-members">
                        <label for="date" >Due date (required)</label>
                        <input type="date" id="date" name="due_date" value="due_date"  max="{{ $project->due_date }}" required>
                        <i title="Make sure to choose a date later than today, to create the task with success" class="fa-solid fa-circle-info"></i>
                    </div>
                    <div class="two-column-priority" class = "priority">
                        <p>Priorities</p>
                        <div>
                            <input type="radio" id="high" name="priority" value="High">
                            <label for="high"> High</label>
                        </div>
                        <div>
                            <input type="radio" id="medium" name="priority" value="Medium">
                            <label for="medium">Medium</label>
                        </div>
                        <div>
                            <input type="radio" id="low" name="priority" value="Low" checked>
                            <label for="low">Low</label>
                        </div>
                    </div> 
                </div>
                <div class="description-task">
                    <label for="description"><b>Description (required)</b></label>
                    <textarea class = "description" id = "description" name = "description" required></textarea>
                </div>
                <button type="submit" class ="button_sub-task"><i class="far fa-paper-plane-top"></i> Create</button>
    </form>
</div>