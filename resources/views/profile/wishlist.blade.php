@extends('layouts.app')

@section('content')
<div class="wishlist-page">
<h2 class="wishlist-title">Your Wishlist</h2>

@forelse($books as $sellerName => $sellerBooks)
<div class="seller-group" id="seller-group-{{ Str::slug($sellerName) }}">
    <h3 class="wishlist-seller seller-indent">{{ $sellerName }}</h3>

    <div class="wishlist-grid">
        @foreach($sellerBooks as $book)

            <div class="wishlist-card-wrapper" id="wishlist-{{ $book->id }}">

                @include('components.book-card', [
                    'book'   => $book,
                    'img'    => $book->thumbnail,
                    'author' => $book->author,
                    'title'  => $book->title,
                    'price'  => $book->price,
                ])

            </div>
        @endforeach
    </div>
</div>
    @empty
        <div class="empty-deals">
            <p>No items in your wishlist yet.</p>
        </div>
    @endforelse

</div>
@endsection
