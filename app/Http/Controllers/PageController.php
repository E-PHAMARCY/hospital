<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Faq;
use App\Models\HealthArticle;
use App\Models\LeadershipProfile;
use App\Models\News;
use App\Models\Page;
use App\Models\Service;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(?string $section = null): View
    {
        $slug = $section ? $section : 'about';
        $page = Page::where('slug', $slug)->first();

        if (!$page && $section) {
            abort(404, 'Institutional page not found.');
        }

        $leaders = null;
        if ($section === 'leadership') {
            $leaders = LeadershipProfile::where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->groupBy('role_category');
        }

        return view('pages.about', [
            'page' => $page,
            'section' => $section,
            'leaders' => $leaders,
        ]);
    }

    public function patients(?string $section = null): View
    {
        $slug = $section ? $section : 'admission';
        $page = Page::where('slug', $slug)->first();

        $faqs = null;
        if ($section === 'faq') {
            $faqs = Faq::where('is_active', true)->orderBy('sort_order')->get()->groupBy('category');
        }

        return view('pages.patients', [
            'page' => $page,
            'section' => $section,
            'faqs' => $faqs,
        ]);
    }

    public function legal(string $slug): View
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        return view('pages.legal', compact('page'));
    }

    public function sitemap(): Response
    {
        $departments = Department::where('is_active', true)->get();
        $services = Service::where('is_active', true)->get();
        $doctors = Doctor::where('is_active', true)->get();
        $news = News::where('is_published', true)->get();
        $healthArticles = HealthArticle::where('is_published', true)->get();

        $content = view('sitemap', compact(
            'departments',
            'services',
            'doctors',
            'news',
            'healthArticles'
        ))->render();

        return response($content, 200)->header('Content-Type', 'text/xml');
    }
}
