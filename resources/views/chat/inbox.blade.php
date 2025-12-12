@extends('layouts.app')

@section('content')

<div style="margin-top:120px; display:flex;">

    {{-- LEFT INBOX PANEL --}}
    <div style="width:280px; background:#fff; border-right:1px solid #eee;">

        <div style="padding:15px; font-weight:bold; font-size:18px;">Inbox</div>

        {{-- Search --}}
        <div style="padding:10px 15px; display:flex; align-items:center; gap:10px;">
            <input 
                type="text" 
                placeholder="Search..."
                style="width:100%; padding:8px; border:1px solid #ccc; border-radius:10px;"
            >
        </div>

        {{-- Inbox Item --}}
        <div style="padding:15px; cursor:pointer; display:flex; gap:10px;">
            <img src="{{ asset('img/harrypotter.jpg') }}"
                style="width:45px; height:55px; border-radius:6px; object-fit:cover;">
            <div>
                <strong>Harry Potter</strong>
                <div style="font-size:13px; color:#777;">Lorem ipsum dolor</div>
            </div>
        </div>

    </div>


    {{-- MIDDLE CHAT AREA --}}
    <div style="flex:1; background:#fff;">

        {{-- HEADER --}}
        <div style="padding:15px 20px; border-bottom:1px solid #eee; background:#fff9d7;">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                
                <div style="display:flex; align-items:center; gap:12px;">
                    <img src="{{ asset('img/user.png') }}" 
                         style="width:40px; height:40px; border-radius:50%;">

                    <div>
                        <div style="font-weight:bold;">Byron Rozul</div>
                        <div style="font-size:12px; color:gray;">Online today</div>
                    </div>
                </div>

                {{-- Offer + Review Buttons --}}
                <button onclick="openOffer()" class="start-selling-btn">Make Offer</button>
                <button onclick="openReview()" class="start-selling-btn">Leave Review</button>
            </div>
        </div>

        {{-- CHAT BUBBLES --}}
        <div style="padding:25px;">

            <div style="margin-bottom:20px;">
                <div style="
                    background:#f3f3f3;
                    display:inline-block;
                    padding:10px 15px;
                    border-radius:12px;
                    max-width:350px;
                ">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                </div>
            </div>

            <div style="margin-bottom:20px; text-align:right;">
                <div style="
                    background:#e8f1ff;
                    display:inline-block;
                    padding:10px 15px;
                    border-radius:12px;
                    max-width:350px;
                ">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                </div>
            </div>

        </div>

        {{-- MESSAGE INPUT --}}
        <div style="
            padding:15px 20px;
            border-top:1px solid #eee;
            background:#fbf3dd;
        ">
            <div style="display:flex; gap:10px;">
                <input 
                    type="text" 
                    placeholder="Type a message here..."
                    style="flex:1; padding:12px; border-radius:20px; border:1px solid #ccc;"
                >

                <button class="start-selling-btn" style="border-radius:50%; padding:10px 18px;">
                    +
                </button>
            </div>
        </div>

    </div>
</div>


{{-- ############################################################ --}}
{{-- REVIEW POPUP --}}
{{-- ############################################################ --}}
<div id="reviewPopup" class="modal-overlay" style="display:none;">
    <div class="modal-box">

        <button onclick="closeReview()" class="modal-close">&times;</button>

        <h2 class="modal-title">Rate Book</h2>

        <div style="display:flex; gap:12px; align-items:center;">
            <img src="{{ asset('img/harrypotter.jpg') }}"
                 style="width:60px; height:80px; border-radius:6px;">
            <div>
                <strong>Harry Potter</strong>
                <div style="font-size:14px; color:gray;">J.K. Rowling</div>
            </div>
        </div>

        <label style="margin-top:10px;">Book Quality:</label>

        <div class="rating-stars" style="font-size:24px; color:#ffb100;">
            ★★★★☆
        </div>

        <textarea placeholder="Type your review here"
            class="modal-input"
            style="height:130px;"></textarea>

        <div style="display:flex; justify-content:flex-end; gap:10px;">
            <button onclick="closeReview()" class="cancel-btn">Cancel</button>
            <button class="submit-btn">Submit</button>
        </div>

    </div>
</div>


{{-- ############################################################ --}}
{{-- OFFER POPUP --}}
{{-- ############################################################ --}}
<div id="offerPopup" class="modal-overlay" style="display:none;">
    <div class="modal-box">

        <button onclick="closeOffer()" class="modal-close">&times;</button>

        <h2 class="modal-title">Make an Offer</h2>

        <label>Your Offer Amount:</label>
        <input type="number" class="modal-input" placeholder="₱ 0.00">

        <div style="display:flex; justify-content:flex-end; gap:10px;">
            <button onclick="closeOffer()" class="cancel-btn">Cancel</button>
            <button class="submit-btn">Submit</button>
        </div>

    </div>
</div>


<script>
    function openReview(){ document.getElementById("reviewPopup").style.display = "flex"; }
    function closeReview(){ document.getElementById("reviewPopup").style.display = "none"; }

    function openOffer(){ document.getElementById("offerPopup").style.display = "flex"; }
    function closeOffer(){ document.getElementById("offerPopup").style.display = "none"; }
</script>

@endsection
