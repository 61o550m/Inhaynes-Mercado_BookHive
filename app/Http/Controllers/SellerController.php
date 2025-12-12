<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;

class SellerController extends Controller
{
    public function show($id)
    {
        $seller = User::findOrFail($id);

        $books = Book::where('user_id', $seller->id)->get();

        $followers = 10; // replace with real follower system later

        return view('seller.profile', compact('seller', 'books', 'followers'));
    }
}
