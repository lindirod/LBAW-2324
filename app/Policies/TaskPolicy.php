<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;

use Illuminate\Support\Facades\Auth;

class TaskPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    
    public function show(User $user, Task $task): bool
    {
        // Only a project owner can see a project.
        return $user->id === $task->project->user_id;
    }

    /**
     * Determine if all projects can be listed by a user.
     */
    public function list(User $user): bool
    {
        // Any (authenticated) user can list its own projects.
        return Auth::check();
    }

    /**
     * Determine if a user can create an task.
     */
    public function create(User $user, Task $task): bool
    {
        // User can only create tasks in projects they own.
        return $user->id === $task->project->user_id;
    }
    /**
     * Determine if a user can delete an task.
     */
    public function delete(User $user, Task $task): bool
    {
        // User can only delete tasks in projects they own.
        return $user->id === $task->project->user_id;
    }
}
