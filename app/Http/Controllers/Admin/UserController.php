<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MuserMaster;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users=MuserMaster::paginate(10);
        return view('admin.ffimasters.usermasters.index',compact('users'));
    }

    public function create(){
        return view('admin.ffimasters.usermasters.create');
    }
}
