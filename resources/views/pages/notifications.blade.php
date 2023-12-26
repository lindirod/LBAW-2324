@extends('layouts.app')

@section('content')
         <div class="container" style="grid-template-rows: 8em auto;">
         @if(session('success'))
        <div class="alert alert-success my-custom-alert">
        {{ session('success') }}
         </div>
         @endif
        <h3>All Notifications</h3>
        <ul id="allNotifications">
            @forelse($notifications as $notification)
                @foreach($notification->projectNotifications as $projectNotification)
                    <li>
                        <strong>{{ $projectNotification->project->name }} - {{ $notification->date }}</strong> - 
                        {{ $notification->content }}
                    </li>
                @endforeach

                @foreach($notification->assignmentNotifications as $assignmentNotification)
                    <li>
                        <strong>{{ $assignmentNotification->task->name }} - {{ $notification->date }}</strong> -
                        {{ $notification->content }}
                    </li>
                @endforeach
            @empty
                <li>No notifications</li>
            @endforelse
        </ul>
        
        <div class="notifications" style="display: flex;">
            @if (isset($projectNotification))
                <button class="btn btn-primary" onclick="markNotificationAsRead(event)" data-notification-id="{{ $projectNotification->id }}">Mark All Notifications as Read</button>
            @elseif(isset($assignmentNotification))
                <button class="btn btn-primary" onclick="markNotificationAsRead(event)" data-notification-id="{{ $assignmentNotification->id }}">Mark All Notifications as Read</button>
            @endif
            <a href="{{ route('profile') }}" class="btn btn-primary">Return to Profile</a>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/markAsRead.js') }}"></script>
@endsection
