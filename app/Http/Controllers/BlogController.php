<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
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
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('blogs', 'public');
            $data['image'] = "/storage/" . $path;
        }

        $data['slug'] = Str::slug($data['title']);
        $count = Blog::where('slug', 'like', "{$data['slug']}%")->count();
        if ($count > 0) {
            $data['slug'] .= '-' . ($count + 1);
        }

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
        ]);

        if ($request->hasFile('image')) {
            if ($blog->image && Storage::disk('public')->exists(str_replace('/storage/', '', $blog->image))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $blog->image));
            }
            $path = $request->file('image')->store('blogs', 'public');
            $data['image'] = "/storage/" . $path;
        }else {
            unset($data['image']);
        }
        if (!empty($data['name'])) {
            $newSlug = Str::slug($data['name']);

            $count = Blog::where('slug', 'like', "{$newSlug}%")->where('id', '!=', $blog->id)->count();
            if ($count > 0) {
                $newSlug .= '-' . ($count + 1);
            }

            $data['slug'] = $newSlug;
        }
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
}
