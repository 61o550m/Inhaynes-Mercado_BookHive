@extends('layouts.app')

@section('content')

<div class="info-container" style="padding:0 40px; max-width:none;">


    {{-- HELP --}}
    <div id="help">
        <div class="info-section-title">Help</div>
        <div class="yellow-separator"></div>

        <div class="info-two-column">

            <div id="faqs">
                <div class="info-card-title">FAQs</div>
                <p class="info-card-text">
                    Find comprehensive answers to the most common questions related to browsing listings,
                    negotiating prices, meeting up on campus, and managing your account.
                </p>
            </div>

            <div id="contact-support">
                <div class="info-card-title">Contact Support</div>
                <p class="info-card-text">
                    If you encounter issues or need clarification, our support team is ready to help.
                </p>
            </div>

            <div id="how-to-buy">
                <div class="info-card-title">How to Buy</div>
                <p class="info-card-text">
                    Browse listings, compare prices, message sellers, and coordinate meet-ups.
                </p>
            </div>

            <div id="how-to-sell">
                <div class="info-card-title">How to Sell</div>
                <p class="info-card-text">
                    List your books with clear descriptions and fair pricing, then negotiate with buyers.
                </p>
            </div>

        </div>
    </div>


    {{-- ABOUT --}}
    <div id="about" style="margin-top:60px;">
        <div class="info-section-title">About</div>
        <div class="yellow-separator"></div>

        <div class="info-two-column">

            <div id="about-us">
                <div class="info-card-title">About Us</div>
                <p class="info-card-text">
                    We are an online marketplace exclusive to students for convenient book buying & selling.
                </p>
            </div>

            <div id="mission">
                <div class="info-card-title">Our Mission</div>
                <p class="info-card-text">
                    We promote sustainability through book reuse and reducing unnecessary spending.
                </p>
            </div>

            <div id="feedback">
                <div class="info-card-title">Feedback</div>
                <p class="info-card-text">
                    We value your insights and continuously work to improve the platform.
                </p>
            </div>

        </div>
    </div>


    {{-- POLICIES --}}
    <div id="policy" style="margin-top:60px;">
        <div class="info-section-title">Policies</div>
        <div class="yellow-separator"></div>

        <div class="info-two-column">

            <div id="privacy-policy">
                <div class="info-card-title">Privacy Policy</div>
                <p class="info-card-text">
                    Learn how we securely collect, store, and protect your personal data.
                </p>
            </div>

            <div id="terms-of-service">
                <div class="info-card-title">Terms of Service</div>
                <p class="info-card-text">
                    Review the rules that maintain safety and fairness on BookHive.
                </p>
            </div>

            <div id="academic-integrity">
                <div class="info-card-title">Academic Integrity Guidelines</div>
                <p class="info-card-text">
                    Understand the policies that ensure ethical exchange of academic materials.
                </p>
            </div>

        </div>
    </div>

</div>

@endsection
