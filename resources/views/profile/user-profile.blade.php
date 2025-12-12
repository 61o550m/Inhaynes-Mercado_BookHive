@extends('layouts.app')

@section('content')

{{-- PROFILE WRAPPER --}}
{{-- PROFILE WRAPPER --}}
<div style="
    max-width:700px;
    margin:30px auto;
    text-align:center;
    padding:0 20px;
">

    {{-- AVATAR (smaller) --}}
    <div style="margin-bottom:10px;">
        <div class="avatar"
            style="
                width:110px; height:110px; border-radius:50%;
                background-image:url('{{ $user->avatar ? asset("storage/$user->avatar") : asset("img/default-avatar.png") }}');
                background-size:cover; background-position:center;
                border:2px solid #F9B200;
                margin:0 auto;
            ">
        </div>
    </div>

    {{-- NAME + EMAIL + PHONE (smaller text) --}}
    <h2 style="font-size:22px; margin-bottom:3px;">{{ $user->name }}</h2>
    <p style="color:#666; margin:0; font-size:14px;">{{ $user->email }}</p>

    @if($user->phone)
        <p style="color:#666; margin:2px 0 6px; font-size:14px;">📞 {{ $user->phone }}</p>
    @endif

    {{-- RATING --}}
    <div style="color:#FFD700; font-size:16px; margin:4px 0;">
        ★★★★★ <span style="color:#444; font-size:13px;">(0)</span>
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


    <div style="margin-bottom:18px;">
        <a href="{{ route('myprofile.edit') }}"
           style="
               background:#F9B200;
               padding:8px 22px;
               border-radius:10px;
               color:white;
               font-weight:600;
               font-size:14px;
               display:inline-block;
           ">
           Edit Profile
        </a>
    </div>

    <div style="max-width:600px; margin:0 auto 25px;">
        <p style="color:#444; line-height:1.6; font-size:14px; margin:0;">
            {{ $user->bio ?? "No bio available." }}
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

    <a href="/sell"
       style="
           background:#F9B200;
           padding:10px 24px;
           border-radius:12px;
           color:white;
           font-weight:600;
       ">
       Edit Book Listing
    </a>
</div>


{{-- BOOK GRID (LEFT-ALIGNED LIKE THE OLD DESIGN) --}}
<div class="book-row" style="
    max-width:1100px;
    margin:0 auto;
    padding:0 40px;
    display:flex;
    flex-wrap:wrap;
    gap:25px;
    justify-content:flex-start;
">
    @forelse($books as $book)
        @include('components.book-card', [
            'img' => $book->thumbnail,
            'author' => $book->author,
            'title' => $book->title,
            'price' => $book->price
        ])
    @empty
        <p>No books yet.</p>
    @endforelse
</div>

@endsection
