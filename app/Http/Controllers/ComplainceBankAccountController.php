<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComplainceBankAccountController extends Controller
{
    public function index(){
        return view('admin.adms.compliance.pending-bank_account.index');
    }
}
