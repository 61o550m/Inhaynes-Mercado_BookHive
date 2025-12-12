@extends('layouts.app')

@section('content')

<div class="chat-container">

    {{-- LEFT SIDEBAR — SAME AS INDEX --}}
    <div class="chat-inbox">
        <div class="inbox-header"><h3>Inbox</h3></div>

        <div class="inbox-list">
            @foreach ($threads as $thread)
                <a href="{{ route('messages.room', $thread->id) }}"
                   class="inbox-item {{ $thread->id == $roomId ? 'active' : '' }}">
                    <div class="inbox-avatar">{{ strtoupper(substr($thread->otherUser->name, 0, 1)) }}</div>
                    <div class="inbox-info">
                        <strong>{{ $thread->otherUser->name }}</strong><br>
                        <span>{{ $thread->book->title }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>


    {{-- RIGHT SIDE — ACTIVE CHAT --}}
    <div class="chat-main">

        {{-- HEADER --}}
        <div class="chat-header">
            <div class="chat-header-left">
                <div class="chat-avatar">{{ strtoupper(substr($otherUser->name, 0, 1)) }}</div>
                <div>
                    <strong>{{ $otherUser->name }}</strong><br>
                    <span style="color:#888; font-size:12px;">Online today</span>
                </div>
            </div>

            <div class="chat-header-right">
                <strong>{{ $book->title }}</strong><br>
                <span>₱{{ number_format($book->price, 2) }}</span>
            </div>
        </div>

        {{-- MESSAGES --}}
        <div class="chat-messages" id="chatMessages"></div>

        {{-- INPUT BAR --}}
        <div class="chat-input-bar">
            <input type="text" id="messageInput" placeholder="Type a message..." class="chat-input">
            <button onclick="sendMessage({{ $roomId }})" class="chat-send-btn">➤</button>
        </div>

    </div>

</div>

{{-- REAL-TIME MESSAGE POLLING --}}
<script>
function loadMessages() {
    fetch("/chat/fetch/{{ $roomId }}")
        .then(res => res.json())
        .then(messages => {
            let box = document.getElementById('chatMessages');
            box.innerHTML = "";

            messages.forEach(msg => {
                let div = document.createElement('div');
                div.className = "chat-message-row " + (msg.sender_id == {{ auth()->id() }} ? 'me' : 'them');

                div.innerHTML = `
                    <div class="chat-bubble">
                        ${msg.message}
                        <div class="chat-time">${msg.created_at}</div>
                    </div>
                `;
                box.appendChild(div);
            });

            box.scrollTop = box.scrollHeight;
        });
}

// Refresh every 1.5s
setInterval(loadMessages, 1500);
loadMessages();

function sendMessage(roomId) {
    const message = document.getElementById('messageInput').value;
    if (!message.trim()) return;

    fetch("/chat/send", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ room_id: roomId, message })
    }).then(() => {
        document.getElementById('messageInput').value = "";
        loadMessages();
    })
}
</script>

@endsection
