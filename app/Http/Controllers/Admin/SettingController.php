<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('admin.setting.index', compact('setting'));
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'company_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'logo' => 'nullable|image|max:2048', // Adjust max size if needed
            'pan_no' => 'nullable|string|max:50',
            'gst_no' => 'nullable|string|max:50',
            'website' => 'required|url|max:255',
            'addr_line1' => 'required|string|max:500',
            'addr_line2' => 'nullable|string|max:500',
        ]);

        $setting = Setting::first();

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $validatedData['logo'] = $logoPath;
        }

        $setting->update($validatedData);

        return redirect()->back()->with('success', 'Setting updated successfully');
    }
}
