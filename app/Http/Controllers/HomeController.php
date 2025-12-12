<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class HomeController extends Controller
{
    public function index()
    {
        $genres = Book::select('genre')
            ->distinct()
            ->orderBy('genre')
            ->pluck('genre');

        $booksByGenre = Book::all()->groupBy('genre');

        $books = Book::latest()->take(20)->get();

        return view('home', compact('books', 'genres', 'booksByGenre'));
    }
}
