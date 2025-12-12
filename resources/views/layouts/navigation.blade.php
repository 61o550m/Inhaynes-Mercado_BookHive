<nav class="main-navbar">

    <div class="nav-left">
        <a href="/">
            <img src="/images/logo.png" class="logo">
        </a>
    </div>

    <div class="nav-center">
        <form action="/search" method="GET">
            <input type="text" name="q" class="search-bar"
                placeholder="Search books, authors, genres...">
        </form>
    </div>

    <div class="nav-right">

        <a href="/sell"
           @guest onclick="event.preventDefault(); openModal('loginModal');" @endguest
           class="sell-btn">
           Sell Your Books
        </a>

        <a href="/favorites"
           @guest onclick="event.preventDefault(); openModal('loginModal');" @endguest>
            <img src="/images/heart.png" class="nav-icon">
        </a>

        @auth
            <a href="/messages">
                <img src="/images/chat.png" class="nav-icon">
            </a>

            <div class="profile-wrapper">
                <img src="/images/profileicon.png"
                     class="nav-icon profile-icon"
                     id="profileToggle">

                <div class="profile-dropdown" id="profileDropdown">
                    <a href="/profile">My Profile</a>
                    <a href="/history">Deal History</a>
                    <a href="/settings">Settings</a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button>Logout</button>
                    </form>
                </div>
            </div>
        @endauth

        @guest
            <a onclick="openModal('loginModal')" class="signin-btn">Sign In</a>
        @endguest

    </div>

</nav>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const toggle = document.getElementById("profileToggle");
    const dropdown = document.getElementById("profileDropdown");

    toggle?.addEventListener("click", () => 
        dropdown.classList.toggle("show")
    );

    document.addEventListener("click", (e) => {
        if (!toggle?.contains(e.target) && !dropdown?.contains(e.target)) {
            dropdown?.classList.remove("show");
        }
    });
});
</script>
