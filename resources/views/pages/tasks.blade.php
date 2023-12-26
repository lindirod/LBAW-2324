@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
<div class="breadcrumb container">
        <a class="breadcrumb-item" href="/homepage">
        <i class="fas fa-home"></i> Home</a>
        <a class="breadcrumb-item" href="profile">
            Profile Area</a>
        <span class="breadcrumb-item active">My Tasks</span>
</div>
<h1 id="projects">Your Tasks</h1>
<main class="tab">
                <section class="sidebar">
                    <h3>Filters</h3>
                    <label for="nameFilter">Name:</label>
                    <input type="text" id="nameFilter">
                    <br>
                    <label for="dateFilter">Due date:</label>
                    <input type="text" id="dateFilter">
                    <br>
                    <label for="statusFilter">Status:</label>
                    <input type="text" id="statusFilter">
                    <br>
                    <label for="priorityFilter">Priority:</label>
                    <input type="text" id="priorityFilter">
                    <br>
                    <label for="projectFilter">Project:</label>
                    <input type="text" id="projectFilter">
                </section>
                
            <section class="table-container">
                <table id="filter">
                        <th>Name</th>
                        <th>Due date</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Project</th>
                        </tr>
                            @foreach($tasks as $task)  
                                @include('partials.task-list')
                            @endforeach
                </table>
            </section>    
        </main>

@endsection




