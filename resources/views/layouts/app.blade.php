<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bookhive</title>

    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body class="bg-[#FFFBEF] font-sans antialiased">

    {{-- SUCCESS TOAST --}}
    <div id="toast-success" 
        style="
            display:none;
            position:fixed;
            top:50px;
            left:50%;
            transform:translateX(-50%);
            background:#F9B200;
            color:white;
            padding:14px 22px;
            border-radius:12px;
            font-size:15px;
            box-shadow:0 4px 12px rgba(0,0,0,0.2);
            z-index:999999;
            opacity:0;
            transition:opacity .4s ease;
            pointer-events: none !important;
">
    </div>


    {{-- NAVBAR + MODALS --}}
    @include('components.navbar')
    @include('components.modals')

 {{-- PAGE CONTENT --}}
<main style="padding-top: 150px; padding-left: 40px; padding-right: 40px;">
    @yield('content')
</main>


    {{-- FOOTER --}}
    <div class="px-[40px]">
        @include('components.footer')
    </div>

    {{-- GLOBAL JS --}}
    <script>
        function openModal(id) {
            document.getElementById(id).style.display = "flex";
        }

        function closeModal(id) {
            document.getElementById(id).style.display = "none";
        }


        function showToast(message) {
            const toast = document.getElementById("toast-success");
            toast.textContent = message;
            toast.style.display = "block";

            setTimeout(() => toast.style.opacity = 1, 50);

            setTimeout(() => {
                toast.style.opacity = 0;
                setTimeout(() => toast.style.display = "none", 400);
            }, 3000);
        }
 window.toggleWishlist = function (bookId, btn) {
        const img = btn.querySelector("img");

        // Update UI
        if (img.src.includes("hollowheart.png")) {
            img.src = "{{ asset('img/heart1.png') }}";
        } else {
            img.src = "{{ asset('img/hollowheart.png') }}";
        }

        // Save to server
        fetch("/wishlist/toggle/" + bookId, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Accept": "application/json"
            },
            credentials: "same-origin"
        }).then(r => r.json())
          .then(data => console.log("Saved:", data))
          .catch(err => console.error("Wishlist error:", err));
    }

function carouselNext(button) {
    const container = button.closest(".carousel-container");
    const track = container.querySelector(".carousel-track");
    const cardWidth = container.querySelector(".carousel-item").offsetWidth + 20;

    track.scrollBy({ left: cardWidth * 2, behavior: "smooth" });
    setTimeout(() => updateButtons(container), 200);
}

function carouselPrev(button) {
    const container = button.closest(".carousel-container");
    const track = container.querySelector(".carousel-track");
    const cardWidth = container.querySelector(".carousel-item").offsetWidth + 20;

    track.scrollBy({ left: -cardWidth * 2, behavior: "smooth" });
    setTimeout(() => updateButtons(container), 200);
}

function updateButtons(container) {
    const track = container.querySelector(".carousel-track");
    const leftBtn = container.querySelector(".carousel-btn.left");
    const rightBtn = container.querySelector(".carousel-btn.right");

    // hide left
    if (track.scrollLeft <= 5) {
        leftBtn.style.opacity = "0";
        leftBtn.style.pointerEvents = "none";
    } else {
        leftBtn.style.opacity = "1";
        leftBtn.style.pointerEvents = "auto";
    }

    // hide right
    const maxScroll = track.scrollWidth - track.clientWidth - 5;
    if (track.scrollLeft >= maxScroll) {
        rightBtn.style.opacity = "0";
        rightBtn.style.pointerEvents = "none";
    } else {
        rightBtn.style.opacity = "1";
        rightBtn.style.pointerEvents = "auto";
    }
}

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".carousel-container").forEach(container => {
        updateButtons(container);

        container.querySelector(".carousel-track")
            .addEventListener("scroll", () => updateButtons(container));
    });
});

    </script>

    {{-- SHOW REGISTER SUCCESS --}}
    @if(session('register_success'))
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            showToast("Registered successfully! Please log in.");
            openModal('loginModal');
        });
    </script>
    @endif

    {{-- SHOW LOGIN SUCCESS --}}
    @if(session('login_success'))
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            showToast("Signed in successfully!");
        });
    </script>
    @endif

    {{-- SHOW LOGIN ERROR --}}
    @if(session('login_error'))
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            openModal('loginModal');
        });
    </script>
    @endif

<script>
window.toggleWishlist = function(bookId, btn) {

    const img = btn.querySelector("img");

    const isRemoving = img.src.includes("heart1.png");
    img.src = isRemoving 
        ? "{{ asset('img/hollowheart.png') }}" 
        : "{{ asset('img/heart1.png') }}";

    fetch("/wishlist/toggle/" + bookId, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(data => {

        if (data.removed) {

            // remove the card
            const card = document.getElementById("wishlist-" + bookId);
            if (card) card.remove();

            // check if seller group grid is empty
            const groups = document.querySelectorAll(".seller-group");
            groups.forEach(group => {
                const grid = group.querySelector(".wishlist-grid");

                if (grid && grid.children.length === 0) {
                    group.remove();
                }
            });
        }
    });
};

</script>


</body>
</html>
