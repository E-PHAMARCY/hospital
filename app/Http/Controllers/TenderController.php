<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use Illuminate\View\View;

class TenderController extends Controller
{
    public function index(): View
    {
        $tenders = Tender::latest('publication_date')->paginate(10);
        return view('tenders.index', compact('tenders'));
    }

    public function show(string $slug): View
    {
        $tender = Tender::where('slug', $slug)->firstOrFail();
        return view('tenders.show', compact('tender'));
    }
}
