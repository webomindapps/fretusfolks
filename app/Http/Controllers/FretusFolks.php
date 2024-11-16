<?php

namespace App\Http\Controllers;

use App\Models\ClientManagement;
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
    public function getData()
    {
        $fields = [
            'client_code',
            'client_name',
            'land_line',
            'client_email',
            'contact_person',
            'contact_person_phone',
            'contact_person_email',
            'contact_name_comm',
            'contact_phone_comm',
            'contact_email_comm',
            'registered_address',
            'communication_address',
            'pan',
            'tan',
            'gstn',
            'website_url',
            'service_state',
            'contract_start',
            'contract_end',
        ];
        $data = [];
        foreach ($fields as $field) {
            $data[] = [
                'label' => ucfirst(str_replace('_', ' ', $field)),
                'value' => $field,
            ];
        }
        return $data;
    }
    public function getClientname()
    {
        $clientnames = ClientManagement::all();
        $clientname_arr = [];
        foreach ($clientnames as $clientname) {
            $clientname_arr[] = ['label' => $clientname->client_name, 'value' => $clientname->client_name];
        }
        return $clientname_arr;
    }
}
