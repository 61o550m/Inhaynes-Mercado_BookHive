@extends('layouts.app')

@section('content')
@php
    $books = collect($books);
@endphp

<section class="hero full-bleed">
    
    <h1 class="hero-title">
        <span>Welcome, {{ Auth::user()->name }}!</span>
    </h1>

    <h1 class="hero-title1">Your Campus Book Listing Space</h1>

    <p class="hero-sub">Browse listings, explore genres, and see what's trending among students.</p>

    <div class="big-search-container">
        <div class="big-search">
            <input 
                type="text" 
                class="dashboard-search-input"
                placeholder="Search books, authors, genres..."
            >
            <button class="big-search-btn">Search</button>
        </div>
    </div>
</section>

<div class="yellow-separator"></div>

<section>
            <h2 class="section-title">Recommended For You</h2>
    <div class="section-wrapper">

        @if($books->count() === 0)

            <p class="genre-empty">No recommendations yet.</p>

        @else

        <div class="carousel-container">

            <button class="carousel-btn left" onclick="carouselPrev(this)">
                <img src="{{ asset('img/arrowleft.png') }}">
            </button>

            <div class="carousel-track">
                @foreach($books as $book)
                    <div class="carousel-item">
                        <x-book-card 
                            :book="$book"
                            :img="json_decode($book->photos)[0] ?? null"

                            :title="$book->title"
                            :author="$book->author"
                            :price="$book->price"
                        />
                    </div>
                @endforeach
            </div>

            <button class="carousel-btn right" onclick="carouselNext(this)">
                <img src="{{ asset('img/arrowright.png') }}">
            </button>

        </div>

        @endif

    </div>
</section>

<div class="yellow-separator"></div>

<section>
            <h2 class="section-title">New Arrivals</h2>
    <div class="section-wrapper">

        <div class="carousel-container">

            <button class="carousel-btn left" onclick="carouselPrev(this)">
                <img src="{{ asset('img/arrowleft.png') }}">
            </button>

            <div class="carousel-track">
                @foreach($books as $book)
                    <div class="carousel-item">
                        @include('components.book-card', [
                            'img' => $book->thumbnail,
                            'author' => $book->author,
                            'title' => $book->title,
                            'price' => $book->price,
                            'book' => $book
                        ])
                    </div>
                @endforeach
            </div>

            <button class="carousel-btn right" onclick="carouselNext(this)">
                <img src="{{ asset('img/arrowright.png') }}">
            </button>

        </div>

    </div>
</section>

<div class="yellow-separator"></div>

@foreach($genres as $genre)
@include('components.section-genre', [
    'title' => $genre,
    'genreBooks' => \App\Models\Book::where('genre', $genre)->get()
])

@endforeach

@endsection
