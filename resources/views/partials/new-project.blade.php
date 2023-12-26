<div class ="popup-project" id ="popup-project">
    <form method="POST" action="{{ route('projects.create') }}" class="popup-content-project">
    @method('PUT')
    {{ csrf_field() }}


    <img src="../images/close.png" alt ="Close" class="close-popup-project">
                <h2 class="write">Create a new project</h2><br>
                <div class="name-project">
                    <label for="title"><b>Name (required)</b></label>
                    <input type="text" id="title" name="name" placeholder="Enter name for the project" required>
                </div>
                <div class="two-column-project">
                    <div class="two-column-pmembers">
                        <label for="members">Coordinator</label>
                        <select name = "members" id="members">
                            @foreach($allusers as $user)
                                @if(!($user->is_admin))
                                    <option value="{{$user->user_id}}">{{$user->name}}</option>
                                @endif
                            @endforeach 
                        </select>
                    </div> 
                    <div class="two-column-pmembers">
                        <label for="companies">Company</label>
                        <select name = "companies" id="companies">
                            @foreach($companies as $company)
                                <option value="{{$company->comp_id}}">{{$company->name}}</option>
                            @endforeach 
                        </select>
                    </div>
                    <div class="two-column-members">
                        <label for="date">Due date (required)</label>
                        <input type="date" id="date" name="due_date" value="due_date" min="{{ $project->due_date }}" required>
                    </div>
                </div>
                <div class="description-project">
                    <label for="description"><b>Description (required)</b></label>
                    <textarea class = "description" id = "description" name = "description" required></textarea>
                </div>
                <button type="submit" class ="button_sub-project"><i class="fas fa-paper-plane-top"></i> Create</button>
    </form>
</div>