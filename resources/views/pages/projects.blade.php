@extends('layouts.app')

@section('title', 'Projects')

@section('content')

@include('partials.new-project-profile')

<div class="breadcrumb container">
        <a class="breadcrumb-item" href="/homepage">
        <i class="fas fa-home"></i> Home</a>
        <a class="breadcrumb-item" href="profile">
            Profile Area</a>
        <span class="breadcrumb-item active">My Projects</span>
</div>

<h1 id="projects">Your Projects</h1>
<main class="tab">
    <section class="sidebar">
        <h3>Filters</h3>
        <label for="nameFilter">Name:</label>
        <input type="text" id="nameFilter">
        <br>
        <label for="dateFilter">Due date:</label>
        <input type="text" id="dateFilter">
        <br>
        <label for="companyFilter">Company:</label>
        <input type="text" id="companyFilter">
        <br>
        <label for="coordinatorFilter">Coordinator:</label>
        <input type="text" id="coordinatorFilter">
    </section>

    
    <section class="table-container">
        <table id="filter">
            <th>Name</th>
            <th>Due date</th>
            <th>Company</th>
            <th>Coordinator</th>
        </tr>
        @foreach($projects as $project)
            @include('partials.project')
        @endforeach
        </table>
    </section>  

    <div class="sidebar">
        <a id="slidemenu-profile" class="side-projects" >
            <div>
                <h2 style="font-size: large; cursor: pointer;"><i class="fa-solid fa-plus"></i> Create Project</h2>
            </div>
        </a>
    </div>
</main>
@endsection