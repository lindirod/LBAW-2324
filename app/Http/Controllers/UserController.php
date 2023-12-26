<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Project;
use App\Models\Company;
use App\Models\Task;
use App\Models\Invitation;
use App\Models\Comment;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\NotificationController;


class UserController extends Controller
{
    protected $notificationController;

    public function __construct(NotificationController $notificationController)
    {
        $this->notificationController = $notificationController;
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);
    }

    
    public function showUserProfile()
    {
        if (Auth::check()) {
            $user = User::find(auth()->id());
            $invitations = $user->invitations;
            return view('pages.profile', ['user' => $user,'invitations' => $invitations]);
        }
    }


    public function showEditProfile()
    {
        if (Auth::check()) {
            $user = User::find(auth()->id());
            return view('pages.editprofile', ['user' => $user]);
        } 
    }

    public function deletePhoto(){
        $user = User::find(auth()->id());
        File::delete($user->profile_image);
        $user->profile_image = '/images/profiles/avatar.png';
        $user->save();
        return $user;
    }

    public function editProfile(Request $request)
   {
    // Validate the incoming request data
    $validator = validator($request->all(), [
        'name' => 'string|max:255',
        'email' => 'string|email|max:255',
        'password' => 'string|min:4|confirmed',
    ]);

    // If validation fails, return the validation errors
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Get the authenticated user
    $user = User::find(auth()->id());

    
    // Update user profile information
    $user->name = $request->input('name', $user->name);
    $user->email = $request->input('email', $user->email);
    
    
    // Update the password if provided
    if ($request->filled('password')) {
        $user->password = Hash::make($request->input('password'));
    }
    
    // Save the updated user profile
    $user->save();
    
    if ($request->file('profile_image')) {
        $file = $request->file('profile_image');
        $fileNameExtension = "." . $file->getClientOriginalExtension();
        $user->profile_image = '/images/profiles/' . (auth()->id()) . $fileNameExtension;
        $file->move(public_path('/images/profiles'), (auth()->id()) . $fileNameExtension);
    }

    $user->save();

    return redirect()->route('profile')->withSuccess('Profile Updated Succesfully!');

}


    
/**
 * Perform a general full-text search across users, tasks, and projects for users.
 */
public function generalSearch(Request $request)
{
    $request->validate([
        'search_query' => 'required|string',
    ]);

    $searchQuery = $request->input('search_query');

    if (strpos($searchQuery, 'exact:') === 0) {
        // Remove the "exact:" prefix and perform an exact match search
        $exactMatch = substr($searchQuery, 6);

        // Search users
        $users = User::where('name', $exactMatch)
            ->orWhere('email', $exactMatch)
            ->orWhere('username', $exactMatch)
            ->get();

        // Search projects
        $projects = Project::where('name', $exactMatch)
            ->orWhere('description', $exactMatch)
            ->get();

        // Search tasks
        $tasks = Task::where('name', $exactMatch)
            ->orWhere('description', $exactMatch)
            ->get();
    } else {
        // Regular full-text search

        // Search users
        $users = User::whereRaw(
                "to_tsvector('english', COALESCE(name, '') || ' ' || COALESCE(email, '') || ' ' || COALESCE(username, '')) @@ to_tsquery('english', ?)",
                ["'$searchQuery'"]
            )
            ->get();

        // Search projects
        $projects = Project::whereRaw(
                "to_tsvector('english', COALESCE(name, '') || ' ' || COALESCE(description, '')) @@ to_tsquery('english', ?)",
                ["'$searchQuery'"]
            )
            ->get();

        // Search tasks
        $tasks = Task::whereRaw(
                "to_tsvector('english', COALESCE(name, '') || ' ' || COALESCE(description, '')) @@ to_tsquery('english', ?)",
                ["'$searchQuery'"]
            )
            ->get();
    }

    $results = [
        'users' => $users->isEmpty() ? null : $users,
        'tasks' => $tasks->isEmpty() ? null : $tasks,
        'projects' => $projects->isEmpty() ? null : $projects,
    ];

    // Pass the results to the view
    return view('pages.search', compact('results'));


}

public function showMemberProfile($user_id)
{
    if (!Auth::check()) return redirect('/login');
    $member = User::find($user_id);
    //$this->authorize('teamAccess',$member);
    return view('pages.profile',['user'=>$member]);
}



public function acceptProjectInvite(Request $request)
{
    $invite = Invitation::where('token',$request->token)->first();
    if($invite==null) return redirect("/homepage");

    $user=User::find($invite->user_id);

    if($user==null) return redirect("/homepage");

    $project_id=$invite->proj_id;
    $user->projects()->attach($project_id);
    $user->invitations()->detach($project_id);
    $user->save();

    // Create a notification for the invitation acceptance
    $this->notificationController->storeProjectNotification($project_id, 'Accepted an invitation for the project ' . $invite->project->name);

    return redirect('/login')->withSuccess('Invitation to the project accepted successfully!');
}
 /**
 * Delete the user account.
 */
public function deleteUser(Request $request)
{
    $user = Auth::user();

    // Check if the user is enrolled in any project
    if ($user->projects->count() > 0) {
        return redirect()->back()->withErrors(['message' => 'You cannot delete your account because you are enrolled in one or more projects. Please leave all projects before deleting your account!']);
    }
    // Anonymize comments made by the user before deleting the user
    $this->anonymizeUserComments($user);

    // Delete the user profile image
    File::delete($user->profile_image);

    // Delete the user
    $user->delete();

    // Log the user out
    Auth::logout();

    return redirect('/')->withSuccess('Account Deleted Successfully!');
}

 /**
 * Anonymize comments made by the user in tasks.
 */
private function anonymizeUserComments($user)
{
    // Get all comments made by the user
    $userComments = $user->comments;

    // Anonymize each comment
    foreach ($userComments as $comment) {
        $comment->content = 'This comment was anonymized.';
        $comment->assigned_member = null;
        $comment->save();
    }
}

}

