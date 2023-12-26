<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\ProjectNotification;
use App\Models\AssignmentNotification;
use App\Models\CommentNotification;

class NotificationController extends Controller
{
    public function storeProjectNotification($projectId, $content)
    {
        $notification = Notification::create([
            'date' => now(),
            'content' => $content,
        ]);

        ProjectNotification::create([
            'proj_id' => $projectId,
            'notif_id' => $notification->notif_id,
        ]);

        // Mark the notification as unread in the session
    session()->push('unread_notifications', $notification->notif_id);

    // Set a session variable for new notifications
    session(['new_notifications' => true]);

        return response()->json(['message' => 'Notification stored successfully']);
    }

    public function storeAssignmentNotification($taskId, $content)
{
    $notification = Notification::create([
        'date' => now(),
        'content' => $content,
    ]);

    AssignmentNotification::create([
        'task_id' => $taskId,
        'notif_id' => $notification->notif_id,
    ]);

    // Mark the notification as unread in the session
    session()->push('unread_notifications', $notification->notif_id);

    // Set a session variable for new notifications
    session(['new_notifications' => true]);

    return response()->json(['message' => 'Assignment notification stored successfully']);
}

    public function markAsRead(Request $request)
    {
        // Check if the authenticated user is an admin or the same user
            // Get the array of unread notifications from the session
            $unreadNotifications = session('unread_notifications', []);

            // Get the notifications that need to be marked as read
            $notificationsToMarkAsRead = Notification::whereIn('notif_id', $unreadNotifications)->get();

            // Mark notifications as read for the specified user in the session
            foreach ($notificationsToMarkAsRead as $notification) {
                $unreadNotifications = array_diff($unreadNotifications, [$notification->notif_id]);
            }
            session(['unread_notifications' => $unreadNotifications]);
            session()->flash('success', 'All notifications were successfully marked as read');
            return response()->json(['message' => 'All notifications marked as read']);
    }

   
    public function getNotificationsView()
    {
        $notifications = Notification::with('projectNotifications.project', 'assignmentNotifications.task', 'commentNotifications')->get();
    
        // Clear the session variable for new notifications
        session(['new_notifications' => false]);
    
        return view('pages.notifications', compact('notifications'));
    }
    
    
}
