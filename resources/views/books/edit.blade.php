@extends('layouts.app')

@section('content')

<h1 class="sell-title">Edit Book</h1>

<div class="sell-layout">

    {{-- LEFT PANEL (Edit Form) --}}
    <div class="left-box create-box">

        <div class="create-header">
            <h2>Edit Book Details</h2>
            <a href="{{ route('books.index') }}" class="close-btn">✕</a>
        </div>

        <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid">

                {{-- Title --}}
                <div>
                    <label>Book Title*</label>
                    <input type="text" name="title" class="form-input" value="{{ $book->title }}" required>
                </div>

                {{-- Author --}}
                <div>
                    <label>Author*</label>
                    <input type="text" name="author" class="form-input" value="{{ $book->author }}" required>
                </div>

                {{-- Condition --}}
                <div>
                    <label>Condition*</label>
                    <input type="text" name="condition" class="form-input" value="{{ $book->condition }}" required>
                </div>

                {{-- Price --}}
                <div>
                    <label>Price (₱)*</label>
                    <input type="number" name="price" class="form-input" value="{{ $book->price }}" required>
                </div>

                {{-- Genre --}}
                <div class="full-width">
                    <label>Genre*</label>
                    <input type="text" name="genre" class="form-input" value="{{ $book->genre }}" required>
                </div>

                {{-- Description --}}
                <div class="full-width">
                    <label>Description</label>
                    <textarea name="description" class="form-input" style="height:120px;">{{ $book->description }}</textarea>
                </div>

                {{-- Existing Photos --}}
                <div class="full-width">
                    <label>Existing Photos</label>

                    @php
                        $photosDecoded = json_decode($book->photos, true);
                        if (!is_array($photosDecoded)) $photosDecoded = [];
                    @endphp

                    <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:8px;">
                        @forelse($photosDecoded as $photo)
                            <img src="{{ asset('storage/' . $photo) }}" 
                                style="width:90px; height:90px; border-radius:8px; object-fit:cover; border:1px solid #ddd;">
                        @empty
                            <p style="color:#777;">No photos uploaded yet.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Upload More Photos --}}
                <div class="full-width" style="margin-top:15px;">
                    <label>Upload More Photos</label>
                    <input type="file" name="photos[]" multiple class="form-input">
                </div>

            </div>

            {{-- Buttons --}}
            <div class="create-buttons" style="margin-top:20px;">
                <a href="{{ route('books.index') }}" class="cancel-btn">Cancel</a>
                <button type="submit" class="submit-btn">Save Changes</button>
            </div>

        </form>
    </div>


    {{-- RIGHT PANEL (Preview Card Style Optional) --}}
    <div class="right-box listings-box">

        <h3>Preview</h3>

        <div class="listing-item" style="display:flex; gap:15px; align-items:center;">

            {{-- Thumbnail --}}
            @if($book->thumbnail)
                <img src="{{ asset('storage/' . $book->thumbnail) }}"
                    style="width:80px; height:auto; border-radius:6px;">
            @endif

            <div style="flex:1;">
                <p style="font-weight:700; margin:0; font-size:18px;">{{ $book->title }}</p>
                <p style="color:#777; margin:0; font-size:14px;">{{ $book->author }}</p>

                {{-- Tags --}}
                <div style="display:flex; gap:8px; margin:6px 0;">
                    <span style="background:#FFE8A3; color:#A46B07; padding:4px 10px; border-radius:12px; font-size:12px;">
                        {{ $book->genre }}
                    </span>
                    <span style="background:#D9F3FF; color:#0077A8; padding:4px 10px; border-radius:12px; font-size:12px;">
                        {{ $book->condition }}
                    </span>
                </div>

                <p style="color:#F9B200; font-weight:700; margin:0;">₱{{ $book->price }}</p>
            </div>

        </div>

    </div>

</div>

@endsection
