<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category');
        $query = News::where('is_published', true)->latest('published_at');

        if ($category) {
            $query->where('category', $category);
        }

        $news = $query->paginate(9)->withQueryString();
        $categories = News::where('is_published', true)->distinct()->pluck('category');

        return view('news.index', compact('news', 'categories', 'category'));
    }

    public function show(string $slug): View
    {
        $article = News::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $article->increment('views_count');

        $related = News::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->take(3)
            ->get();

        return view('news.show', compact('article', 'related'));
    }

    public function announcements(): View
    {
        $announcements = Announcement::where('is_active', true)
            ->latest()
            ->paginate(10);

        return view('announcements.index', compact('announcements'));
    }

    public function announcementShow(int $id): View
    {
        $announcement = Announcement::where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();

        return view('announcements.show', compact('announcement'));
    }
}
