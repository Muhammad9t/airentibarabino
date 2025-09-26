<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        $setting = Setting::firstOrCreate([], []); // ensures at least one row exists
        return inertia('Admin/Settings', [
            'setting' => $setting,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        $data = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'phone_one' => 'nullable|string|max:20',
            'phone_two' => 'nullable|string|max:20',
            'email_one' => 'nullable|email|max:255',
            'email_two' => 'nullable|email|max:255',
            'address_one' => 'nullable|string|max:255',
            'address_two' => 'nullable|string|max:255',
            'footer_description' => 'nullable|string',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $setting->update($data);

        return back()->with('success', 'Settings updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
