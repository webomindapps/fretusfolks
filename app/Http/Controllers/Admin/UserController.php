<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MuserMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users=MuserMaster::paginate(10);
        return view('admin.ffimasters.usermasters.index',compact('users'));
    }

    public function create() {
        $roles = DB::table('roles')->pluck('name', 'id')->toArray(); 
        return view('admin.ffimasters.usermasters.create', compact('roles'));
    }
    
    public function store(Request $request){
        $request->validate([
            

        ]);

    }
}
