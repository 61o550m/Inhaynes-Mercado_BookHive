@extends('layouts.app')

@section('content')

<h1 class="sell-title">Sell Your Books</h1>

<div class="sell-layout">

    <div class="sell-left empty-state">

        <img src="{{ asset('img/logo.png') }}" class="empty-logo" style="width:80px; margin:auto;">

        <h2 style="margin-top: 15px; text-align:center;">List a Book for Sale</h2>

        <p style="color:#444; margin-top: 6px; text-align:center;">
            Turn your books into honey! <br>
            Share your collection with the FEUC community.
        </p>

        <a href="{{ route('books.create') }}" style="display:flex; justify-content:center; margin-top:20px;">
            <button class="start-selling-btn" style="display:flex; align-items:center; gap:8px;">
                <span style="font-size:18px; font-weight:bold;">+</span> 
                Start Selling
            </button>
        </a>

    </div>

    <div class="sell-right sell-form">

        <h3 style="margin-bottom:20px;">Your Listings ({{ $books->count() }})</h3>

 @foreach($books as $book)
<div class="listing-item" style="display:flex; gap:15px; align-items:center;">

    @if($book->thumbnail)
        <img src="{{ asset('storage/' . $book->thumbnail) }}"
             style="width:65px; height:auto; border-radius:6px;">
    @endif

<div style="flex:1;">
    <p style="font-weight:700; margin:0;">{{ $book->title }}</p>
    <p style="color:#777; margin:0; font-size:14px;">{{ $book->author }}</p>

    <div style="margin:6px 0; display:flex; gap:6px;">
        <span style="background:#FFE8A3; color:#A46B07; padding:4px 10px; border-radius:12px; font-size:12px;">
            {{ $book->genre }}
        </span>

        <span style="background:#D9F3FF; color:#0088C6; padding:4px 10px; border-radius:12px; font-size:12px;">
            {{ $book->condition }}
        </span>
    </div>

    <p style="color:#F9B200; font-weight:700; margin:0;">₱{{ $book->price }}</p>
</div>

    <div style="display:flex; flex-direction:column; gap:6px;">

        <a href="{{ route('books.edit', $book->id) }}"
           style="padding:6px 12px; background:#FFC107; border-radius:6px;
                  color:white; font-size:14px; text-align:center;">
            Edit
        </a>

        <form action="{{ route('books.destroy', $book->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit"
                style="padding:6px 12px; background:#E53935; border:none;
                       border-radius:6px; color:white; font-size:14px;">
                Delete
            </button>
        </form>
    </div>

</div>
@endforeach

    </div>

</div>

@endsection
