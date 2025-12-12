@extends('layouts.app')

@section('content')

<div class="chat-container">

    <div class="chat-sidebar">

        <div class="chat-sidebar-header">
            <div class="chat-sidebar-title">Inbox</div>
            <button class="chat-search-btn">
                <img src="/img/magnifying.png" alt="search" style="width:18px; height:18px;">
            </button>
        </div>

        <div class="chat-thread-list">
            @forelse ($rooms as $room)

                @php
                    $partner = $room->user1_id == auth()->id() ? $room->user2 : $room->user1;
                @endphp

                <a href="{{ route('messages.room', $room->id) }}"
                   class="chat-thread-item {{ $currentRoom && $currentRoom->id == $room->id ? 'is-active' : '' }}">

                    <div class="chat-thread-avatar"
                        style="background-image:url('{{ $partner->avatar ? asset("storage/$partner->avatar") : asset("img/default-avatar.png") }}');
                               background-size:cover; background-position:center;">
                    </div>

                    <div class="chat-thread-info">
                        <div class="chat-thread-name">{{ $partner->name }}</div>
                        <div class="chat-thread-book">{{ optional($room->book)->title ?? 'No book linked' }}</div>
                        <div class="chat-thread-latest">{{ optional($room->messages->last())->message ?? '' }}</div>
                    </div>

                </a>
            @empty
                <div class="chat-empty-inbox">No messages yet.</div>
            @endforelse
        </div>

    </div>

    <div class="chat-main">

        @if(!$currentRoom)
            <div class="chat-empty-state">Select a conversation to start chatting.</div>
        @else

        @php
            $book   = optional($currentRoom->book);
            $buyer  = $currentRoom->user1_id == auth()->id()
                        ? $currentRoom->user2_id
                        : $currentRoom->user1_id;

            $roomId = $currentRoom->id;

            $latestOffer = $currentRoom->messages()->where('type', 'offer')->latest()->first();
            $accepted = $currentRoom->messages()->where('type', 'accepted')->latest()->first();
        @endphp

        <script>
            window.CHAT_ROOM_ID  = {{ $roomId }};
            window.CHAT_USER_ID  = {{ auth()->id() }};
            window.CHAT_BOOK_ID  = {{ $book->id ?? 'null' }};
            window.CHAT_BUYER_ID = {{ $buyer }};
        </script>

        <div class="chat-main-header">
            <div class="chat-header-left">

                <div class="chat-avatar"
                    style="background-image:url('{{ $otherUser->avatar ? asset("storage/$otherUser->avatar") : asset("img/default-avatar.png") }}');
                           background-size:cover; background-position:center;">
                </div>

                <div>
                    <div class="chat-name">{{ $otherUser->name }}</div>
                    <div class="chat-status">Online today</div>
                </div>

            </div>
        </div>

        <div class="offer-summary-row">

            <div class="offer-book-left">
                @if($book && $book->thumbnail)
                    <img class="offer-book-thumb" src="{{ asset('storage/' . $book->thumbnail) }}">
                @endif

                <div>
                    <div class="offer-book-title">{{ $book->title }}</div>
                    <div class="offer-book-price">₱ {{ number_format($book->price, 2) }}</div>
                </div>
            </div>

@if($book)

    @if(auth()->id() !== $book->user_id)

        @if($accepted)
            <button class="make-offer-btn small-offer-btn" style="background:#F9B200;">
                Leave Review
            </button>
        @else
            <button id="makeOfferBtn" class="make-offer-btn small-offer-btn">
                Make Offer
            </button>
        @endif

    @else
        @if($latestOffer && !$accepted)
<button class="make-offer-btn small-offer-btn"
        onclick="event.stopPropagation(); acceptOffer(window.CHAT_ROOM_ID, {{ $latestOffer->offer_price }})">
    Accept Offer
</button>

        @endif
    @endif

@endif

        </div>

        @if(!$accepted)
        <div id="offerInputBox" style="display:none; padding:14px;">
            <input id="offerAmount" type="number" placeholder="₱ Enter amount"
                style="padding:8px; border-radius:8px; border:2px solid #F9B200;">
            <button type="button" onclick="sendOffer(window.CHAT_ROOM_ID)" class="make-offer-btn">Send</button>
            <button type="button" onclick="cancelOfferInput()" class="cancel-btn">Cancel</button>
        </div>
        @endif

        <div class="chat-messages" id="chatMessages"></div>

        <div class="chat-input-wrapper">
            <input type="text" id="messageInput" class="chat-input" placeholder="Type a message here…">
            <button type="button" class="chat-plus-btn" onclick="sendMessage(window.CHAT_ROOM_ID)">➤</button>
        </div>

        @endif
    </div>

