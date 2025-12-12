<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

public function index()
{
    $books = []; // or Book::all()

    $genres = [
        'Fiction',
        'Fantasy',
        'Romance',
        'Thriller',
        'Horror',
        'Sci-Fi',
        'Mystery',
        'Manga',
        'Historical'
    ];

    return view('home', compact('books', 'genres'));
}
}