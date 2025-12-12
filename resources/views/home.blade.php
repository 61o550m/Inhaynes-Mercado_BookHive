

@extends($layout ?? 'layouts.app')

@section('content')

<section class="hero full-bleed">


    <div style="padding-top:20px;"></div>
    <h1 class="hero-title"><span>Buzz</span> into Your Next <br> Literary Adventure</h1>
    <p class="hero-sub">Welcome to Bookhive – where every book finds its perfect reader. Discover, collect, and share your literary treasures in our buzzing community of book lovers.</p>

    <div class="big-search-container">
        <div class="big-search">
            <input type="text" placeholder="Search books, authors, genres...">
            <button class="big-search-btn">Search</button>
        </div>
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

{{-- GENRE SECTIONS (always show) --}}
{{-- GENRE SECTIONS (always show) --}}
@foreach($genres as $genre)
    @include('components.section-genre', [
        'title' => $genre,
        'books' => \App\Models\Book::where('genre', $genre)->get()
    ])
@endforeach



<script>
document.addEventListener("DOMContentLoaded", function () {

    const CARD_WIDTH = 270;  // card width + gap
    const SCROLL_BY = CARD_WIDTH * 2;  // scroll 2 cards at a time

    // Apply to all carousels
    document.querySelectorAll('.genre-carousel-wrapper, .na-carousel-wrapper')
        .forEach(wrapper => {

        const track = wrapper.querySelector('.genre-carousel-track, .na-carousel-track');
        const left = wrapper.querySelector('.genre-carousel-arrow.left, .na-carousel-arrow.left');
        const right = wrapper.querySelector('.genre-carousel-arrow.right, .na-carousel-arrow.right');

        if (!track || !left || !right) return;

        // If cards <= 4, hide both arrows
        let itemCount = track.children.length;
        if (itemCount <= 4) {
            left.classList.add('carousel-arrow-disabled');
            right.classList.add('carousel-arrow-disabled');
            return;
        }

        const updateArrows = () => {
            // Fade left arrow when at start
            if (track.scrollLeft <= 5) {
                left.classList.add('carousel-arrow-disabled');
            } else {
                left.classList.remove('carousel-arrow-disabled');
            }

            // Fade right arrow when fully scrolled to end
            let maxScroll = track.scrollWidth - track.clientWidth - 5;
            if (track.scrollLeft >= maxScroll) {
                right.classList.add('carousel-arrow-disabled');
            } else {
                right.classList.remove('carousel-arrow-disabled');
            }
        };

        // Initial state
        updateArrows();

        // Arrow actions
        right.addEventListener("click", () => {
            track.scrollLeft += SCROLL_BY;
            setTimeout(updateArrows, 200);
        });

        left.addEventListener("click", () => {
            track.scrollLeft -= SCROLL_BY;
            setTimeout(updateArrows, 200);
        });

        // Update arrows when user scrolls manually
        track.addEventListener("scroll", updateArrows);

    });

});
</script>


@endsection
