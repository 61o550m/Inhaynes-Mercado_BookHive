@extends('layouts.app')

@section('content')

<div style="
    max-width:700px;
    margin:30px auto;
    text-align:center;
    padding:0 20px;
">

    <div style="margin-bottom:10px;">
        <div class="avatar"
            style="
                width:110px; height:110px; border-radius:50%;
                background-image:url('{{ $seller->avatar ? asset("storage/$seller->avatar") : asset("img/default-avatar.png") }}');
                background-size:cover; background-position:center;
                border:2px solid #F9B200;
                margin:0 auto;
            ">
        </div>
    </div>

    <h2 style="font-size:22px; margin-bottom:3px;">{{ $seller->name }}</h2>
    <p style="color:#666; margin:0; font-size:14px;">{{ $seller->email }}</p>

    @if($seller->phone)
        <p style="color:#666; margin:2px 0 6px; font-size:14px;">
            📞 {{ $seller->phone }}
        </p>
    @endif

    <div style="color:#FFD700; font-size:16px; margin:4px 0;">
        ★★★★★ <span style="color:#444; font-size:13px;">(45)</span>
    </div>

    <div style="
        display:flex;
        justify-content:center;
        gap:40px;
        margin:12px 0 18px;
    ">
        <div>
            <h3 style="margin:0; font-size:20px;">{{ $books->count() }}</h3>
            <span style="color:#777; font-size:12px;">Books Listed</span>
        </div>

        <div>
            <h3 style="margin:0; font-size:20px;">{{ $followers }}</h3>
            <span style="color:#777; font-size:12px;">Followers</span>
        </div>
    </div>

    <div style="
        display:flex;
        justify-content:center;
        gap:14px;
        margin-bottom:18px;
    ">

        @if(auth()->id() !== $seller->id)
        <button
            style="
                background:#F9B200;
                padding:8px 22px;
                border-radius:10px;
                color:white;
                font-weight:600;
                font-size:14px;
                border:none;
                cursor:pointer;
            ">
            Follow
        </button>
        @endif

        <a href="/messages/start/{{ $seller->id }}"
           style="
                background:#ffffff;
                padding:8px 15px;
                border-radius:10px;
                color:#444444;
                font-weight:600;
                font-size:14px;
                cursor:pointer;
                border: 2px solid #000000;
           ">
            <img src="{{ asset('img/chat.png') }}" style="width:20px;">
            Chat
        </a>

    </div>

    <div style="max-width:600px; margin:0 auto 25px;">
        <p style="
            color:#444;
            line-height:1.6;
            font-size:14px;
            margin:0;
        ">
            {{ $seller->bio ?? "This seller has not added a bio yet." }}
        </p>
    </div>

</div>

<div style="
    max-width:1100px;
    margin:0 auto 20px;
    padding:0 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
">
    <h2 style="font-size:28px; margin:0;">Books Listed</h2>
</div>

<div class="book-row" style="
    max-width:1100px;
    margin:0 auto;
    padding:0 40px;
    display:flex;
    flex-wrap:wrap;
    gap:25px;
    justify-content:flex-start;
">
    @foreach($books as $book)
        @include('components.book-card', [
            'book' => $book,
            'img' => $book->thumbnail,
            'author' => $book->author,
            'title' => $book->title,
            'price' => $book->price,
        ])
    @endforeach
</div>

@endsection
