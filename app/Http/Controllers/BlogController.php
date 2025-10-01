<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Services\TranslationService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
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
        return inertia('Admin/Blogs', [
            'blogs' => Blog::latest()->get(),
        ]);
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
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:active,inactive',
            'source_language' => 'nullable|in:en,it,fr'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('blogs', 'public');
            $data['image'] = $path;
        }

        // Detect source language if not provided
        $sourceLanguage = $data['source_language'] ?? $this->translationService->detectLanguage($data['title']);

        // Generate translations
        $data['description_translations'] = $this->translationService->generateTranslations($data['description'], $sourceLanguage);

        $data['slug'] = Str::slug($data['title']);
        $count = Blog::where('slug', 'like', "{$data['slug']}%")->count();
        if ($count > 0) {
            $data['slug'] .= '-' . ($count + 1);
        }

        unset($data['source_language']); // Remove from data before saving
        Blog::create($data);

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:active,inactive',
            'source_language' => 'nullable|in:en,it,fr'
        ]);

        if ($request->hasFile('image')) {
            if ($blog->image && Storage::disk('public')->exists(str_replace('/storage/', '', $blog->image))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $blog->image));
            }
            $path = $request->file('image')->store('blogs', 'public');
            $data['image'] = $path;
        } else {
            unset($data['image']);
        }

        // Update translations if description changed
        if (isset($data['description']) && !empty($data['description'])) {
            $sourceLanguage = $data['source_language'] ?? $this->translationService->detectLanguage($data['description']);
            $data['description_translations'] = $this->translationService->updateTranslations(
                $blog->description_translations ?? [],
                $data['description'],
                $sourceLanguage
            );
        }

        if (!empty($data['title'])) {
            $newSlug = Str::slug($data['title']);

            $count = Blog::where('slug', 'like', "{$newSlug}%")->where('id', '!=', $blog->id)->count();
            if ($count > 0) {
                $newSlug .= '-' . ($count + 1);
            }

            $data['slug'] = $newSlug;
        }

        unset($data['source_language']); // Remove from data before saving
        $blog->update($data);

        return redirect()->route('blogs.index')->with('success', 'Blog updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->image && Storage::disk('public')->exists(str_replace('/storage/', '', $blog->image))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $blog->image));
        }
        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Blog deleted!');
    }

    /**
     * Toggle the resource status
     */
    public function toggleStatus(Blog $blog)
    {
        $blog->status = $blog->status === 'active' ? 'inactive' : 'active';
        $blog->save();

        return back()->with('success', 'Blog status updated!');
    }

    /**
     * Display a listing of active blogs for public
     */
    public function publicIndex()
    {
        $blogs = Blog::where('status', 'active')
            ->latest()
            ->select(['id', 'title', 'slug', 'description', 'description_translations', 'image', 'created_at'])
            ->get()
            ->map(function ($blog) {
                // Strip HTML tags for preview
                $blog->description_preview = strip_tags($blog->description);
                return $blog;
            });

        return inertia('Airentibarabino/NewsInsights', [
            'blogs' => $blogs,
        ]);
    }

    /**
     * Display the specified blog for public
     */
    public function publicShow(Blog $blog)
    {
        if ($blog->status !== 'active') {
            abort(404);
        }

        // Get related blogs (other active blogs)
        $relatedBlogs = Blog::where('status', 'active')
            ->where('id', '!=', $blog->id)
            ->latest()
            ->limit(3)
            ->select(['id', 'title', 'slug', 'description', 'description_translations', 'image', 'created_at'])
            ->get();

        return inertia('Airentibarabino/BlogDetail', [
            'blog' => $blog,
            'relatedBlogs' => $relatedBlogs,
        ]);
    }
}
