<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Project;
use App\Models\User;
use App\Mail\Invitation;
use App\Http\Controllers\NotificationController;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;



class ProjectController extends Controller
{

    protected $notificationController;

    public function __construct(NotificationController $notificationController)
    {
        $this->notificationController = $notificationController;
    }
    /**
     * Show the project for a given id.
     */
    public function show(string $id): View
    {
        // Get the project.
        $project = Project::findOrFail($id);

        // Check if the current user can see (show) the project.
        $this->authorize('show', $project);  

        $user = User::find(auth()->id());
        $allusers = User::all();

        $companies = Company::all();
            // Get projects for user ordered by id.
        $projects = $user->projects()->orderBy('proj_id')->get();

        $tasks = $project->tasks()->orderBy('task_id')->get();

        // Use the pages.project template to display the project.
        return view('pages.project-overview', [
            'user' => $user, 'project' => $project,'projects' =>$projects, 'tasks' => $tasks, 'allusers' => $allusers, 'companies' => $companies
        ]);
    }

    /**
     * Shows all user projects.
     */
    public function list()
    {
        // Check if the user is logged in.
        if (!Auth::check()) {
            // Not logged in, redirect to login.
            return redirect('/login');

        } else {
            // The user is logged in.
            $user = User::find(auth()->id());
            $allusers = User::all();
            // Get projects for user ordered by id.
            $projects = $user->projects()->with('coordinator')->orderBy('proj_id')->get();
        
            // Check if the current user can list the projects.
            $this->authorize('list', Project::class);

            // The current user is authorized to list projects.

            // Use the pages.projects template to display all projects.
            return view('pages.projects', [
                'projects' => $projects , 'allusers' => $allusers
            ]);
        }
    }

    
    /**
     * Shows all user projects.
     */
    public function listFavorites()
    {
        // Check if the user is logged in.
        if (!Auth::check()) {
            // Not logged in, redirect to login.
            return redirect('/login');

        } else {
            // The user is logged in.
            $user = User::find(auth()->id());
            $allusers = User::all();
            // Get projects for user ordered by id.
            $favorites = $user->favorites()->get();
        
            // Check if the current user can list the projects.
            $this->authorize('list', Project::class);

            // The current user is authorized to list projects.

            // Use the pages.projects template to display all projects.
            return view('pages.fav_projects', [
                'favorites' => $favorites ,
            ]);
        }
    }

    /**
     * Shows all user projects.
     */
    public function listArchived(){

        // Check if the user is logged in.
        if (!Auth::check()) {
            // Not logged in, redirect to login.
            return redirect('/login');

        } else {
            // The user is logged in.
            $user = User::find(auth()->id());
            $allusers = User::all();
            // Get projects for user ordered by id.
            $archived = $user->archived()->get();
        
            // Check if the current user can list the projects.
            $this->authorize('list', Project::class);

            // The current user is authorized to list projects.

            // Use the pages.projects template to display all projects.
            return view('pages.arch_projects', [
                'archived' => $archived , 
            ]);
        }
    }
    /**
     * Creates a new project.
     */
    public function create(Request $request)
{
    // Create a blank new Project.
    $project = new Project();
    // Check if the current user is authorized to create this project.
    $this->authorize('create', $project);
    $request->validate([
    'due_date' => 'required|date|after:today',
    ]);
    // Set project details.
    $project->name = $request->input('name');
    $project->description = $request->input('description');
    $project->due_date = $request->input('due_date');
    $project->comp_id = $request->input('companies');
    $coordinatorId = $request->input('members');
    $project->coord_id = $coordinatorId;

    // Save the project and return it as JSON.
    $project->save();

    // Attach members
    if(auth()->id() != $coordinatorId){
        $project->member()->attach([auth()->id(), $coordinatorId]);
    }else{
        $project->member()->attach($coordinatorId);
    }

    return redirect()->route('projects.show', ['proj_id' => $project->proj_id]);
}

