<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HealthArticle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HealthEducationController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $category = $request->query('category');

        $query = HealthArticle::latest('created_at');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title_en', 'like', "%{$search}%")
                  ->orWhere('title_sw', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%");
            });
        }

        if ($category) {
            $query->where('category', $category);
        }

        $articles = $query->paginate(12)->withQueryString();
        $categories = HealthArticle::distinct()->pluck('category');

        return view('admin.health-education.index', compact('articles', 'categories', 'search', 'category'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:200'],
            'title_sw' => ['nullable', 'string', 'max:200'],
            'category' => ['required', 'string', 'max:100'],
            'author_name' => ['nullable', 'string', 'max:150'],
            'excerpt_en' => ['required', 'string', 'max:500'],
            'excerpt_sw' => ['nullable', 'string', 'max:500'],
            'content_en' => ['required', 'string'],
            'content_sw' => ['nullable', 'string'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'disclaimer_en' => ['nullable', 'string', 'max:1000'],
            'disclaimer_sw' => ['nullable', 'string', 'max:1000'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        if (empty($validated['title_sw'])) {
            $validated['title_sw'] = $validated['title_en'];
        }
        if (empty($validated['excerpt_sw'])) {
            $validated['excerpt_sw'] = $validated['excerpt_en'];
        }
        if (empty($validated['content_sw'])) {
            $validated['content_sw'] = $validated['content_en'];
        }
        if (empty($validated['author_name'])) {
            $validated['author_name'] = 'Clinical Medical Staff';
        }

        $validated['slug'] = Str::slug($validated['title_en']);
        $originalSlug = $validated['slug'];
        $count = 1;
        while (HealthArticle::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = "{$originalSlug}-{$count}";
            $count++;
        }

        if ($request->hasFile('image_file')) {
            $dest = public_path('uploads/health');
            if (!file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file = $request->file('image_file');
            $filename = 'health_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dest, $filename);
            $validated['featured_image'] = 'uploads/health/' . $filename;
        }

        $validated['is_published'] = $request->boolean('is_published', true);
        $validated['published_at'] = now();
        $validated['views_count'] = 0;

        HealthArticle::create($validated);

        return back()->with('success', "Health article '{$validated['title_en']}' published successfully.");
    }

    public function update(Request $request, HealthArticle $healthArticle): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:200'],
            'title_sw' => ['nullable', 'string', 'max:200'],
            'category' => ['required', 'string', 'max:100'],
            'author_name' => ['nullable', 'string', 'max:150'],
            'excerpt_en' => ['required', 'string', 'max:500'],
            'excerpt_sw' => ['nullable', 'string', 'max:500'],
            'content_en' => ['required', 'string'],
            'content_sw' => ['nullable', 'string'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'disclaimer_en' => ['nullable', 'string', 'max:1000'],
            'disclaimer_sw' => ['nullable', 'string', 'max:1000'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        if (empty($validated['title_sw'])) {
            $validated['title_sw'] = $validated['title_en'];
        }
        if (empty($validated['excerpt_sw'])) {
            $validated['excerpt_sw'] = $validated['excerpt_en'];
        }
        if (empty($validated['content_sw'])) {
            $validated['content_sw'] = $validated['content_en'];
        }

        if ($request->hasFile('image_file')) {
            $dest = public_path('uploads/health');
            if (!file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file = $request->file('image_file');
            $filename = 'health_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dest, $filename);
            $validated['featured_image'] = 'uploads/health/' . $filename;
        }

        $validated['is_published'] = $request->boolean('is_published', $healthArticle->is_published);

        $healthArticle->update($validated);

        return back()->with('success', "Health article '{$healthArticle->title_en}' updated successfully.");
    }

    public function toggleStatus(HealthArticle $healthArticle): RedirectResponse
    {
        $healthArticle->update(['is_published' => !$healthArticle->is_published]);
        $statusText = $healthArticle->is_published ? 'published' : 'drafted';

        return back()->with('success', "Article '{$healthArticle->title_en}' is now {$statusText}.");
    }

    public function destroy(HealthArticle $healthArticle): RedirectResponse
    {
        $title = $healthArticle->title_en;
        $healthArticle->delete();

        return back()->with('success', "Article '{$title}' removed.");
    }
}
