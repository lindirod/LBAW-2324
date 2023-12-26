@extends('layouts.app')

@section('content')
<div class="breadcrumb container">
    <a class="breadcrumb-item" href="{{ route('projects.show', ['proj_id' => $project->proj_id]) }}">
        {{ $project->name }}
    </a>
    <span class="breadcrumb-item active">{{ $task->name }}</span>
</div>
    <section data-id="{{ $task->task_id }}" id="editTaskSection" class="hidden">
        @include('partials.edit-task') <!-- Include the partial edit-task form -->
    </section>
<div id="opaque"></div>
<div id="task-background">
    <h1 class="details"> Task detail</h1>
    <main class="all">
        <section class="box-task">
            <div class="content">
                <h1 class="title">{{ $task->name }}</h1>
                <div class="try">
                    <p class="date">{{ $task->due_date }}</p>
                    <p class="task-assigned"> Assigned to:
                        @if ($task->assignedMember)
                            {{ $task->assignedMember->name }}
                        @else
                            No assigned member
                        @endif
                    </p>
                </div>
            </div>
            <p class="description">{{ $task->description }}</p>
            <div class="end">
                <p class="ticket-priority">
                    @if ($task->priority === 'High')
                        <span class="high">{{ $task->priority }}</span>
                    @elseif ($task->priority === 'Medium')
                        <span class="medium">{{ $task->priority }}</span>
                    @elseif ($task->priority === 'Low')
                        <span class="low">{{ $task->priority }}</span>
                    @endif
                </p>
                <p class="task-status">{{ $task->status }}</p>
            </div>

            <div id="task-comments-container">
                <h2 class="comments_card">COMMENTS</h2>
                @foreach($task->comments as $comment)
                    <div class="comment_header">
                        @foreach($project->member as $member)
                            @if($comment->author && $comment->author->user_id == $member->user_id)
                                @if($comment->author->exists)
                                @if(empty($member->profile_image))
                                        <img src = "/images/profiles/avatar.png" class = "roundPhoto" id = "tempProfilePhoto" alt="user-profile-image">
                                    @else
                                        <img src ="{{$member->profile_image}}" class = "roundPhoto" id = "tempProfilePhoto" alt="user-profile-image"> 
                                    @endif
                                @endif
                            @endif
                        @endforeach

                        <h4 class="author_name">
                            @if ($comment->author && $comment->author->exists)
                                <a href="{{ route('memberProfile', ['user_id' => $comment->author->user_id]) }}">
                                    {{ $comment->author->name }}
                                </a>
                            @else
                                Deleted User
                            @endif
                        </h4>
                        <p>{{ $comment->content }}</p>
                    </div>

                    <div class="comment_footer">
                        <p>{{ $comment->date }}</p>
                    </div>
                @endforeach

                @if(!($user->isArchived($project)))
                    <form id="add-task-page-comment" class="task-page-comment" method="post" data-id="{{ $task->task_id }}">
                        @csrf
                        @method('PUT')
                        <div>
                            <h5>{{ Auth::user()->name }}</h5>
                            <textarea id="add-task-comment-content-input" placeholder="Write your comment here." name="content"></textarea>
                            <h4 id="add-task-comment-button" class="comment-button">Comment</h4>
                        </div>
                    </form>
                @endif
            </div>

        </section>

        <div class="buttons-task">
            @if($user->user_id === $task->assignedMember->user_id)
            <button id="openEditFormButton" class="button"><h3>Edit Task</h3></button>
                <form method="post" action="{{ route('tasks.delete', ['id' => $task->task_id]) }}">
                    @csrf
                    @method('delete')
                    <button id="deleteTaskButton" type="submit"><h3> Delete Task</h3></button>
                </form>
            @endif
        </div>
    </main>
</div>
@endsection
