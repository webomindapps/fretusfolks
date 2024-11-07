<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return to_route('admin.dashboard')->with('success', 'You have successfully logged in.');
        }
        return back()->with('danger', 'Invalid credentials.');
    }
    public function dashboard(){
        return view('admin.dashboard');
    }
    public function logout()
    {
        Auth::logout();
        return to_route('admin.login');
    }
}
