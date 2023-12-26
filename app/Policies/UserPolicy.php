<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

use Illuminate\Support\Facades\Auth;

class UserPolicy
{
   /**
     * Determine if a user can be deleted by an admin.
     */
    public function delete(User $user): bool
    {
      return $user->is_admin;
    }


    public function list(User $user): bool
    {
        // Any (authenticated) user can list its own projects.
        return Auth::check();
    }

}
