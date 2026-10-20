<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\View\View;

class CareerController extends Controller
{
    public function index(): View
    {
        $careers = Career::where('is_active', true)
            ->where('deadline', '>=', now()->toDateString())
            ->with('department')
            ->latest()
            ->paginate(10);

        return view('careers.index', compact('careers'));
    }

    public function show(string $slug): View
    {
        $career = Career::where('slug', $slug)
            ->where('is_active', true)
            ->with('department')
            ->firstOrFail();

        return view('careers.show', compact('career'));
    }
}
