<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::where('user_id', Auth::id())->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $books = Book::where('user_id', Auth::id())->get();
        return view('books.create', compact('books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'author' => 'required',
            'condition' => 'required',
            'price' => 'required|numeric',
            'genre' => 'required',
            'description' => 'nullable',
                'photos' => 'required',
            'photos.*' => 'image|max:5000',
        ]);

        $photos = [];

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('books', 'public');
                $photos[] = $path;
            }
        }

        Book::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'author' => $validated['author'],
            'condition' => $validated['condition'],
            'price' => $validated['price'],
            'genre' => $validated['genre'],
            'description' => $validated['description'] ?? null,
            'photos' => json_encode($photos),
            'thumbnail' => $photos[0] ?? null,
        ]);

        return redirect()->route('books.index')->with('success', 'Book Listed!');
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

public function update(Request $request, Book $book)
{
    $validated = $request->validate([
        'title' => 'required',
        'author' => 'required',
        'condition' => 'required',
        'price' => 'required|numeric',
        'genre' => 'required',
        'description' => 'nullable',
        'photos.*' => 'image|max:5000'
    ]);

    
    $existingPhotos = json_decode($book->photos, true);
    if (!is_array($existingPhotos)) {
        $existingPhotos = [];
    }

    
    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $photo) {
            $path = $photo->store('books', 'public');
            $existingPhotos[] = $path;
        }
    }

    
    $thumbnail = $existingPhotos[0] ?? null;

    
    $book->update([
        'title' => $validated['title'],
        'author' => $validated['author'],
        'condition' => $validated['condition'],
        'price' => $validated['price'],
        'genre' => $validated['genre'],
        'description' => $validated['description'] ?? null,
        'photos' => json_encode($existingPhotos),
        'thumbnail' => $thumbnail,
    ]);

    return redirect()->route('books.index')->with('success', 'Book Updated');
}
public function show($id)
{
    $book = Book::findOrFail($id);

    $seller = $book->user;

$relatedBooks = Book::where('user_id', $seller->id)
                    ->where('id', '!=', $book->id)
                    ->get();

    
    $isFav = \App\Models\Wishlist::where('user_id', auth()->id())
                                 ->where('book_id', $book->id)
                                 ->exists();

    
    $wishlistCount = \App\Models\Wishlist::where('book_id', $book->id)->count();

    return view('books.show', compact('book', 'seller', 'relatedBooks', 'isFav', 'wishlistCount'));
}



    public function destroy(Book $book)
    {
        $book->delete();
        return back()->with('success', 'Book Deleted');
    }


public function incrementView($id)
{
    $book = Book::find($id);
    $book->increment('views');
}

}
