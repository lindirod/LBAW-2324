<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdministratorController extends Controller
{

    public function showAdminDashboard()
{
    $allusers = User::all();

    // Pass $allusers variable to the view
    return view('pages.admin', compact('allusers'));
}


    /**
     * Search for user accounts.
     */
    public function searchUsers(Request $request)
    {
        // Check if the authenticated user is an administrator based on the existence of a record in the 'administrator' table
        $admin = User::find(Auth::id());

        if ($admin->is_admin==TRUE) {
            // If the user is an administrator (record found), proceed with the following:

            // Get the search query parameter from the request
            $searchQuery = $request->input('search_query');

            // Extract the search type from the search query
            $searchType = 'full-text';
            if (strpos($searchQuery, 'exact:') === 0) {
                $searchType = 'exact';
                $searchQuery = substr($searchQuery, 6);
            }

            // Perform the search based on the provided query
            $users = [];
            if ($searchType === 'exact') {
                $users = User::where('name', $searchQuery)
                    ->orWhere('email', $searchQuery)
                    ->orWhere('id', $searchQuery)
                    ->get();
            } else {
                $users = User::where('name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('email', 'like', '%' . $searchQuery . '%')
                    ->orWhere('id', '=', $searchQuery)
                    ->get();
            }

            // Check if there are search results
            if ($users->count() > 0) {
                // If there are results, return a JSON with user details
                return response()->json(['results' => $users], 200);
            } else {
                // If no users are found, return a JSON with a 404 message
                return response()->json(['message' => 'No user accounts found matching the search criteria'], 404);
            }
        } else {
            // If the user is not an administrator, send a 403 Forbidden response with an error message
            return response()->json(['message' => 'Forbidden. Only administrators have access to this operation.'], 403);
        }
    }
    
    /**
     * Get User Details for Admin.
     *
     */
    public function getUserDetails(Request $request, $user_id)
    {
        // Check if the authenticated user is an administrator based on the existence of a record in the 'administrator' table
        $admin = User::find(Auth::id());

        if ($admin->is_admin==TRUE) {
            // If the user is an admin (record found), proceed with the following:

            // Retrieve the user with the specified ID
            $user = User::find($user_id);

            if ($user) {
                // If the user is found, return their details
                return response()->json($user, 200);
            } else {
                // If the user is not found, return a 404 response
                return response()->json(['message' => 'Not Found. User not found.'], 404);
            }
        } else {
            // If the user is not an admin, send a 403 Forbidden response with an error message
            return response()->json(['message' => 'Forbidden. Only administrators have access to this operation.'], 403);
        }
    }

    /**
     * Show User Edit Page for Admin.
     *
     */
    public function showUserEditPage(Request $request, $user_id)
    {
        // Check if the authenticated user is an administrator based on the existence of a record in the 'administrator' table
        $admin = User::find(Auth::id());

        if ($admin->is_admin==TRUE) {
            // If the user is an admin (record found), proceed with the following:

            // Retrieve the user with the specified ID
            $user = User::find($user_id);

            if ($user) {
                // If the user is found, return the view for the user edit page
                return view('pages.admuser', ['user' => $user]);
            } else {
                // If the user is not found, return a 404 response
                abort(404, 'Not Found. User not found.');
            }
        } else {
            // If the user is not an admin, return a 403 Forbidden response
            abort(403, 'Forbidden. Only administrators have access to this operation.');
        }
    }
    
    
    public function showUserEditProf(Request $request, $user_id)
    {
        // Check if the authenticated user is an administrator based on the existence of a record in the 'administrator' table
        $admin = User::find(Auth::id());

        if ($admin->is_admin==TRUE) {
            // If the user is an admin (record found), proceed with the following:

            // Retrieve the user with the specified ID
            $user = User::find($user_id);

            if ($user) {
                // If the user is found, return the view for the user edit page
                return view('pages.admedituser', ['user' => $user]);
            } else {
                // If the user is not found, return a 404 response
                abort(404, 'Not Found. User not found.');
            }
        } else {
            // If the user is not an admin, return a 403 Forbidden response
            abort(403, 'Forbidden. Only administrators have access to this operation.');
        }
    }


    public function updateUserProfile(Request $request, $user_id)
    {
        // Check if the authenticated user is an admin based on the existence of a record in the 'administrator' table
        $admin = User::find(Auth::id());

        if ($admin->is_admin==TRUE) {
            // If the user is an admin (record found), proceed with the following:

            // Retrieve the user with the specified ID
            $user = User::find($user_id);

            if ($user) {
                // If the user is found, update the profile with the provided data from the request
                //$user->update($request->all());
                $user->name = $request->input('name');
                $user->email = $request->input('email');
		
		$user->save();                

                // Return a JSON response with the updated user profile
                return redirect()->route('admin.editUser', ['user_id' => $user->user_id]) 
            ->withSuccess('You have successfully updated this user!');
            } else {
                // If the user is not found, return a 404 response
                return response()->json(['message' => 'Not Found. User not found.'], 404);
            }
        } else {
            // If the user is not an admin, send a 403 Forbidden response with an error message
            return response()->json(['message' => 'Forbidden. Only administrators have access to this operation.'], 403);
        }
    }

    /**
     * Delete User Account (Admin).
     */
    public function deleteUserAccount($user_id)
    {
        // Check if the authenticated user is an admin based on the existence of a record in the 'administrator' table
        $admin = User::find(Auth::id());

        $user = User::find($user_id);
        
        DB::table('users')
                	->where('user_id', $user_id)
                	->update(['is_projcoord' => FALSE]);
        
        if ($admin->is_admin==TRUE) {
            // If the user is an admin (record found), proceed with the following:

            // Retrieve the user with the specified ID
	    
	    if($user->is_admin==TRUE) {
	    	// If the user is admin can not delete
                return redirect()->route('admin.editUser', ['user_id' => $user->user_id]) 
            ->withSuccess('You can not delete an administrator!');
	    }
	    
	    if(Project::where('coord_id', $user_id)->exists()) {
	    	// If the user proj coordinator can not delete
	    	DB::table('users')
                	->where('user_id', $user_id)
                	->update(['is_projcoord' => FALSE]);
	    }
	    
            if ($user) {
                
                
                // If the user is found, delete the user account
                $user->delete();

                // Return a JSON response indicating successful deletion
                return redirect()->route('admin') 
            ->withSuccess('You have successfully deleted that user!');
            } else {
                // If the user is not found, return a 404 response
                return redirect()->route('admin.editUser', ['user_id' => $user->user_id]) 
            ->withSuccess('User not found!');
            }
        } else {
            // If the user is not an admin, send a 403 Forbidden response with an error message
            return redirect()->route('admin.editUser', ['user_id' => $user->user_id]) 
            ->withSuccess('Only administrators can perform this operation!');
        }
    }  
    
    
    public function blockUser($user_id)
{
    $admin = User::find(Auth::id());

        if ($admin->is_admin==TRUE) {
            // If the user is an admin (record found), proceed with the following:

            // Retrieve the user with the specified ID
            $user = User::find($user_id);

            if ($user->is_admin==FALSE) {
                // If the user is found, block the user account
                DB::table('users')
                	->where('user_id', $user_id)
                	->update(['is_blocked' => TRUE]);

                // Return a JSON response indicating successful block
                return redirect()->route('admin.editUser', ['user_id' => $user->user_id]) 
            ->withSuccess('You have successfully blocked the user!');
            }
            else {
            	return redirect()->route('admin/{user_id}') 
            ->withSuccess('You can not block an admin account!');
            }
    }
}


    public function unblockUser($user_id)
{
    $admin = User::find(Auth::id());

        if ($admin->is_admin==TRUE) {
            // If the user is an admin (record found), proceed with the following:

            // Retrieve the user with the specified ID
            $user = User::find($user_id);

            if ($user->is_admin==FALSE) {
                // If the user is found, unblock the user account
                DB::table('users')
                	->where('user_id', $user_id)
                	->update(['is_blocked' => FALSE]);

                // Return a JSON response indicating successful block
                return redirect()->route('admin.editUser', ['user_id' => $user->user_id]) 
            ->withSuccess('You have successfully unblocked the user!');
            }
            
    }
}


       
    public function showBlocked()
{
    return view('pages.blocked');
}


public function showCreateUser()
    {
        if (Auth::check() && auth()->user()->is_admin === TRUE) {
            $user = User::find(auth()->id());
            return view('pages.createuser');
        } 
        
        else {
            // If the user is not an admin, return a 403 Forbidden response
            abort(403, 'Forbidden. Only administrators have access to this operation.');
        }
    }



    public function createUser(Request $request)
{

	// Check if the authenticated user is an administrator
        $admin = User::find(Auth::id());

        if ($admin->is_admin==TRUE) {
            // If the user is an admin (record found), proceed with the following:

	
    $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'username' => 'required|string|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('admin') 
            ->withSuccess('You have successfully created a new user!');
            
            
        	}    
        }
    
}
