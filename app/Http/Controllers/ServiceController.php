<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Admin/Services', [
            'services' => Service::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        dd('create fn()');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Service::create($data);

        return redirect()->route('services.index')->with('success', 'Service created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        dd($service);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        dd($service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $service->update($data);

        return redirect()->route('services.index')->with('success', 'Service updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted!');
    }
}
