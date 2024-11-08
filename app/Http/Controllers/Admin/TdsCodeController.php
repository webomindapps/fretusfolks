<?php

namespace App\Http\Controllers\Admin;

use App\Models\TdsCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TdsCodeController extends Controller
{
    public function model()
    {
        return new TdsCode;
    }
    public function index()
    {
        $tds_code = TdsCode::paginate(10);
        return view('admin.ffimasters.tds_code.index', compact('tds_code'));
    }
    public function store(Request $request)
    {
        // 
        $request->validate([
            'code'=>'required',

        ]);
        TdsCode::create([
            'code'=> $request->code,
            'discount'=>0,
            'status'=>1,

        ]);
        


        return redirect()->route('tds_code')->with('success', 'Product added successfully');
    }
}
