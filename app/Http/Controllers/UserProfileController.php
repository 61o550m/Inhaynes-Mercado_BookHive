<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $books = Book::where('user_id', $user->id)->get();
        $followers = $user->followers()->count();

        $isFollowing = false;
        if (Auth::check()) {
            $isFollowing = Auth::user()->following()->where('followed_user_id', $user->id)->exists();
        }

        return view('profile.user-profile', compact('user', 'books', 'followers', 'isFollowing'));
    }

    public function follow($id)
    {
        $user = User::findOrFail($id);

        Auth::user()->following()->create([
            'followed_user_id' => $user->id
        ]);

        return back();
    }

    public function unfollow($id)
    {
        Auth::user()->following()->where('followed_user_id', $id)->delete();

        return back();
    }
}
