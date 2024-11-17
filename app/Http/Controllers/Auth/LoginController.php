<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // Remove any existing branch ID from the session
        session()->forget('branch_id');

        // Assuming the user's branch ID is stored in a 'branch_id' attribute on the user model
        if ($user->branch) {
            // Store the branch ID in the session
            session()->put('branch_id', $user->branch); // Store the branch ID instead of the entire branch object
        }

        if ($user->hasRole('Super Admin')) {
            return redirect()->route('super-index');
        }

        return redirect()->route('home'); // Redirect to home for other users
      
    }
}
