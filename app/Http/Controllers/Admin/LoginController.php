<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class LoginController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.auth.login',compact('roles'));
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            if (auth()->user()->status != 1) {
                Auth::guard('web')->logout();
                return back()->with('danger', 'User is not active');
            }
            if (auth()->user()->hasRole($request->role)) {
                return to_route('admin.dashboard')->with('success', 'You have successfully logged in.');
            }
            return back()->with('danger', 'User is not active');
        }
        return back()->with('danger', 'Invalid credentials.');
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function logout()
    {
        Auth::logout();
        return to_route('admin.login');
    }
}
