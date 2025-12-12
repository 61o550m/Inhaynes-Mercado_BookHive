@props(['genreBooks' => [], 'title' => ''])

<div class="genre-section">

    <h2 class="section-title">{{ $title }}</h2>

    <div class="section-wrapper">

        @if(count($genreBooks) === 0)
            <p class="genre-empty">No books in this genre yet.</p>
        @else

        <div class="carousel-container">

            <button class="carousel-btn left" onclick="carouselPrev(this)">
                <img src="{{ asset('img/arrowleft.png') }}">
            </button>

            <div class="carousel-track">

                @foreach ($genreBooks as $book)
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
</div>
<div class="yellow-separator"></div>