
<div class ="popup-prof" id ="popup-prof">
    <form method="POST" action="{{ route('projects.create') }}" class="popup-content-prof">
    @method('PUT')
    {{ csrf_field() }}


    <img src="../images/close.png" alt ="Close" class="close-prof">
                <h2 class="write">Create a new project</h2><br>
                <div class="name-prof">
                    <label for="title"><b>Name (required)</b></label>
                    <input type="text" id="title" name="name" placeholder="Enter name for the project" required>
                </div>
                <div class="two-column-prof">
                    <div class="two-column-profile">
                        <label for="members">Project coordinator</label>
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
                            @foreach(Auth::user()->companies as $company)
                                <option value="{{$company->comp_id}}">{{$company->name}}</option>
                            @endforeach 
                        </select>
                    </div>
                    <div class="two-column-date">
                        <label for="date">Due date (required)</label>
                        <input type="date" id="date" name="due_date" value="due_date" required>
                        <i title="Make sure to choose a date later than today, to create the task with success" class="fa-solid fa-circle-info"></i>
                    </div>
                </div>
                <div class="description-prof">
                    <label for="description"><b>Description (required)</b></label>
                    <textarea class = "description" id = "description" name = "description" required></textarea>
                </div>
                <button type="submit" class ="button_sub-prof"><i class="far fa-paper-plane-top"></i> Create</button>
    </form>
</div>