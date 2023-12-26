<?php
 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\View\View;

class LoginController extends Controller
{

    /**
     * Display a login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('profile');
        } else {
            return view('auth.login');
        }
    }

    public function authenticate(Request $request): RedirectResponse
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

 // Attempt authentication for the users guard
if (Auth::guard('web')->attempt($credentials, $request->filled('remember'))) {
	// If User is blocked, redirect to blocked page
      if (auth()->user()->is_blocked) {
        $request->session()->regenerate();
        return redirect()->intended('blocked');
    } else {
        // Regular user is authenticated, redirect to the user's profile page
        $request->session()->regenerate();
        return redirect()->intended('profile');
    }
}

    // If no authentication is successful, redirect back with an error
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}

    /**
     * Log out the user from application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('homepage')
            ->withSuccess('You have logged out successfully!');
    } 
}
