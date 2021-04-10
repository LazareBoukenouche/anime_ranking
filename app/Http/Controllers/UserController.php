<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

use DB;


class UserController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

    // display the login template
    public function login()
    {
        return view('login');
    }

    // Validate the login form and log the user if valid
    public function check_login(Request $request)
    {
        $validated = $request->validate([
                "username" => "required",
                "password" => "required",
              ]);
              if (Auth::attempt($validated)) {
                return redirect()->intended('/');
              }
              return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
              ]);
    }

    // display the signup template
    public function signup()
    {
        return view('signup');
    }

    // add a new user to the database
    public function check_signup (Request $request) 
    {
          $validated = $request->validate([
            "username" => "required",
            "password" => "required",
            "password_confirmation" => "required|same:password"
          ]);
          $user = new User();
          $user->username = $validated["username"];
          $user->password = Hash::make($validated["password"]);
          $user->save();
          Auth::login($user);
        
          return redirect('/');
    }

    // disconnect the user
    public function signout (Request $request) 
    {
          Auth::logout();
          $request->session()->invalidate();
          $request->session()->regenerateToken();
          return redirect('/');
    }

    
}