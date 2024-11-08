<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FretusFolks extends Controller
{
    public function getStatus()
    {
        return [
            ['label' => 'Active', 'value' => 1],
            ['label' => 'In-Active', 'value' => 0],
        ];
    }
}
