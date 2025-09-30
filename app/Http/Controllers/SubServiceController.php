<?php

namespace App\Http\Controllers;

use App\Models\SubService;
use App\Models\Service;
use App\Services\TranslationService;
use Illuminate\Http\Request;

class SubServiceController extends Controller
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
        $subServices = SubService::with('service')->orderBy('sort_order')->get();
        return response()->json($subServices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'title' => 'required|string|max:255',
            'title_translations' => 'nullable|array',
            'points' => 'nullable|array',
            'points.*' => 'string',
            'points_translations' => 'nullable|array',
            'is_expanded' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
            'source_language' => 'nullable|in:en,it,fr'
        ]);

        // Handle translations - if title_translations is provided, use it directly
        if (isset($data['title_translations']) && is_array($data['title_translations'])) {
            // Use the provided translations directly
            $data['title_translations'] = $data['title_translations'];
        } else {
            // Generate translations if not provided
            $sourceLanguage = $data['source_language'] ?? $this->translationService->detectLanguage($data['title']);
            $data['title_translations'] = $this->translationService->generateTranslations($data['title'], $sourceLanguage);
        }
        
        // Handle points translations - if points_translations is provided, use it directly
        if (isset($data['points_translations']) && is_array($data['points_translations'])) {
            // Use the provided translations directly
            $data['points_translations'] = $data['points_translations'];
        } elseif (!empty($data['points'])) {
            // Generate translations if not provided
            $sourceLanguage = $data['source_language'] ?? $this->translationService->detectLanguage($data['title']);
            $data['points_translations'] = $this->translationService->generateArrayTranslations($data['points'], $sourceLanguage);
        }

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_expanded'] = $data['is_expanded'] ?? false;
        unset($data['source_language']); // Remove from data before saving

        SubService::create($data);

        return back()->with('success', 'Sub-service created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubService $subService)
    {
        return response()->json($subService->load('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubService $subService)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'title_translations' => 'nullable|array',
            'points' => 'nullable|array',
            'points.*' => 'string',
            'points_translations' => 'nullable|array',
            'is_expanded' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
            'source_language' => 'nullable|in:en,it,fr'
        ]);

        // Handle translations - prioritize English input if it's changed
        if (isset($data['title']) && !empty($data['title']) && $data['title'] !== $subService->title) {
            // English title has changed, generate new translations
            $sourceLanguage = $data['source_language'] ?? $this->translationService->detectLanguage($data['title']);
            $data['title_translations'] = $this->translationService->updateTranslations(
                $subService->title_translations ?? [], 
                $data['title'], 
                $sourceLanguage
            );
        } elseif (isset($data['title_translations']) && is_array($data['title_translations'])) {
            // Use the provided translations directly (from multilingual tabs)
            $data['title_translations'] = $data['title_translations'];
        }

        // Handle points translations - prioritize English input if it's changed
        if (isset($data['points']) && is_array($data['points'])) {
            if (json_encode($data['points']) !== json_encode($subService->points)) {
                $sourceLanguage = $data['source_language'] ?? $this->translationService->detectLanguage($data['title'] ?? $subService->title);
                $data['points_translations'] = $this->translationService->generateArrayTranslations($data['points'], $sourceLanguage);
            } elseif (isset($data['points_translations']) && is_array($data['points_translations'])) {
                $data['points_translations'] = array_intersect_key(
                    $data['points_translations'],
                    array_flip(array_keys($data['points']))
                );
            }
        } else {
            $data['points'] = null;
            $data['points_translations'] = null;
        }

        unset($data['source_language']); // Remove from data before saving
        $subService->update($data);

        return back()->with('success', 'Sub-service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubService $subService)
    {
        $subService->delete();

        return back()->with('success', 'Sub-service deleted successfully!');
    }

    /**
     * Toggle the status of a sub-service
     */
    public function toggleStatus(SubService $subService)
    {
        $subService->status = $subService->status === 'active' ? 'inactive' : 'active';
        $subService->save();

        return back()->with('success', 'Sub-service status updated!');
    }

    /**
     * Get sub-services for a specific service
     */
    public function getByService(Service $service)
    {
        $subServices = $service->subServices()->orderBy('sort_order')->get();
        return response()->json($subServices);
    }
}