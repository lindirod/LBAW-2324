@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="breadcrumb container">
        <a class="breadcrumb-item" href="/homepage">
        <i class="fas fa-home"></i> Home</a>
        <a class="breadcrumb-item" href="profile">
            Profile Area</a>
        <span class="breadcrumb-item active">Archived Projects</span>
</div>

<h1 id="projects">Archived projects</h1>
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
                @foreach($archived as $arch)
                    @include('partials.arch')
                @endforeach
        </table>
    </section>  
</main>

@endsection