<?php

namespace App\Http\Controllers;

use App\Models\States;
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
    public function getRegion()
    {
        return [
            ['label' => 'North', 'value' => 'North'],
            ['label' => 'South', 'value' => 'South'],
            ['label' => 'East', 'value' => 'East'],
            ['label' => 'West', 'value' => 'West'],
            ['label' => 'Pan India', 'value' => 'Pan India'],

        ];
    }
    public function getStates()
    {
        $states = States::all();
        $states_arr = [];
        foreach ($states as $state) {
            $states_arr[] = ['label' => $state->state_name, 'value' => $state->id];
        }
        return $states_arr;
    }
}
