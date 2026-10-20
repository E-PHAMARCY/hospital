<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $news = News::latest()->paginate(10, ['*'], 'news_page');
        $announcements = Announcement::latest()->take(15)->get();

        return view('admin.news.index', compact('news', 'announcements'));
    }

    public function storeNews(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:200'],
            'title_sw' => ['nullable', 'string', 'max:200'],
            'category' => ['required', 'string', 'max:100'],
            'excerpt_en' => ['required', 'string', 'max:500'],
            'excerpt_sw' => ['nullable', 'string', 'max:500'],
            'content_en' => ['required', 'string'],
            'content_sw' => ['nullable', 'string'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
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

        $validated['slug'] = Str::slug($validated['title_en']);
        $originalSlug = $validated['slug'];
        $count = 1;
        while (News::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = "{$originalSlug}-{$count}";
            $count++;
        }

        if ($request->hasFile('image_file')) {
            $dest = public_path('uploads/news');
            if (!file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file = $request->file('image_file');
            $filename = 'news_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dest, $filename);
            $validated['featured_image'] = 'uploads/news/' . $filename;
        }

        $validated['is_published'] = $request->boolean('is_published', true);
        $validated['published_at'] = now();
        $validated['views_count'] = 0;

        News::create($validated);

        return back()->with('success', "News article '{$validated['title_en']}' published successfully.");
    }

    public function updateNews(Request $request, News $news): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:200'],
            'title_sw' => ['nullable', 'string', 'max:200'],
            'category' => ['required', 'string', 'max:100'],
            'excerpt_en' => ['required', 'string', 'max:500'],
            'excerpt_sw' => ['nullable', 'string', 'max:500'],
            'content_en' => ['required', 'string'],
            'content_sw' => ['nullable', 'string'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
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
            $dest = public_path('uploads/news');
            if (!file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file = $request->file('image_file');
            $filename = 'news_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dest, $filename);
            $validated['featured_image'] = 'uploads/news/' . $filename;
        }

        $validated['is_published'] = $request->boolean('is_published', $news->is_published);

        $news->update($validated);

        return back()->with('success', "News article '{$news->title_en}' updated successfully.");
    }

    public function toggleNews(News $news): RedirectResponse
    {
        $news->update(['is_published' => !$news->is_published]);
        $statusText = $news->is_published ? 'published' : 'unpublished';

        return back()->with('success', "Article '{$news->title_en}' is now {$statusText}.");
    }

    public function destroyNews(News $news): RedirectResponse
    {
        $title = $news->title_en;
        $news->delete();
        return back()->with('success', "News article '{$title}' removed.");
    }

    public function storeAnnouncement(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:150'],
            'title_sw' => ['nullable', 'string', 'max:150'],
            'message_en' => ['required', 'string', 'max:1000'],
            'message_sw' => ['nullable', 'string', 'max:1000'],
            'type' => ['required', 'in:urgent,notice,info,alert'],
            'action_url' => ['nullable', 'string', 'max:255'],
            'action_text_en' => ['nullable', 'string', 'max:100'],
            'action_text_sw' => ['nullable', 'string', 'max:100'],
            'expires_at' => ['nullable', 'date'],
        ]);

        if (empty($validated['title_sw'])) {
            $validated['title_sw'] = $validated['title_en'];
        }
        if (empty($validated['message_sw'])) {
            $validated['message_sw'] = $validated['message_en'];
        }

        $validated['is_active'] = true;
        $validated['starts_at'] = now();

        Announcement::create($validated);

        return back()->with('success', "Hospital announcement '{$validated['title_en']}' is now active.");
    }

    public function updateAnnouncement(Request $request, Announcement $announcement): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:150'],
            'title_sw' => ['nullable', 'string', 'max:150'],
            'message_en' => ['required', 'string', 'max:1000'],
            'message_sw' => ['nullable', 'string', 'max:1000'],
            'type' => ['required', 'in:urgent,notice,info,alert'],
            'action_url' => ['nullable', 'string', 'max:255'],
            'action_text_en' => ['nullable', 'string', 'max:100'],
            'action_text_sw' => ['nullable', 'string', 'max:100'],
            'expires_at' => ['nullable', 'date'],
        ]);

        if (empty($validated['title_sw'])) {
            $validated['title_sw'] = $validated['title_en'];
        }
        if (empty($validated['message_sw'])) {
            $validated['message_sw'] = $validated['message_en'];
        }

        $announcement->update($validated);

        return back()->with('success', "Announcement '{$announcement->title_en}' updated successfully.");
    }

    public function toggleAnnouncement(Announcement $announcement): RedirectResponse
    {
        $announcement->update(['is_active' => !$announcement->is_active]);
        $statusText = $announcement->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Announcement is now {$statusText}.");
    }

    public function destroyAnnouncement(Announcement $announcement): RedirectResponse
    {
        $title = $announcement->title_en;
        $announcement->delete();

        return back()->with('success', "Announcement '{$title}' removed.");
    }
}
