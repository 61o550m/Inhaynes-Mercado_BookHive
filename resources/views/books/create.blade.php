@extends('layouts.app')

@section('content')

<h1 class="sell-title">Sell Your Books</h1>

<div class="sell-layout">


    {{-- LEFT: Create Form --}}
    <div class="left-box create-box">

        <div class="create-header">
            <h2>List Your Book</h2>
            <a href="{{ route('books.index') }}" class="close-btn">✕</a>
        </div>

        <form id="sellForm" action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="form-grid">

                {{-- Title --}}
                <div>
                    <label>Book Title*</label>
                    <input type="text" name="title" class="form-input"
 required>
                </div>

                {{-- Author --}}
                <div>
                    <label>Author*</label>
                    <input type="text" name="author" class="form-input" required>
                </div>

                {{-- Condition --}}
                <div>
                    <label>Book Condition*</label>
                    <select name="condition" class="form-input" required>
                        <option value="">Select condition</option>
                        <option>New</option>
                        <option>Like New</option>
                        <option>Used</option>
                        <option>Acceptable</option>
                    </select>
                </div>

                {{-- Price --}}
                <div>
                    <label>Price (₱)*</label>
                    <input type="number" name="price" step="0.01" class="form-input" required>
                </div>

                {{-- Genre --}}
                <div class="full-width">
                    <label>Genre*</label>
                    <select name="genre" class="form-input" required>
                        <option value="">Select genre</option>
                        <option>Fiction</option>
                        <option>Fantasy</option>
                        <option>Romance</option>
                        <option>Thriller</option>
                        <option>Science Fiction</option>
                        <option>Non-Fiction</option>
                        <option>Education</option>
                        <option>Horror</option>
                        <option>Mystery</option>
                        <option>Manga</option>
                        <option>Historical</option>

                    </select>
                </div>

                {{-- Description --}}
<div class="full-width">
    <label>Book Photos*</label>

    <div class="upload-box" style="
        height:180px; 
        border:2px dashed #F9B200; 
        border-radius:20px; 
        display:flex; 
        flex-direction:column; 
        justify-content:center; 
        align-items:center; 
        background:#fff; 
        position:relative; 
        overflow:hidden;
        cursor:pointer;">

<img src="{{ asset('img/up.png') }}" 
     alt="upload" 
     style="width:100px; opacity:0.8;">


        <p style="margin-top:8px; font-size:14px; text-align:center;">
            Click to upload photos or drag and drop <br>
            <span style="font-size:12px; color:#999;">PNG, JPG up to 5MB each</span>
        </p>

        <!-- WORKING FILE INPUT -->
        <input type="file" 
               name="photos[]" 
               multiple 
               accept="image/png, image/jpeg" 
               style="
                    position:absolute; 
                    inset:0; 
                    width:100%; 
                    height:100%; 
                    opacity:0; 
                    cursor:pointer;">
    </div>

    <div id="photo-preview" style="display:flex; gap:10px; margin-top:10px;"></div>

</div>


            </div>

            {{-- Buttons --}}
            <div class="create-buttons">
                <button type="submit" class="submit-btn">List Book</button>
                <a href="{{ route('books.index') }}" class="cancel-btn1">Cancel</a>
            </div>

        </form>
    </div>



    {{-- RIGHT: Your Listings --}}
    <div class="right-box listings-box">

        <h3>Your Listings ({{ $books->count() }})</h3>

 @foreach($books as $book)
<div class="listing-item" style="display:flex; gap:15px; align-items:center;">

    {{-- Thumbnail --}}
    @if($book->thumbnail)
        <img src="{{ asset('storage/' . $book->thumbnail) }}"
             style="width:65px; height:auto; border-radius:6px;">
    @endif

<div style="flex:1;">
    <p style="font-weight:700; margin:0;">{{ $book->title }}</p>
    <p style="color:#777; margin:0; font-size:14px;">{{ $book->author }}</p>

    {{-- TAGS ROW --}}
    <div style="margin:6px 0; display:flex; gap:6px; flex-wrap:wrap;">
        <span style="background:#FFE8A3; color:#A46B07; padding:2px 8px; border-radius:12px; font-size:12px;">
            {{ $book->genre }}
        </span>

        <span style="background:#E3F7FF; color:#0077A8; padding:2px 8px; border-radius:12px; font-size:12px;">
            {{ $book->condition }}
        </span>
    </div>

    <p style="color:#F9B200; font-weight:700; margin:0;">₱{{ $book->price }}</p>
</div>


    <div style="display:flex; flex-direction:column; gap:6px;">

        {{-- EDIT BUTTON --}}
        <a href="{{ route('books.edit', $book->id) }}"
           style="padding:6px 12px; background:#FFC107; border-radius:6px;
                  color:white; font-size:14px; text-align:center;">
            Edit
        </a>

        {{-- DELETE BUTTON --}}
<form action="{{ route('books.destroy', $book->id) }}" method="POST" class="delete-form">
    @csrf
    @method('DELETE')
    <button type="submit"
        style="padding:6px 12px; background:#E53935; border:none;
               border-radius:6px; color:white; font-size:14px;">
        Delete
    </button>
</form>

    </div>

</div>
@endforeach



    </div>

</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.querySelector('input[name="photos[]"]');
    const preview = document.getElementById('photo-preview');

    input.addEventListener('change', function () {
        preview.innerHTML = ''; // clear previous previews

        Array.from(this.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '80px';
                img.style.height = '80px';
                img.style.objectFit = 'cover';
                img.style.borderRadius = '8px';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('sellForm');
    const input = document.querySelector('input[name="photos[]"]');

    if (!form) return;

    form.addEventListener("submit", function(e) {
        if (!input || input.files.length === 0) {
            e.preventDefault();
            showToast("Please upload at least one photo.");
        }
    });
});



document.addEventListener("DOMContentLoaded", function () {
    const deleteForms = document.querySelectorAll(".delete-form");

    deleteForms.forEach(form => {
        form.addEventListener("submit", function (e) {
            const confirmed = confirm("Are you sure you want to delete this listing?");
            if (!confirmed) {
                e.preventDefault(); // stop delete
            }
        });
    });
});


</script>

@endsection
