<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\SubService;
use App\Services\TranslationService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected TranslationService $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::orderBy('menu_order')->get();

        return inertia('Admin/Services', [
            'services' => $services,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:services,slug',
            'description' => 'nullable|string',
            'menu_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
            'source_language' => 'nullable|in:en,it,fr'
        ]);

        // Detect source language if not provided
        $sourceLanguage = $data['source_language'] ?? $this->translationService->detectLanguage($data['name']);

        // Generate translations
        $data['name_translations'] = $this->translationService->generateTranslations($data['name'], $sourceLanguage);

        if (!empty($data['description'])) {
            $data['description_translations'] = $this->translationService->generateTranslations($data['description'], $sourceLanguage);
        }

        $data['menu_order'] = $data['menu_order'] ?? 0;
        unset($data['source_language']); // Remove from data before saving

        Service::create($data);

        return redirect()->route('services.index')->with('success', 'Service created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        $service->load(['subServices' => fn($query) => $query->active()->orderBy('sort_order')]);

        return inertia('Airentibarabino/ServiceDetails', [
            'service' => $service,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'name_translations' => 'nullable|array',
            'slug' => 'nullable|string|max:255|unique:services,slug,' . $service->id,
            'description' => 'nullable|string',
            'description_translations' => 'nullable|array',
            'menu_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
            'source_language' => 'nullable|in:en,it,fr'
        ]);

        // Handle translations - prioritize English input if it's changed
        if (isset($data['name']) && !empty($data['name']) && $data['name'] !== $service->name) {
            // English name has changed, generate new translations
            $sourceLanguage = $data['source_language'] ?? $this->translationService->detectLanguage($data['name']);
            $data['name_translations'] = $this->translationService->updateTranslations(
                $service->name_translations ?? [],
                $data['name'],
                $sourceLanguage
            );
        } elseif (isset($data['name_translations']) && is_array($data['name_translations'])) {
            // Use the provided translations directly (from multilingual tabs)
            $data['name_translations'] = $data['name_translations'];
        }

        if (isset($data['description']) && !empty($data['description']) && $data['description'] !== $service->description) {
            // English description has changed, generate new translations
            $sourceLanguage = $data['source_language'] ?? $this->translationService->detectLanguage($data['description']);
            $data['description_translations'] = $this->translationService->updateTranslations(
                $service->description_translations ?? [],
                $data['description'],
                $sourceLanguage
            );
        } elseif (isset($data['description_translations']) && is_array($data['description_translations'])) {
            // Use the provided translations directly (from multilingual tabs)
            $data['description_translations'] = $data['description_translations'];
        }

        unset($data['source_language']); // Remove from data before saving
        $service->update($data);

        return redirect()->route('services.index')->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        // This will also delete all sub-services due to cascade delete
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully!');
    }

    /**
     * Toggle the status of a service
     */
    public function toggleStatus(Service $service)
    {
        $service->status = $service->status === 'active' ? 'inactive' : 'active';
        $service->save();

        return back()->with('success', 'Service status updated!');
    }

    /**
     * Get services for frontend dropdown
     */
    public function getForMenu()
    {
        return Service::forMenu()->get();
    }

    /**
     * Show sub-services for a specific service
     */
    public function subServices(Service $service)
    {
        $subServices = $service->subServices()->orderBy('sort_order')->get();

        return inertia('Admin/SubServices', [
            'service' => $service,
            'subServices' => $subServices,
        ]);
    }

    /**
     * Get full service hierarchy for frontend display
     */
    public function getHierarchy()
    {
        return Service::active()
            ->with(['subServices' => function($query) {
                $query->where('status', 'active')->orderBy('sort_order');
            }])
            ->get();
    }
}
