<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Statickidz\GoogleTranslate;

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
            'status' => 'required|in:active,inactive'
        ]);

        $data['slug'] = Str::slug($data['name']);
        $count = Service::where('slug', 'like', "{$data['slug']}%")->count();
        if ($count > 0) {
            $data['slug'] .= '-' . ($count + 1);
        }
        Service::create($data);

        return redirect()->route('services.index')->with('success', 'Service created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return inertia('Airentibarabino/ServiceDetails', [
            'service' => $service,
        ]);
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
            'status' => 'required|in:active,inactive'
        ]);

        if (!empty($data['name'])) {
            $newSlug = Str::slug($data['name']);

            $count = Service::where('slug', 'like', "{$newSlug}%")->where('id', '!=', $service->id)->count();
            if ($count > 0) {
                $newSlug .= '-' . ($count + 1);
            }

            $data['slug'] = $newSlug;
        }
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

    public function toggleStatus(Service $service)
    {
        $translator = new GoogleTranslate();
        $italiano = $translator->translate('en', 'it', $service->name);
        $francais = $translator->translate('en', 'fr', $service->name);
        dd($italiano, $francais);
        $service->status = $service->status === 'active' ? 'inactive' : 'active';
        $service->save();

        return back()->with('success', 'Service status updated!');
    }
}
