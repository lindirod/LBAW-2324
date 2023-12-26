<script type="text/javascript" src="{{ url('js/popup.js') }}" defer></script>

<div id="side-menu">
    <div id="side-menu-main-options">
        <div class="side-menu-divider"></div>
        @if(!($user->isArchived($project)))
        <a id="slide-right-project-overview-link" class="side-menu-item" >
            @if(Auth::check() && auth()->user()->is_admin === FALSE)
            <div>
                <h2> <i class="fa-solid fa-plus"></i> New task</h2>
            </div>
            @endif
        </a>
        @endif
        <div class="side-menu-divider"></div>
        <a href="{{ route('project.showTasks', ['proj_id' => $project->proj_id]) }}" id="sidemenu-tasks" class="side-menu-item" >
            <div>
                <h2><i class="fa-solid fa-list-check"></i> List tasks</h2>
            </div>
        </a>
        <div class="side-menu-divider"></div>
        <a href="{{ route('project.showMembers', ['proj_id' => $project->proj_id]) }}" id="sidemenu-members" class="side-menu-item">
            <div>
                <h2><i class="fa-solid fa-users"></i> Project Members</h2>
            </div>
        </a>
            @foreach($projects as $project)
                <div class="side-menu-divider"></div>
                <a href="{{ $project->proj_id }}" id="sidemenu-projects" class="side-menu-item" data-title="{{ $project->name }}" data-id="{{ $project->proj_id }}" >
                    <div>
                        <h2> {{ $project->name }}</h2>
                    </div>
                </a>
            @endforeach
            <div class="side-menu-divider"></div>
            <a id="slidemenu-new-project" class="side-menu-item" >
            	@if(Auth::check() && auth()->user()->is_admin === FALSE)
                <div>
                    <h2><i class="fa-solid fa-plus"></i> Create Project</h2>
                </div>
                @endif
            </a>
            <div class="side-menu-divider"></div>
            <a class="side-menu-item">
                    @if(auth()->id() == $project->coordinator->user_id)
                        <button type="submit" id="openUpdateFormButton" class="button"><h3><i class="fa-solid fa-pen-to-square"></i> Edit Project</h3></button>
                    @endif
                </a>
    </div>
</div>


