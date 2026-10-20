<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $query = Faq::orderBy('sort_order');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('question_en', 'like', "%{$search}%")
                  ->orWhere('question_sw', 'like', "%{$search}%")
                  ->orWhere('answer_en', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $faqs = $query->paginate(15)->withQueryString();

        return view('admin.faqs.index', compact('faqs', 'search'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'question_en' => ['required', 'string', 'max:255'],
            'question_sw' => ['nullable', 'string', 'max:255'],
            'answer_en' => ['required', 'string'],
            'answer_sw' => ['nullable', 'string'],
            'category' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = (Faq::max('sort_order') ?? 0) + 1;

        Faq::create($validated);

        return back()->with('success', 'FAQ question posted successfully.');
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $validated = $request->validate([
            'question_en' => ['required', 'string', 'max:255'],
            'question_sw' => ['nullable', 'string', 'max:255'],
            'answer_en' => ['required', 'string'],
            'answer_sw' => ['nullable', 'string'],
            'category' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $faq->update($validated);

        return back()->with('success', 'FAQ updated successfully.');
    }

    public function toggleStatus(Faq $faq): RedirectResponse
    {
        $faq->update(['is_active' => !$faq->is_active]);
        $statusText = $faq->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "FAQ has been {$statusText}.");
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return back()->with('success', 'FAQ removed successfully.');
    }
}
