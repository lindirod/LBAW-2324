<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

use Illuminate\Support\Facades\Auth;

class ProjectPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if a given project can be shown to a user.
     */
    public function show(User $user, Project $project): bool
    {
        // Only a project owner can see a project.
        return $user->id === $project->user_id;
    }

    /**
     * Determine if all projects can be listed by a user.
     */
    public function list(User $user): bool
    {
        // Any (authenticated) user can list its own projects.
        return Auth::check();
    }
    public function authUser(User $user): bool
    {
        // Any (authenticated) user can list its own projects.
        return Auth::check();
    }


    /**
     * Determine if a project can be created by a user.
     */
    public function create(User $user): bool
    {
        // Any user can create a new project.
        return Auth::check();
    }

    public function addMember(User $user, Project $project): bool
    {
           return auth()->id() === $project->coord_id;
    }


    public function coordinator(User $user, Project $project)
    {
        return $user->user_id === $project->coord_id;
    }

    /**
     * Determine if a project can be deleted by a user.
     */
    public function delete(User $user, Project $project): bool
    {
      // Only a project owner can delete it.
      return $user->id === $project->user_id;
    }
}
