<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function me(Request $request)
    {
        return $this->render($request, Auth::user());
    }

    public function show(Request $request, User $user)
    {
        return $this->render($request, $user);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[\pL\pM ]+$/u'],
            'bio' => ['nullable', 'string', 'max:120'],
        ]);

        Auth::user()->update($data);

        return redirect()->route('profile')->with('success', 'Your profile has been updated.');
    }

    private function render(Request $request, User $user)
    {
        $isMe = Auth::id() === $user->id;
        $tab = $isMe && in_array($request->query('tab'), ['liked', 'scheduled']) ? $request->query('tab') : 'spaces';
        $published = fn ($q) => $q->whereNull('scheduled_at')->orWhere('scheduled_at', '<=', now());

        $query = match ($tab) {
            'liked' => $user->likedQuotes()->where($published),
            'scheduled' => $user->quotes()->where('scheduled_at', '>', now()),
            default => $user->quotes()->where($published),
        };

        $quotes = $query->with('user')->withCount('likedBy')->latest()->get();

        $stats = [
            'spaces' => $user->quotes()->where($published)->count(),
            'received' => DB::table('quote_likes')->whereIn('quote_id', $user->quotes()->select('id'))->count(),
            'given' => $user->likedQuotes()->count(),
        ];

        return view('profile', compact('user', 'isMe', 'tab', 'quotes', 'stats'));
    }
}
