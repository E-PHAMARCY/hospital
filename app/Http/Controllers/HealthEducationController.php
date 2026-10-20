<?php

namespace App\Http\Controllers;

use App\Models\HealthArticle;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HealthEducationController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category');
        $query = HealthArticle::where('is_published', true)->latest('published_at');

        if ($category) {
            $query->where('category', $category);
        }

        $articles = $query->paginate(9)->withQueryString();
        $categories = HealthArticle::where('is_published', true)->distinct()->pluck('category');

        return view('health_education.index', compact('articles', 'categories', 'category'));
    }

    public function show(string $slug): View
    {
        $article = HealthArticle::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $article->increment('views_count');

        $related = HealthArticle::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->take(3)
            ->get();

        return view('health_education.show', compact('article', 'related'));
    }
}
