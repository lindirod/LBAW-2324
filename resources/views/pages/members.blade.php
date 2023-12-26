@extends('layouts.app')

@section('title', 'Members')

@section('content')
<div class="breadcrumb container">
    <a class="breadcrumb-item" href="{{ route('projects.show', ['proj_id' => $project->proj_id]) }}">
        {{$project->name}}</a>
    <span class="breadcrumb-item active">Project Members</span>
</div>
<h1 id="projects">Project Members of {{$project->name}} </h1>
<main class="tab">
                <section class="sidebar">
                    <h3>Filters</h3>
                    <label for="memberFilter">Name:</label>
                    <input type="text" id="memberFilter">
                </section>

                
                <section class="table-container">
                    <table id="filter">
                        <th>Name</th>
                    </tr>
                    <div>
                        @foreach($members as $member)  
                        @include('partials.members-list')
                        @endforeach 
                    </div>
                </table>
            </section>    
            
            @if($project->coord_id === auth()->id())
            <section class="sidebar">
                @if(count($project->member) < count($allusers))
                    @include('partials.add-member')
                    @endif
                </section>
                <br>
                @if(count($project->member) > 1)
                    <section class="sidebar">
                        @include('partials.remove-member')
                    </section>
                @endif
            @endif
        </main>

@endsection




