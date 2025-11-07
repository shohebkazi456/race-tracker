<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister() { return view('auth.register'); }
    public function showLogin()    { return view('auth.login'); }

    public function register(Request $r)
    {
        $r->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|confirmed'
        ]);
        $user = User::create([
            'name'=>$r->name,
            'email'=>$r->email,
            'password'=>Hash::make($r->password),
            'is_admin'=>false,
        ]);
        Auth::login($user);
        return redirect('/dashboard');
    }

    public function login(Request $r)
    {
        $r->validate(['email'=>'required|email','password'=>'required']);
        if (Auth::attempt($r->only('email','password'), $r->boolean('remember'))) {
            $r->session()->regenerate();
            return redirect()->intended('/dashboard');
        }
        return back()->withErrors(['email'=>'Invalid credentials'])->withInput();
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('login.form');
    }
}