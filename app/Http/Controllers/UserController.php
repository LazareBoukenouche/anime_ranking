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
    public function login()
    {
        return view('login');
    }

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

    public function signup()
    {
        return view('signup');
    }

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

    public function signout (Request $request) 
    {
          Auth::logout();
          $request->session()->invalidate();
          $request->session()->regenerateToken();
          return redirect('/');
    }

    
}