<?php

namespace App\Http\Controllers;

use App\Models\States;
use App\Models\FHRMSModel;
use Illuminate\Http\Request;
use App\Models\ClientManagement;

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
    public function getMarital()
    {
        return [
            ['label' => 'Single', 'value' => 'Single'],
            ['label' => 'Married', 'value' => 'Married'],
        ];
    }
    public function getBlood()
    {
        return [
            ['label' => 'O+', 'value' => 'O+'],
            ['label' => 'O-', 'value' => 'O-'],
            ['label' => 'A+', 'value' => 'A+'],
            ['label' => 'A-', 'value' => 'A-'],
            ['label' => 'B+', 'value' => 'B+'],
            ['label' => 'B-', 'value' => 'B-'],
            ['label' => 'AB+', 'value' => 'AB+'],
            ['label' => 'AB-', 'value' => 'AB-'],
        ];
    }
    public function getUan()
    {
        return [
            ['label' => 'Old', 'value' => 'old'],
            ['label' => 'New', 'value' => 'new'],
        ];
    }

    public function getFHRMSData()
    {
        $fields = [
            'ffi_emp_id',
            'emp_name',
            'designation',
            'department',
            'state',
            'location',
            'phone1',
            'phone2',
            'email',
            'interview_date',
            'joining_date',
            'contract_date',
            'dob',
            'father_name',
            'blood_group',
            'qualification',
            'permanent_address',
            'present_address',
            'pan_no',
            'aadhar_no',
            'driving_license_no',
            'bank_name',
            'bank_account_no',
            'bank_ifsc_code',
            'uan_no'
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

    public function getLocation()
    {
        $locations = FHRMSModel::distinct()->pluck('location');
        $loc = [];
        foreach ($locations as $location) {
            $loc[] = [
                'label' => $location,
                'value' => $location,
            ];
        }
        return $loc;
    }

    public function getDocuments()
    {
        $documents = [
            'pan_path',
            'aadhar_path',
            'driving_license_path',
            'bank_document',
            'voter_id',
            'emp_form',
            'pf_esic_form',
            'payslip',
            'exp_letter',
            'resume',
        ];

        $pending_doc = [];

        foreach ($documents as $document) {
            $hasPending = FHRMSModel::whereNull($document)
                ->orWhere($document, '')
                ->exists();

            if ($hasPending) {
                $pending_doc[] = [
                    'label' => ucfirst(str_replace('_', ' ', $document)),
                    'value' => $document, // Use the document field as the value
                ];
            }
        }

        return $pending_doc;
    }

}
