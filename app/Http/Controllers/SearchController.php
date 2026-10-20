<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\HealthArticle;
use App\Models\News;
use App\Models\Resource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function search(Request $request): View
    {
        $query = trim((string) $request->input('q', ''));

        if (strlen($query) < 2) {
            return view('search.index', [
                'query' => $query,
                'results' => collect(),
                'total' => 0,
            ]);
        }

        // Safe parameter binding via Eloquent
        $likeQuery = '%' . strtolower($query) . '%';

        $departments = Department::where('is_active', true)
            ->where(function ($q) use ($likeQuery) {
                $q->whereRaw('LOWER(name_en) LIKE ?', [$likeQuery])
                  ->orWhereRaw('LOWER(name_sw) LIKE ?', [$likeQuery])
                  ->orWhereRaw('LOWER(summary_en) LIKE ?', [$likeQuery])
                  ->orWhereRaw('LOWER(summary_sw) LIKE ?', [$likeQuery]);
            })
            ->take(5)
            ->get()
            ->map(fn($d) => [
                'type' => 'Department',
                'title' => $d->name,
                'snippet' => $d->summary,
                'url' => route('departments.show', $d->slug),
            ]);

        $services = Service::where('is_active', true)
            ->where(function ($q) use ($likeQuery) {
                $q->whereRaw('LOWER(name_en) LIKE ?', [$likeQuery])
                  ->orWhereRaw('LOWER(name_sw) LIKE ?', [$likeQuery])
                  ->orWhereRaw('LOWER(summary_en) LIKE ?', [$likeQuery])
                  ->orWhereRaw('LOWER(summary_sw) LIKE ?', [$likeQuery]);
            })
            ->take(5)
            ->get()
            ->map(fn($s) => [
                'type' => 'Service',
                'title' => $s->name,
                'snippet' => $s->summary,
                'url' => route('services.show', $s->slug),
            ]);

        $doctors = Doctor::where('is_active', true)
            ->where(function ($q) use ($likeQuery) {
                $q->whereRaw('LOWER(name) LIKE ?', [$likeQuery])
                  ->orWhereRaw('LOWER(qualification_en) LIKE ?', [$likeQuery])
                  ->orWhereRaw('LOWER(qualification_sw) LIKE ?', [$likeQuery]);
            })
            ->take(5)
            ->get()
            ->map(fn($doc) => [
                'type' => 'Doctor',
                'title' => $doc->name,
                'snippet' => $doc->qualification,
                'url' => route('doctors.show', $doc->id),
            ]);

        $news = News::where('is_published', true)
            ->where(function ($q) use ($likeQuery) {
                $q->whereRaw('LOWER(title_en) LIKE ?', [$likeQuery])
                  ->orWhereRaw('LOWER(title_sw) LIKE ?', [$likeQuery])
                  ->orWhereRaw('LOWER(excerpt_en) LIKE ?', [$likeQuery])
                  ->orWhereRaw('LOWER(excerpt_sw) LIKE ?', [$likeQuery]);
            })
            ->take(5)
            ->get()
            ->map(fn($n) => [
                'type' => 'News',
                'title' => $n->title,
                'snippet' => $n->excerpt,
                'url' => route('news.show', $n->slug),
            ]);

        $healthEducation = HealthArticle::where('is_published', true)
            ->where(function ($q) use ($likeQuery) {
                $q->whereRaw('LOWER(title_en) LIKE ?', [$likeQuery])
                  ->orWhereRaw('LOWER(title_sw) LIKE ?', [$likeQuery])
                  ->orWhereRaw('LOWER(excerpt_en) LIKE ?', [$likeQuery])
                  ->orWhereRaw('LOWER(excerpt_sw) LIKE ?', [$likeQuery]);
            })
            ->take(5)
            ->get()
            ->map(fn($h) => [
                'type' => 'Health Education',
                'title' => $h->title,
                'snippet' => $h->excerpt,
                'url' => route('health-education.show', $h->slug),
            ]);

        $announcements = Announcement::where('is_active', true)
            ->where(function ($q) use ($likeQuery) {
                $q->whereRaw('LOWER(title_en) LIKE ?', [$likeQuery])
                  ->orWhereRaw('LOWER(title_sw) LIKE ?', [$likeQuery])
                  ->orWhereRaw('LOWER(message_en) LIKE ?', [$likeQuery])
                  ->orWhereRaw('LOWER(message_sw) LIKE ?', [$likeQuery]);
            })
            ->take(3)
            ->get()
            ->map(fn($a) => [
                'type' => 'Announcement',
                'title' => $a->title,
                'snippet' => $a->message,
                'url' => route('announcements.index'),
            ]);

        $resources = Resource::where('is_active', true)
            ->where(function ($q) use ($likeQuery) {
                $q->whereRaw('LOWER(title_en) LIKE ?', [$likeQuery])
                  ->orWhereRaw('LOWER(title_sw) LIKE ?', [$likeQuery])
                  ->orWhereRaw('LOWER(description_en) LIKE ?', [$likeQuery])
                  ->orWhereRaw('LOWER(description_sw) LIKE ?', [$likeQuery]);
            })
            ->take(5)
            ->get()
            ->map(fn($r) => [
                'type' => 'Resource',
                'title' => $r->title,
                'snippet' => $r->description,
                'url' => route('resources.show', $r->id),
            ]);

        $results = collect()
            ->concat($departments)
            ->concat($services)
            ->concat($doctors)
            ->concat($news)
            ->concat($healthEducation)
            ->concat($announcements)
            ->concat($resources);

        return view('search.index', [
            'query' => $query,
            'results' => $results,
            'total' => $results->count(),
        ]);
    }
}
