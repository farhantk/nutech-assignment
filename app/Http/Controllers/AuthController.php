<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function view_signin(){
        return view('auth/signin');
    }

    public function action_signin(Request $request){
        $validated = $request->validate([
            'email' => 'required|email:frc,dns',
            'password' => 'required'
        ]);

        if (!$token = JWTAuth::attempt($validated)) {
            return back()->with('loginError', 'Wrong credentials');
        }
    
        return redirect('/product')->withCookie(
            cookie('jwt_token', $token, 60, null, null, true, true)
        );
    }

    public function view_signup(){
        return view('auth/signup');
    }

    public function action_signup(Request $request){
        $validated = $request->validate([
            'name' => 'required|max:100|min:5',
            'email' => 'required|email:frc,dns|unique:users',
            'role' => 'required|min:5|max:50',
            'file' => 'required|image|mimes:png,jpg|max:100',
            'password' => 'required|min:5|max:255',
        ]);

        $filePath = $request->file('file')->store('photo');

        $validated['password'] = bcrypt($validated['password']);
        $validated['avatar'] = $filePath;

        $sql = "INSERT INTO users (name, email, role, avatar, password) 
                VALUES (?, ?, ?, ?, ?)";

        DB::insert($sql, [
            $validated['name'], 
            $validated['email'], 
            $validated['role'], 
            $validated['avatar'], 
            $validated['password']
        ]);

        // Flash success message
        $request->session()->flash('success', 'Register successful, please sign in');
        return redirect('/signin');
    }

    public function action_signout(Request $request){
        return redirect('/signin')->withCookie(Cookie::forget('jwt_token'));
    }

    public function view_profile(Request $request){
        return view('dashboard/profile', [
            'email' => Auth::user()->email,
            'name' => Auth::user()->name,
            'role' => Auth::user()->role,
            'avatar' => Auth::user()->avatar
        ]);
    }

}
