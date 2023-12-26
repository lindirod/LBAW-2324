@extends('layouts.app')

@section('title', 'TasksProjects')

@section('content')
<div class="breadcrumb container">
    <a class="breadcrumb-item" href="{{ route('projects.show', ['proj_id' => $project->proj_id]) }}">
        {{$project->name}}</a>
    <span class="breadcrumb-item active">All tasks</span>
</div>
<h1 id="projects">Tasks of {{ $project->name}}</h1>
<main class="tab">
                <section class="sidebar">
                    <h3>Filters</h3>
                    <label for="tasknameFilter">Name:</label>
                    <input type="text" id="tasknameFilter">
                    <br>
                    <label for="duedateFilter">Due date:</label>
                    <input type="text" id="duedateFilter">
                    <br>
                    <label for="taskstatusFilter">Status:</label>
                    <input type="text" id="taskstatusFilter">
                    <br>
                    <label for="taskpriorityFilter">Priority:</label>
                    <input type="text" id="taskpriorityFilter">
                    <br>
                    <label for="assignedFilter">Assigned member:</label>
                    <input type="text" id="assignedFilter">
                </section>
                
            <section class="table-container">
                <table id="filter">
                        <th>Name</th>
                        <th>Due date</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Assigned Member</th>
                        </tr>
                            @foreach($tasks as $task)  
                                @include('partials.taskproj-list')
                            @endforeach
                </table>
            </section>    
        </main>

@endsection




