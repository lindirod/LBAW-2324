<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Task;
use App\Models\User;
use App\Models\Comment;
use App\Models\Project;
use App\Http\Controllers\NotificationController;

use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    protected $notificationController;

    public function __construct(NotificationController $notificationController)
    {
        $this->notificationController = $notificationController;
    }
    /**
     * Creates a new task.
     */
    public function create(Request $request, $proj_id)
    {
        // Create a blank new task.
        $task = new Task();

        $request->validate([
            'due_date' => 'required|date|after:today',
        ]);

        // Set task's project.
        $task->proj_id = $proj_id;

        // Check if the current user is authorized to create this task.
        $this->authorize('create', $task);

        // Set task details.
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->due_date = $request->input('due_date');
        $task->priority = $request->input('priority');
        $task->status = 'To-do';
        $task->user_id = $request->input('member');
    
        // Save the task and return it as JSON.
        $task->save();
        $user = User::find($task->user_id);
        $this->notificationController->storeAssignmentNotification($task->task_id, 'Task created and assigned successfully to a new member: ' . $user->name);
         return redirect()->back();
    }
 
    
    /**
     * Show the task for a given id.
     */
    public function show(string $id): View
    {
        // Get the task.
        $task = Task::findOrFail($id);
        $project = Project::findOrFail($task->proj_id);
        $comments = $task->comments();
        // Check if the current user can see (show) the task.
        $this->authorize('show', $task);  

        $user = Auth::user();

        // Use the pages.task template to display the project.
        return view('pages.task', [
            'task' => $task, 'user'=>$user, 'project' => $project, 'comments' =>$comments,
        ]);
    }  

    
    public function list()
    {
        // Check if the user is logged in.
        if (!Auth::check()) {
            // Not logged in, redirect to login.
            return redirect('/login');
        }

        // The user is logged in.
        $user = User::find(auth()->id()); 
        
        // Get tasks for the user ordered by id.
        $tasks = $user->assigned()->orderBy('task_id')->get();

        $this->authorize('list', Task::class);

        // Use the pages.tasks template to display all tasks.
        return view('pages.tasks', [
            'tasks' => $tasks ,
        ]);
    }
    

    public function edit(Request $request, $task_id)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
    
        $task = Task::find($task_id);
        //$this->authorize('edit', Task::class);
        $oldStatus = $task->status;
    
        $task->name = $request->input('name');
        $task->due_date = $request->input('due_date');
        $task->user_id = $request->input('new_member');
        $task->status = $request->input('status');
    
        $task->save();
    
        if ($oldStatus !== $request->input('status')) {
            $this->notificationController->storeAssignmentNotification($task->task_id, 'Task status successfully updated for the task ' . $task->name);
        } else {
            $user = User::find($task->user_id);
            $this->notificationController->storeAssignmentNotification($task->task_id, 'Task assigned successfully to a new member: ' . $user->name);
        }
    
        return $task;
    }
     

public function delete($id)
{
    
    $task = Task::find($id);

    $this->authorize('delete', $task);

    $project = $task->project;

    $task->delete();

    return redirect()->route('projects.show', ['proj_id' => $project->proj_id]);
}

public function comment(Request $request, $task_id)
{
    if(!Auth::check()) 
    return redirect('/login');
    $task = Task::find($task_id);
    //$this->authorize('update', $task);

    $comment = new Comment();
    $comment->assigned_member = auth()->id();
    $comment->task_id = $task_id;
    $comment->content = $request->input('content');
    $comment->date = date('Y-m-d H:i');
    $comment->save();
    $task->comments()->attach($comment);
    return;
        
}
}

