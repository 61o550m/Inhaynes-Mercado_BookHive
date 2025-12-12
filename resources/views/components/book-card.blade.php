@props(['book', 'img' => null, 'title' => null, 'author' => null, 'price' => null])

@php
    $isFav = auth()->check()
        ? \App\Models\Wishlist::where('user_id', auth()->id())->where('book_id', $book->id)->exists()
        : false;

    $isOwner = auth()->id() === $book->user_id;

    $src = $img
        ? (Str::startsWith($img, ['http', '/storage']) ? $img : asset('storage/' . $img))
        : asset('img/default-book.png');
@endphp


<div class="book-card" onclick="window.location='{{ route('book.show', $book->id) }}'">

    <div class="book-card-img-wrapper">
        <img src="{{ $src }}" alt="{{ $title }}" class="book-card-img">

        @if(!$isOwner && auth()->check())
            <button class="heart-floating"
                    onclick="event.stopPropagation(); toggleWishlist({{ $book->id }}, this)">
                <img src="{{ $isFav ? asset('img/heart1.png') : asset('img/hollowheart.png') }}"
                     class="heart-icon">
            </button>
        @endif
    </div>

    <div class="book-text">
        <div class="book-author">{{ $author }}</div>
        <div class="book-title">{{ $title }}</div>
    </div>

    <div class="book-bottom">

        @if($book->is_sold)
        <div class="sold-badge">SOLD</div>
        @endif

        <div class="book-price">₱ {{ number_format($price, 2) }}</div>

        <div class="book-actions">
            @if(!$isOwner && auth()->check())
                <a href="/messages/start/{{ $book->user->id }}?book_id={{ $book->id }}"
                   class="chat-btn"
                   onclick="event.stopPropagation();">
                    <img class="chat-icon" src="{{ asset('img/chat2.png') }}">
                    Chat
                </a>
            @else
                <a class="chat-btn invisible-chat">
                    <img class="chat-icon" src="{{ asset('img/chat2.png') }}">
                    Chat
                </a>
            @endif
        </div>

    </div>

</div>
