@extends('layouts.app')

@section('content')
    <div class="searchDiv">
        <div class="searchResults">
            <div class="textSpace">
                <div class="searchResultsInfo">
                    <h2>Search Results</h2>

                    <div class="card-body">
                        <h3>Filters</h3>
                        <!-- Search Form -->
                        <form action="{{ route('search') }}" method="get" id="searchForm">
                            @csrf
                            <label for="sort_by_user">Sort Users By:</label>
                            <select name="sort_by_user" id="sort_by_user">
                                <option value="default">Default</option>
                                <option value="name_user">Name (Alphabetically)</option>
                            </select>

                            <label for="priority_filter">Task Priority:</label>
                            <select name="priority_filter" id="priority_filter">
                                <option value="">All</option>
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>

                            <label for="status_filter">Task Status:</label>
                            <select name="status_filter" id="status_filter">
                                <option value="">All</option>
                                <option value="To-Do">To-Do</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>

                            <label for="sort_by_task">Sort Tasks By:</label>
                            <select name="sort_by_task" id="sort_by_task">
                                <option value="default">Default</option>
                                <option value="due_date_task">Due Date (Ascending)</option>
                                <option value="name_task">Name (Alphabetically)</option>
                            </select>

                            <label for="sort_by_project">Sort Projects By:</label>
                            <select name="sort_by_project" id="sort_by_project">
                                <option value="default">Default</option>
                                <option value="due_date_project">Due Date (Ascending)</option>
                                <option value="name_project">Name (Alphabetically)</option>
                            </select>
                        </form>

                        <!-- Display Users -->
                        @if(isset($results['users']) && !$results['users']->isEmpty())
                            <h3>Users:</h3>
                            <ul id="usersList">
                                @foreach($results['users'] as $user)
                                    @if(auth()->user()->is_admin) <!-- Admin can see all users and himself except other admins -->
                                        @if(!$user->is_admin ) 
                                            <li data-name="{{ $user->name }}">
                                                <a href="{{ route('admin.editUser', ['user_id' => $user->user_id]) }}">{{ $user->name }}</a> - {{ $user->email }}
                                            </li>
                                        @elseif($user->user_id == auth()->user()->user_id)
                                            <li data-name="{{ $user->name }}">
                                                <a href="{{ route('profile') }}">{{ $user->name }}</a> - {{ $user->email }}
                                            </li>
                                        @else
                                            <li data-name="{{ $user->name }}">
                                                {{ $user->name }} - {{ $user->email }}
                                            </li>
                                        @endif
                                    @else
                                        @if(!$user->is_admin)
                                            <li data-name="{{ $user->name }}">
                                                @auth
                                                    @if($user->projects->intersect(auth()->user()->projects)->count() > 0)
                                                        <a href="{{ route('memberProfile', ['user_id' => $user->user_id]) }}">{{ $user->name }}</a> - {{ $user->email }}
                                                    @else
                                                        {{ $user->name }} - {{ $user->email }}
                                                    @endif
                                                @else
                                                    {{ $user->name }} - {{ $user->email }}
                                                @endauth
                                            </li>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        @endif

                        <!-- Display Tasks -->
                        <h3>Tasks:</h3>
                        <ul id="filteredTasks">
                            @if(isset($results['tasks']))
                                @foreach($results['tasks'] as $task)
                                    @if(auth()->user()->is_admin)
                                        <li data-priority="{{ $task->priority }}" data-status="{{ $task->status }}" data-due-date="{{ $task->due_date }}" data-name="{{ $task->name }}">
                                            {{ $task->name }} - {{ $task->description }}
                                            | <a href="{{ route('tasks.show', ['task_id' => $task->task_id]) }}">View Task</a>
                                        </li>
                                    @else
                                        @if(optional(auth()->user()->assigned)->contains($task))
                                            @if(empty($priorityFilter) || $task->priority == $priorityFilter)
                                                <li data-priority="{{ $task->priority }}" data-status="{{ $task->status }}" data-due-date="{{ $task->due_date }}" data-name="{{ $task->name }}">
                                                    {{ $task->name }} - {{ $task->description }}
                                                    | <a href="{{ route('tasks.show', ['task_id' => $task->task_id]) }}">View Task</a>
                                                </li>
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                            @else
                                <p>No tasks found.</p>
                            @endif
                        </ul>

                        <!-- Display Projects -->
                        @if(isset($results['projects']) && !$results['projects']->isEmpty())
                            <h3>Projects:</h3>
                            <ul id="projectList">
                                @foreach($results['projects'] as $project)
                                    @if(auth()->user()->is_admin)
                                        <li data-due-date-project="{{ $project->due_date }}" data-name-project="{{ $project->name }}">
                                            {{ $project->name }} - {{ $project->description }}
                                            | <a href="{{ route('projects.show', ['proj_id' => $project->proj_id]) }}">View Project</a>
                                        </li>
                                    @else
                                        @if(auth()->user() && in_array($project->proj_id, auth()->user()->projects->pluck('proj_id')->toArray()))
                                            <li data-due-date-project="{{ $project->due_date }}" data-name-project="{{ $project->name }}">
                                                {{ $project->name }} - {{ $project->description }}
                                                | <a href="{{ route('projects.show', ['proj_id' => $project->proj_id]) }}">View Project</a>
                                            </li>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <p>No projects found.</p>
                        @endif

                        <!-- Display No Results Message -->
                        @if(!isset($results['users']) && !isset($results['tasks']) && !isset($results['projects']))
                            <p>No results found.</p>
                        @endif

                        <!-- Return to Profile Button -->
                        <a href="{{ route('profile') }}" class="btn btn-primary">Return to Profile</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/sort_users.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/task_priority.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/task_status.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/sort_tasks.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/sort_projects.js') }}"></script>
@endsection
