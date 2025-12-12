<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Deal;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserActivityController extends Controller
{
    public function wishlist()
    {
        $books = Book::whereIn(
                'id',
                Wishlist::where('user_id', Auth::id())->pluck('book_id')
            )
            ->with('user')
            ->get()
            ->groupBy(function ($book) {
                return $book->user->name ?? 'Unknown Seller';
            });

        return view('profile.wishlist', compact('books'));
    }

    public function deals()
    {
        $deals = Deal::where('buyer_id', Auth::id())
            ->with('book', 'seller')
            ->get();

        return view('profile.deal-history', compact('deals'));
    }

    public function removeWishlist($book_id)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('book_id', $book_id)
            ->delete();

        return redirect()->back()->with('success', 'Removed from wishlist.');
    }

    public function toggleWishlist($book_id)
    {
        $existing = Wishlist::where('user_id', Auth::id())
            ->where('book_id', $book_id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['removed' => true]);
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'book_id' => $book_id,
        ]);

        return response()->json(['added' => true]);
    }
}
