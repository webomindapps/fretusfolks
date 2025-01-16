<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'logo' => 'logo.png',
            'company_name' => 'Fretus Folks India Pvt Ltd',
            'addr_line1' => 'M-20, UKS Heights,3rd Floor,Jeevan Bhima Nagar Main Road, Bangalore 560017',
            'addr_line2' => '',
            'gst_no' => '',
            'pan_no' => '',
            'email' => 'info@fretusfolks.com',
            'phone' => '080-4372630',
            'website' => 'www.fretusfolks.com',
        ]);
    }
}
