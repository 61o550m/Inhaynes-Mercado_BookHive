<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\EditProfileController;
use App\Http\Controllers\UserActivityController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SellerController;


Route::get('/', function () {

    $genres = [
        'Fiction',
        'Fantasy',
        'Romance',
        'Thriller',
        'Horror',
        'Science Fiction',
        'Non-Fiction',
        'Education',
        'Mystery',
        'Manga',
        'Historical'
    ];
    $books = Book::latest()->take(12)->get();
    return view('home', [
       'books' => $books,
        'genres' => $genres
    ]);
})->name('home');






Route::get('/dashboard', function () {

    
    $books = Book::latest()->get();

    
    $genres = [
                'Fiction',
        'Fantasy',
        'Romance',
        'Thriller',
        'Horror',
        'Science Fiction',
        'Non-Fiction',
        'Education',
        'Mystery',
        'Manga',
        'Historical'
    ];

    
    $booksByGenre = [];
    foreach ($genres as $genre) {
        $booksByGenre[$genre] = Book::where('genre', $genre)->get();
    }

    return view('dashboard', [
        'books' => $books,
        'genres' => $genres,
        'booksByGenre' => $booksByGenre,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/sell', [BookController::class, 'index'])->name('books.index');
    Route::get('/sell/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/sell/store', [BookController::class, 'store'])->name('books.store');
    Route::get('/sell/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
Route::put('/sell/{book}', [BookController::class, 'update'])->name('books.update');
Route::delete('/sell/{book}', [BookController::class, 'destroy'])->name('books.destroy');


});

Route::get('/debug-delete', function () {
    \App\Models\User::truncate();
    return "all users deleted";
});



Route::get('/user/{id}', [UserProfileController::class, 'show'])->name('user.profile');

Route::post('/user/{id}/follow', [UserProfileController::class, 'follow'])
    ->middleware('auth')
    ->name('user.follow');

Route::post('/user/{id}/unfollow', [UserProfileController::class, 'unfollow'])
    ->middleware('auth')
    ->name('user.unfollow');

Route::get('/my-profile/edit', [EditProfileController::class, 'edit'])
    ->middleware('auth')
    ->name('myprofile.edit');

Route::post('/my-profile/update', [EditProfileController::class, 'update'])
    ->middleware('auth')
    ->name('myprofile.update');

Route::get('/book/{id}', [BookController::class, 'show'])->name('book.show');

use App\Http\Controllers\GenreController;

Route::get('/genre/{genre}', [GenreController::class, 'show'])->name('genre.show');



Route::get('/messages', [ChatController::class, 'index'])->name('messages.index');
Route::get('/messages/start/{userId}', [ChatController::class, 'startChat'])
    ->middleware('auth')
    ->name('messages.start');


Route::get('/messages/room/{roomId}', [ChatController::class, 'openRoom'])->name('messages.room');



Route::get('/chat/fetch/{roomId}', [ChatController::class, 'fetch'])->name('chat.fetch');




Route::post('/book/{id}/view', [BookController::class, 'incrementView']);
Route::post('/rate/{id}', [RatingController::class, 'store']);

Route::post('/report/{id}', [ReportController::class, 'store']);


Route::get('/wishlist', [UserActivityController::class, 'wishlist'])->name('wishlist');

Route::delete('/wishlist/{book_id}', 
    [UserActivityController::class, 'removeWishlist']
)->name('wishlist.remove');


Route::post('/wishlist/toggle/{book_id}', 
    [WishlistController::class, 'toggle'])
    ->middleware('auth')
    ->name('wishlist.toggle');


Route::get('/seller/{id}', [SellerController::class, 'show'])->name('seller.profile');

Route::post('/chat/send', [ChatController::class, 'send'])
    ->middleware('auth')
    ->name('chat.send');

Route::post('/chat/send-offer', [ChatController::class, 'sendOffer'])
    ->middleware('auth')
    ->name('chat.sendOffer');

Route::post('/chat/accept-offer', [ChatController::class, 'acceptOffer'])
    ->middleware('auth')
    ->name('chat.acceptOffer');

Route::get('/debug-deals', function () {
    return \App\Models\Deal::all();
});


use App\Models\Deal;

Route::get('/deals', function () {
    $deals = Deal::where('buyer_id', auth()->id())
                 ->orWhere('seller_id', auth()->id())
                 ->with(['seller', 'book'])
                 ->latest()
                 ->get();

    return view('deals.index', compact('deals'));
})->name('deals.index')->middleware('auth');


Route::get('/info', function () {
    return view('info');
});


require __DIR__.'/auth.php';
