@extends('layouts.app')

@section('content')

<div class="chat-container">

    {{-- LEFT SIDEBAR — INBOX LIST --}}
    <div class="chat-inbox">

        <div class="inbox-header">
            <h3>Inbox</h3>
        </div>

        <div class="inbox-list">
            @foreach ($threads as $thread)
                <a href="{{ route('messages.room', $thread->id) }}" class="inbox-item">
                    <div class="inbox-avatar">{{ strtoupper(substr($thread->otherUser->name, 0, 1)) }}</div>
                    <div class="inbox-info">
                        <strong>{{ $thread->otherUser->name }}</strong><br>
                        <span>{{ $thread->book->title }}</span><br>
                        <small>{{ $thread->lastMessage->message ?? '' }}</small>
                    </div>
                </a>
            @endforeach
        </div>

    </div>

    {{-- RIGHT SIDE — DEFAULT EMPTY SCREEN --}}
    <div class="chat-empty">
        Select a conversation to start chatting.
    </div>

</div>

@endsection
