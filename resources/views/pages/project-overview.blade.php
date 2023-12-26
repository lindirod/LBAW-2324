@extends('layouts.app')

@section('content')


<div id="opaque-proj"></div>

@if(session('success'))
    <div class="alert alert-success my-custom-alert">
        {{ session('success') }}
    </div>
@endif
@if($errors->any())
  <div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
     </ul>
   </div>
@endif

<div id="project-background">
    @include('partials.sidemenu')
    
    @if(!($user->isArchived($project)))
        @include('partials.new-task')
    @endif
    @include('partials.new-project')
    
    <div id="project-overview-top-bar" class="project-overview" data-id="{{$project->proj_id}}">
        <div id="project-overview-top-bar-left">
            <h2 id="project-title">{{$project->name}}</h2>
            <div>
                @if(count($project->member)>3)
                    @for($i = 0; $i <= 3; $i++)
                        <a href="{{ route('memberProfile', ['user_id' => $project->member[$i]->user_id]) }}"><img data-id="{{$project->member[$i]->user_id}}" title="{{$project->member[$i]->name}}" alt="{{$project->member[$i]->name}}" class="profile-image-link" src = "{{$project->member[$i]->profile_image}}"></a>
                    @endfor
                @if((count($project->member)-4)>9)
                    <div class="extra-member-count-div"><h2>9+</h2></div>
                @endif
                @else
                    @foreach($project->member as $member)
                            <a href="{{ route('memberProfile', ['user_id' => $member->user_id]) }}"><img data-id="{{$member->user_id}}" title="{{$member->name}}" alt="{{$member->name}}" class="profile-image-link" src = "{{$member->profile_image}}"></a>
                @endforeach
                @endif
            </div>
            
            
            
        </div>
        <div id="project-overview-top-bar-right">
            
            @if(!($user->isArchived($project)))
                <button title="favorite" id="add-fav-butt" onclick="setUpAddToFavorites()" class="{{$user->isFavorite($project) ? 'project-fav-button fa fa-heart' : 'project-fav-button fa fa-heart-o'}}" ></button>
            @endif
                @if(auth()->id() === $project->coord_id)
                <button title="archive" id="add-arch-butt" onclick="setUpArchive()" class="{{$user->isArchived($project) ? 'project-arch-button fa fa-folder' : 'project-arch-button fa fa-folder-open'}}" ></button>
                @endif
                <div class="project_coord">
                    <p>Project Coordinator:  {{$project->coordinator->name}} </p>
                </div>
            @if(!($user->isArchived($project)))
                @include('partials.change-coord')
            @endif
                @include('partials.leave-proj')

        </div>
                    
    </div>      
            
    <div class="box">
        <h2>Task Status</h2>
        <div class="row-overview">
            <div class="property open">
                <h3>To Do</h3>
                @foreach($tasks as $task)
                @if ($task->status === 'To-do')
                @include('partials.task')
                @endif
                @endforeach
            </div>
            <div class="divider"></div>
            <div class="property assigned">
                <h3>In Progress</h3>
                @foreach($tasks as $task)
                @if ($task->status === 'In Progress')
                @include('partials.task')
                @endif
                @endforeach
            </div>
            <div class="divider"></div>
            <div class="property closed">
                <h3>Completed</h3>
                @foreach($tasks as $task)
                @if ($task->status === 'Completed')
                @include('partials.task')
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

    <section data-id="{{$project->proj_id}}" id="editProjSection" class="hidden">
        @include('partials.edit-project') 
    </section>
@endsection
