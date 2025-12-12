@extends('layouts.app')

@section('content')

<div class="preview-container">

    <div class="preview-left">
        <div class="preview-img-box">
            <img src="{{ asset('storage/' . $book->thumbnail) }}" class="preview-img">
        </div>

        <div class="preview-actions">
            <button onclick="toggleWishlist({{ $book->id }}, this)">
                <img src="{{ asset($isFav ? 'img/heart1.png' : 'img/hollowheart.png') }}">
            </button>

            <button onclick="shareBook('{{ route('book.show', $book->id) }}')">
                <img src="{{ asset('img/share.png') }}">
            </button>

            <button onclick="reportListing({{ $book->id }})">
                <img src="{{ asset('img/flag.png') }}">
            </button>
        </div>
    </div>

    <div class="preview-right">

        <div class="info-box">

            <h1 class="preview-title">{{ $book->title }}</h1>
            <p class="preview-author">{{ $book->author }}</p>

            <div class="preview-price">₱{{ number_format($book->price, 2) }}</div>

            @if(Auth::check())
                @if(auth()->id() !== $book->user->id)
                    <a href="/messages/start/{{ $book->user->id }}?book_id={{ $book->id }}"
                       class="preview-chat-btn">
                       Chat
                    </a>
                @endif
            @else
                <button class="preview-chat-btn" onclick="openModal('loginModal')">
                    Chat
                </button>
            @endif

            <div class="seller-card">

                <a href="{{ route('seller.profile', ['id' => $book->user_id]) }}"
                   class="seller-left"
                   style="text-decoration:none; color:inherit; display:flex; align-items:center; gap:12px;">

                    <div class="seller-avatar"
                        style="background-image:url('{{ $seller->avatar ? asset("storage/".$seller->avatar) : asset("img/default-avatar.png") }}')">
                    </div>

                    <div>
                        <div class="seller-name">{{ $seller->name }}</div>
                        <div class="seller-status">Active Today</div>
                    </div>

                </a>

                @if(auth()->id() !== $seller->id)
                    <button class="seller-follow">Follow</button>
                @endif

            </div>

        </div>

    </div>

</div>

<div class="details-section">

    <div class="details-card">
        <h2>Product Details</h2>

        <p><strong>Category:</strong> {{ $book->genre }}</p>
        <p><strong>Condition:</strong> {{ $book->condition }}</p>
        <p><strong>Listed:</strong> {{ $book->created_at->diffForHumans() }}</p>
        <p><strong>Views:</strong> {{ $book->views }}</p>
        <p><strong>Wishes:</strong> {{ $wishlistCount }}</p>

        <h2>Description</h2>
        <p class="desc-text">{!! nl2br(e($book->description)) !!}</p>
    </div>

</div>

<h2 class="more-title">More From This Seller</h2>

<div class="more-row">

@foreach($relatedBooks as $r)
@include('components.book-card', [
    'book' => $r,
    'img' => $r->thumbnail,
    'author' => $r->author,
    'title' => $r->title,
    'price' => $r->price
])

@endforeach

</div>

<script>
function toggleWishlist(bookId, btn) {
    const img = btn.querySelector("img");
    img.src = img.src.includes("hollowheart")
        ? "{{ asset('img/heart1.png') }}"
        : "{{ asset('img/hollowheart.png') }}";

    fetch("/wishlist/toggle/" + bookId, {
        method: "POST",
        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
    });
}

function shareBook(url) {
    navigator.clipboard.writeText(url);
    alert("Link copied!");
}

function reportListing(id) {
    if (!confirm("Report this listing?")) return;

    fetch("/report/" + id, {
        method: "POST",
        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
    });

    alert("Listing reported.");
}
</script>

@endsection
