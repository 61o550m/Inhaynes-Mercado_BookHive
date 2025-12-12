@extends('layouts.app')

@section('content')

<div class="chat-page">
    <div class="chat-layout">

        {{-- LEFT SIDEBAR – INBOX --}}
        <aside class="chat-sidebar">
            <div class="chat-sidebar-header">
                <span class="chat-sidebar-title">Inbox</span>
                <button class="chat-search-btn">
                    🔍
                </button>
            </div>

            <div class="chat-thread-list">
                @forelse($rooms as $sidebarRoom)
                    @php
                        $youAreUser1 = $sidebarRoom->user1_id == auth()->id();
                        $partner = $youAreUser1 ? $sidebarRoom->user2 : $sidebarRoom->user1;
                    @endphp

                    <a href="{{ route('chat.open', $sidebarRoom->id) }}"
                       class="chat-thread-item {{ $sidebarRoom->id == $room->id ? 'is-active' : '' }}">
                        <div class="chat-thread-avatar">
                            <span>{{ strtoupper(substr($partner->name, 0, 1)) }}</span>
                        </div>

                        <div class="chat-thread-main">
                            <div class="chat-thread-top">
                                <span class="chat-thread-name">{{ $partner->name }}</span>
                                @if($sidebarRoom->book)
                                    <span class="chat-thread-book">{{ $sidebarRoom->book->title }}</span>
                                @endif
                            </div>

                            <div class="chat-thread-bottom">
                                <span class="chat-thread-preview">
                                    {{ optional($sidebarRoom->messages->last())->message ?? 'No messages yet' }}
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="chat-empty-inbox">No conversations yet.</p>
                @endforelse
            </div>
        </aside>

        {{-- RIGHT SIDE – MAIN CHAT --}}
        <section class="chat-main">

            {{-- TOP HEADER: USER + BOOK + MAKE OFFER --}}
            <header class="chat-main-header">
                <div class="chat-header-left">
                    <div class="chat-header-avatar">
                        <span>{{ strtoupper(substr($otherUser->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <div class="chat-header-name">{{ $otherUser->name }}</div>
                        <div class="chat-header-status">Online today</div>
                    </div>
                </div>

                @if($room->book)
                    <div class="chat-book-card">
                        <div class="chat-book-thumb">
                            @if($room->book->thumbnail)
                                <img src="{{ asset('storage/'.$room->book->thumbnail) }}"
                                     alt="{{ $room->book->title }}">
                            @else
                                <img src="{{ asset('img/default-book.png') }}" alt="Book">
                            @endif
                        </div>
                        <div class="chat-book-details">
                            <div class="chat-book-title">{{ $room->book->title }}</div>
                            <div class="chat-book-price">₱ {{ number_format($room->book->price, 2) }}</div>
                        </div>
                        <div class="chat-book-actions">
                            <a href="{{ route('book.show', $room->book->id) }}" class="view-book-link">
                                View book
                            </a>
                            <button class="make-offer-btn">Make offer</button>
                        </div>
                    </div>
                @endif
            </header>

            {{-- MESSAGES AREA --}}
            <div id="chatMessages" class="chat-messages">
                @foreach($room->messages as $message)
                    <div class="chat-message-row {{ $message->sender_id == auth()->id() ? 'me' : 'them' }}">
                        <div class="chat-bubble">
                            <p>{{ $message->message }}</p>
                            <span class="chat-time">
                                {{ $message->created_at->format('g:i A') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- INPUT BAR --}}
            <footer class="chat-input-bar">
                <input id="messageBox"
                       type="text"
                       class="chat-input"
                       placeholder="Type a message here..."
                       onkeydown="if(event.key === 'Enter'){ event.preventDefault(); sendMessage(); }">

                <button type="button" class="chat-plus-btn">＋</button>
            </footer>
        </section>

    </div>
</div>

{{-- ============================= --}}
{{--  REAL-TIME JS (POLLING)      --}}
{{-- ============================= --}}
<script>
    const authUserId = {{ auth()->id() }};
    const roomId = {{ $room->id }};

    function escapeHtml(text) {
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;");
    }

    function renderMessages(items) {
        const container = document.getElementById('chatMessages');
        container.innerHTML = '';

        items.forEach(msg => {
            const row = document.createElement('div');
            row.className = 'chat-message-row ' + (msg.sender_id === authUserId ? 'me' : 'them');

            const bubble = document.createElement('div');
            bubble.className = 'chat-bubble';

            const p = document.createElement('p');
            p.innerHTML = escapeHtml(msg.message);

            const time = document.createElement('span');
            const dateObj = new Date(msg.created_at);
            time.className = 'chat-time';
            time.textContent = dateObj.toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'});

            bubble.appendChild(p);
            bubble.appendChild(time);
            row.appendChild(bubble);
            container.appendChild(row);
        });

        container.scrollTop = container.scrollHeight;
    }

    function refreshMessages() {
        fetch("{{ route('chat.fetch', $room->id) }}")
            .then(res => res.json())
            .then(data => renderMessages(data))
            .catch(err => console.error(err));
    }

    // 🔁 THIS IS WHERE YOUR setInterval GOES
    setInterval(refreshMessages, 1500);
    refreshMessages(); // initial load

    // 🚀 sendMessage() also lives here
    function sendMessage() {
        const input = document.getElementById('messageBox');
        const text = input.value.trim();
        if (!text) return;

        fetch("{{ route('chat.send') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded;charset=UTF-8",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: new URLSearchParams({
                room_id: roomId,
                message: text
            })
        })
            .then(() => {
                input.value = '';
                refreshMessages();
            })
            .catch(err => console.error(err));
    }
</script>

@endsection
