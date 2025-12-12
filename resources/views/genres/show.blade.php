@extends('layouts.app')

@section('content')

<div class="genre-banner">
    <div class="genre-text">
        <h2>{{ $genre }}</h2>
        <p>{{ $description }}</p>
    </div>

    <div class="genre-image">
        <img src="{{ asset($image) }}" alt="{{ $genre }}">
    </div>
</div>


<div class="genre-controls">
    <p class="results-count">{{ $books->count() }} listings found</p>

    <div class="filter-container">
        <button class="filter-btn" onclick="toggleFilter()">Filter</button>

        <form id="filterBox" class="filter-box" method="GET">

            <label>Condition</label>
            <select name="condition">
                <option value="">All</option>
                <option value="New" {{ $request->condition=='New' ? 'selected' : '' }}>New</option>
                <option value="Like New" {{ $request->condition=='Like New' ? 'selected' : '' }}>Like New</option>
                <option value="Used" {{ $request->condition=='Used' ? 'selected' : '' }}>Used</option>
                <option value="Acceptable" {{ $request->condition=='Acceptable' ? 'selected' : '' }}>Acceptable</option>
            </select>

            <label>Sort</label>
            <select name="sort">
                <option value="">None</option>
                <option value="low-high" {{ $request->sort=='low-high' ? 'selected':'' }}>Price: Low to High</option>
                <option value="high-low" {{ $request->sort=='high-low' ? 'selected':'' }}>Price: High to Low</option>
                <option value="latest" {{ $request->sort=='latest' ? 'selected':'' }}>Latest</option>
            </select>

            <button type="submit" class="apply-filter">Apply</button>
        </form>
    </div>
</div>



<div class="genre-books-grid">
    @forelse($books as $book)

        {{-- FIXED: wrapper div (not <a>) so scripts in book-card don't break layout --}}
        <div class="genre-card-wrapper" 
             onclick="window.location='{{ route('book.show', $book->id) }}'">

            @include('components.book-card', [
                'img' => $book->thumbnail,
                'author' => $book->author,
                'title' => $book->title,
                'price' => $book->price,
                'book' => $book
            ])

        </div>

    @empty
        <p>No books found for this genre.</p>
    @endforelse
</div>


<script>
function toggleFilter() {
    const box = document.getElementById("filterBox");
    box.style.display = (box.style.display === "block") ? "none" : "block";
}
</script>

@endsection
