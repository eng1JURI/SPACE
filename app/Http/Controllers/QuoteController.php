<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteRequest;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Quote::where(function ($query) {
                $query->whereNull('scheduled_at')->orWhere('scheduled_at', '<=', now());
            })->with('user')
            ->withCount('likedBy')
            ->latest()
            ->limit(30)
            ->get();

        $likedQuoteIds = auth()->check()
            ? auth()->user()->likedQuotes()->pluck('quotes.id')->all()
            : [];

        return view('welcome', compact('quotes', 'likedQuoteIds'));
    }

    public function mine()
    {
        $quotes = Auth::user()->quotes()->with('user')->withCount('likedBy')->latest()->get();
        $likedQuoteIds = Auth::user()->likedQuotes()->pluck('quotes.id')->all();

        return view('welcome', [
            'quotes' => $quotes,
            'likedQuoteIds' => $likedQuoteIds,
            'sectionTitle' => 'Your SPACE',
            'canEdit' => true,
        ]);
    }

    public function likes()
    {
        $quotes = Auth::user()->likedQuotes()->where(function ($query) {
            $query->whereNull('scheduled_at')->orWhere('scheduled_at', '<=', now());
        })->with('user')->withCount('likedBy')->latest('quote_likes.created_at')->get();
        $likedQuoteIds = $quotes->pluck('id')->all();

        return view('welcome', [
            'quotes' => $quotes,
            'likedQuoteIds' => $likedQuoteIds,
            'sectionTitle' => 'Your Likes',
        ]);
    }

    public function store(QuoteRequest $request)
    {
        Auth::user()->quotes()->create($request->validated());
        return redirect()->route('home')->with('success', $request->validated('scheduled_at') ? 'Your SPACE has been scheduled.' : 'Your quote has been shared.');
    }

    public function update(QuoteRequest $request, Quote $quote)
    {
        abort_unless($quote->user_id === Auth::id(), 403);
        $quote->update($request->validated());

        return redirect()->route('my-space')->with('success', 'Your quote has been updated.');
    }

    public function destroy(Quote $quote)
    {
        abort_unless($quote->user_id === Auth::id(), 403);
        $quote->delete();

        return redirect()->back()->with('success', 'Your quote has been deleted.');
    }

    public function toggleLike(Quote $quote)
    {
        abort_if($quote->user_id === Auth::id(), 403, 'You cannot like your own quote.');
        abort_if($quote->scheduled_at && $quote->scheduled_at->isFuture(), 404);
        Auth::user()->likedQuotes()->toggle($quote->id);

        return back();
    }
}