    public function edit(Request $request, $proj_id){
        if (!Auth::check()) {
            return redirect('/login');
        }

        $project = Project::findOrFail($proj_id);
        $request->validate([
            'name' => 'string',
            'description' => 'string',
            'due_date' => 'date|after:today|nullable',
        ]);
        
        $this->authorize('coordinator', $project);
        $project->name = $request->input('name');
        $project->description = $request->input('description');
        $project->due_date = $request->input('due_date');
        $project->save();

        return $project;

    }

public function addMember(Request $request, $proj_id)
{
    if (!Auth::check()) {
        return redirect('/login');
    }

    $validator = Validator::make($request->all(), [
        'user_ids' => 'required|array',
        'user_ids.*' => 'exists:users,user_id',
    ]);
 
    $validator->validate();
    $userIds = $request->input('user_ids');
    $project = Project::findOrFail($proj_id);


    $this->authorize('addMember', $project);  

    foreach ($userIds as $userId) {
      
        $userToAdd = User::findOrFail($userId);
        if(!$userToAdd->is_admin){ 
            $userId = (int)$userId;
            $token=Str::random(60);
            if($userToAdd != null){
                foreach($userToAdd->invitations as $invite){
                    if($project->proj_id==$invite->proj_id){
                        return redirect()->back()->withErrors('That user already has a pending invite');
                    }
                }
                $userToAdd->invitations()->attach($project->proj_id,['token'=>$token]);
            }
            
            $userToAdd->save();
            $url=URL::temporarySignedRoute(
                'acceptEmailProjectInvite', now()->addDays(10), ['token'=>$token]
            );
            Mail::to($userToAdd)->send(new Invitation ($project,$url));
        }
    }
    return redirect()->back()->with('success', 'Invite to the project successfully sent');
}

public function addFavorite(Request $request, $proj_id)
{
    $project = Project::findOrFail($proj_id);
    $user = User::find(auth()->id());

   // $this->authorize('authUser', $user->user_id);

    $user->favorites()->attach($project);

    $user->save();
    return;
}

public function removeFavorite($project_id){
    $user = User::find(auth()->id());
    $projects = $user->favorites()->get();
    foreach($projects as $project){
        if($project->proj_id==$project_id){
            $user->favorites()->detach($project);
            return;
        }
    }
    return;
}

public function archive($project_id){
    $project = Project::findOrFail($project_id);
    $members = $project->member()->get();

    //$this->authorize('coordinator', $project);
    foreach($members as $member) {
        $member->archived()->attach($project);
        $member->save();
    }
    return;
}
public function unarchive($project_id){
    $user = User::find(auth()->id());
    $projects = $user->archived()->get();

    foreach($projects as $project){
        if($project->proj_id==$project_id){
            //$this->authorize('coordinator', $project);
            $members = $project->member()->get();
            foreach($members as $member){
                $member->archived()->detach($project);
                $member->save();
            }
            return;
        }
    }
    return;
} 
public function removeMember(Request $request, $proj_id)
{
    if (!Auth::check()) {
        return redirect('/login');
    }

    $validator = Validator::make($request->all(), [
        'selectedMembers' => 'required|array',
        'selectedMembers.*' => 'exists:users,user_id',
    ]);

    $validator->validate();

    $selectedMembers = $request->input('selectedMembers');
    $project = Project::findOrFail($proj_id);

    //$this->authorize('removeMember', $project);
    foreach ($selectedMembers as $userId) {
        $userToRemove = User::findOrFail($userId);

        // Check if the member is assigned to any tasks in the project.
        if ($project->tasks()->where('user_id', $userId)->exists()) {
            return redirect()->back()->with('error', 'Cannot remove a member assigned to a task.');
        }
    }

    foreach ($selectedMembers as $userId) {
        $userToRemove = User::findOrFail($userId);
        $project->member()->detach($userToRemove);
    }

    $members = $project->member;
    $allusers = User::all();
    $membersHtml = view('pages.members', ['members' => $members, 'project' => $project, 'allusers'=>$allusers])->render();

    return $membersHtml;
}

public function changeCoordinator(Request $request, $proj_id)
    {
        // Check if the user is logged in.
        if (!Auth::check()) {
            return redirect('/login');
        }

        $project = Project::findOrFail($proj_id);
        
        $this->authorize('coordinator', $project);

        $validator = Validator::make($request->all(), [
            'newCoordinator' => 'required|exists:users,user_id',
        ]);

        $validator->validate();

        $newCoordinatorId = $request->input('newCoordinator');

        // Ensure the new coordinator is not the same as the old one.
        if ($newCoordinatorId == $project->coord_id) {
            return redirect()->back()->with('error', 'New coordinator cannot be the same as the current coordinator.');
        }

        $project->coord_id = $newCoordinatorId;
        $project->save();

        // Create a notification for the coordinator change
        $this->notificationController->storeProjectNotification($project->proj_id, 'Coordinator changed successfully for project ' . $project->name);

        return redirect()->back()->with('success', 'Coordinator changed successfully.');
    }


    public function leaveProject(Request $request, $proj_id)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $project = Project::findOrFail($proj_id);

        if ($project->tasks()->where('user_id', auth()->id())->exists()) {
            return redirect()->back()->withErrors(['message' => 'Cannot leave the project while assigned to a task. Before leaving the project, please assign your tasks to another project member or coordinator!']);
        }

        $project->member()->detach(auth()->id());

        return redirect('profile')->with('success', 'You have left the project successfully.');
    }

    public function showMembers($proj_id)
    {
        $project = Project::findOrFail($proj_id);

        $members = $project->member;
        $allusers = User::all();

        return view('pages.members', ['members' => $members, 'project' => $project, 'allusers'=>$allusers]);
    }

    public function showTasks($proj_id)
    {
        $project = Project::findOrFail($proj_id);

        $tasks = $project->tasks;

        return view('pages.tasksproj', ['tasks' => $tasks, 'project' => $project]);
    }
}
 