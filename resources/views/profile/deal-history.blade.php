@extends('layouts.app')

@section('content')

<h2 class="deal-title">Deal History</h2>

@foreach($deals as $deal)
<div class="deal-card">
    
    <div class="deal-header">
        <span class="deal-seller">{{ $deal->seller->name }}</span>
        <span class="deal-status">{{ $deal->status }}</span>
    </div>

    <div class="deal-body">
        <img src="{{ asset('storage/' . $deal->book->thumbnail) }}" class="deal-img">

        <div class="deal-info">
            <h3>{{ $deal->book->title }}</h3>
            <p>{{ $deal->book->author }}</p>
        </div>

        <div class="deal-price">
            ₱ {{ $deal->book->price }}
        </div>

        <a href="{{ route('book.show', $deal->book->id) }}" class="review-btn">View Review</a>
    </div>

</div>
@endforeach

@endsection