</div>

@if($currentRoom)
<script>
function acceptOffer(roomId, amount) {

    fetch("/chat/accept-offer", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            room_id: roomId,
            offer_price: amount,
            buyer_id: window.CHAT_BUYER_ID,
            book_id: window.CHAT_BOOK_ID
        })
    })
    .then(() => {
        loadMessages();
        location.reload();
    });
}

function loadMessages() {
    fetch("/chat/fetch/" + window.CHAT_ROOM_ID)
        .then(res => res.json())
        .then(messages => {
            const box = document.getElementById("chatMessages");
            if (!box) return;

            box.innerHTML = "";

            messages.forEach(msg => {
                let cls = msg.sender_id == window.CHAT_USER_ID ? "me" : "them";
                let html = "";

                if (msg.type === "offer") {
                    html = `
                        <div class="chat-msg-row ${cls}">
                            <div class="chat-bubble offer-bubble">
                                Offered ₱${msg.offer_price}
                            </div>
                        </div>`;
                }
                else if (msg.type === "accepted") {
                    html = `
                        <div class="chat-msg-row ${cls}">
                            <div class="chat-bubble" style="background:#F9B200;color:white;">
                                Accepted offer ₱${msg.offer_price}
                            </div>
                        </div>`;
                }
                else {
                    html = `
                        <div class="chat-msg-row ${cls}">
                            <div class="chat-bubble">${msg.message}</div>
                        </div>`;
                }

                box.innerHTML += html;
            });

const shouldAutoScroll =
    box.scrollTop + box.clientHeight >= box.scrollHeight - 50;

if (shouldAutoScroll) {
    box.scrollTop = box.scrollHeight;
}

        });
}

setInterval(loadMessages, 1000);
loadMessages();

document.getElementById("makeOfferBtn")?.addEventListener("click", () => {
    document.getElementById("offerInputBox").style.display = "block";
    document.getElementById("makeOfferBtn").style.display = "none";
});

function cancelOfferInput() {
    document.getElementById("offerInputBox").style.display = "none";
    document.getElementById("makeOfferBtn").style.display = "inline-block";
}

function sendMessage(roomId) {
    const text = document.getElementById("messageInput").value;
    if (!text.trim()) return;

    fetch("/chat/send", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            room_id: roomId,
            message: text
        })
    }).then(() => {
        document.getElementById("messageInput").value = "";
        loadMessages();
    });
}

function sendOffer(roomId) {
    const amount = document.getElementById("offerAmount").value;
    if (!amount.trim()) return;

    fetch("/chat/send-offer", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            room_id: roomId,
            offer_price: amount
        })
    }).then(() => {
        cancelOfferInput();
        loadMessages();
    });
}

</script>
@endif

<style>

.offer-summary-row {
    background: #FFF6D8;
    padding: 16px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #F1DCA5;
}

.offer-book-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.offer-book-thumb {
    width: 55px;
    height: 72px;
    border-radius: 10px;
    object-fit: cover;
}

.small-offer-btn {
    padding: 8px 18px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: bold;
}

.offer-bubble {
    background: #FFF6D8 !important;
    color: #000 !important;
    border: 1px solid #E7D8A5;
    font-weight: 600;
}

.chat-container {
    height: calc(100vh - 80px);
    display: flex;
}

.chat-main {
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 0;
}

.chat-messages {
    flex: 1;
    overflow-y: auto;
}

.chat-msg-row .chat-bubble:not(.offer-bubble) {
    background: #ffffff !important;
    color: #000 !important;
    border: 1px solid #dadada !important;
    box-shadow: 0 3px 6px rgba(0,0,0,0.12);
    border-radius: 16px;
    padding: 10px 14px;
}

.offer-bubble {
    background: #FFF6D8 !important;
    color: #000 !important;
    border: 1px solid #E7D8A5 !important;
    box-shadow: none !important;
}

.chat-msg-row .chat-bubble.accepted-offer {
    background: #F9B200 !important;
    color: #fff !important;
}

</style>

@endsection
