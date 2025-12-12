<nav class="navbar">
    <div class="navbar-inner">

<div class="nav-left">

    @auth
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('img/logo.png') }}" class="nav-logo">
        </a>
    @endauth

    @guest
        <a href="{{ route('home') }}">
            <img src="{{ asset('img/logo.png') }}" class="nav-logo">
        </a>
    @endguest

</div>

        <div class="search-wrapper">
            <img src="{{ asset('img/magnifying.png') }}" class="search-icon">
            <input type="text" class="searchbar" placeholder="Search books, authors, genres...">
        </div>

        <div class="nav-right">

                    <a href="/sell"
           @guest onclick="event.preventDefault(); openModal('loginModal');" @endguest
           class="sell-btn">
           Sell Your Books
        </a>

@auth
    <a href="{{ route('wishlist') }}">
        <img src="{{ asset('img/heart.png') }}" class="icon-btn">
    </a>
@endauth

@guest
    <img src="{{ asset('img/heart.png') }}" 
         class="icon-btn" 
         onclick="openModal('loginModal')">
@endguest

            @guest
                <button class="signin-btn" onclick="openModal('loginModal')">
                    Sign in
                </button>
            @endguest

            @auth

<a href="{{ route('messages.index') }}">
    <img src="{{ asset('img/chat.png') }}" class="icon-btn">
</a>

                <div class="dropdown">
                    <img src="{{ asset('img/profileicon2.png') }}" class="icon-btn profile-btn">

                    <div class="dropdown-menu profile-menu">
                        <a href="{{ route('user.profile', Auth::id()) }}">My Profile</a>

                        <a href="{{ route('deals.index') }}">Deal History</a>

                        <a href="#">Settings</a>

                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    </div>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            @endauth

        </div>
    </div>

    <div class="genre-bar">

<a href="{{ route('genre.show', 'fiction') }}">Fiction</a>
<a href="{{ route('genre.show', 'fantasy') }}">Fantasy</a>
<a href="{{ route('genre.show', 'romance') }}">Romance</a>
<a href="{{ route('genre.show', 'education') }}">Education</a>
<a href="{{ route('genre.show', 'science-fiction') }}">Science Fiction</a>
<a href="{{ route('genre.show', 'non-fiction') }}">Non-Fiction</a>

    <div class="dropdown">
        <a class="more-genres-btn">
            More Genres <span class="arrow">▾</span>
        </a>

        <div class="dropdown-menu genre-menu">
            <a href="{{ route('genre.show', 'horror') }}">Horror</a>
            <a href="{{ route('genre.show', 'manga') }}">Manga</a>
            <a href="{{ route('genre.show', 'mystery') }}">Mystery</a>
            <a href="{{ route('genre.show', 'historical') }}">Historical</a>
        </div>
    </div>

</div>

</nav>
