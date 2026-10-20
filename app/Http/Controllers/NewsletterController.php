<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:150'],
        ]);

        NewsletterSubscriber::updateOrCreate(
            ['email' => $validated['email']],
            ['is_active' => true, 'subscribed_at' => now()]
        );

        return back()->with('success', 'Thank you for subscribing to Apex Health monthly wellness bulletins.');
    }
}
