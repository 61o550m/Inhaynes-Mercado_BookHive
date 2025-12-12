<div id="loginModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">

        <button class="modal-close" onclick="closeModal('loginModal')">✕</button>

        <h2 class="modal-title">Welcome to Bookhive!</h2>

        <form method="POST" action="{{ route('login') }}" class="modal-form">
            @csrf
@if ($errors->has('email'))
    <div style="
        background:#FFE7B3;
        color:#8a4b00;
        padding:10px 14px;
        border-radius:10px;
        font-size:14px;
        font-weight:600;
        margin-bottom:12px;
        border:1px solid #F9B200;">
        Invalid or wrong email or password.
    </div>
@endif

        <div class="modal-group">
            <label>Institutional Email</label>
            <input 
                type="email" 
                class="modal-input" 
                name="email" 
                placeholder="Enter your institutional email"
                required
            >
        </div>

            <div class="modal-group">
                <label>Password</label>
                <input type="password" class="modal-input" name="password" 
                placeholder="Enter your password"
                required>
            </div>

            <button type="submit" class="modal-btn-primary">Sign in</button>

        </form>

        <p class="modal-link"
           onclick="closeModal('loginModal'); openModal('forgotModal')">
           Forgot Password?
        </p>

        <p class="modal-switch">
            Don’t have an account?
            <span class="modal-link"
                onclick="closeModal('loginModal'); openModal('registerModal')">
                Register
            </span>
        </p>

    </div>
</div>

<div id="registerModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">

        <button class="modal-close" onclick="closeModal('registerModal')">✕</button>

        <h2 class="modal-title">Create an Account</h2>

        @if ($errors->any())
            <div style="background:red;color:white;padding:10px;border-radius:6px;margin-bottom:10px;">
                {{ implode(', ', $errors->all()) }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="modal-form">
            @csrf

            <div class="modal-group">
                <label>Username</label>
                <input type="text" class="modal-input" name="name" 
                       placeholder="Enter your username" required>
            </div>

            <div class="modal-group">
                <label>Institutional Email</label>
                <input 
                    type="email" 
                    class="modal-input" 
                    name="email" 
                    placeholder="Enter your institutional email"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="modal-group">
                <label>Password</label>
                <input type="password" class="modal-input" name="password"
                       placeholder="Enter your password" required>
            </div>

            <div class="modal-group">
                <label>Confirm Password</label>
                <input type="password" class="modal-input" name="password_confirmation"
                       placeholder="Re-enter your password" required>
            </div>

            <button type="submit" class="modal-btn-primary">Register</button>

        </form>

        <p class="modal-switch">
            Already have an account?
            <span class="modal-link"
                onclick="closeModal('registerModal'); openModal('loginModal')">
                Sign in
            </span>
        </p>

    </div>
</div>

<div id="forgotModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">

        <button class="modal-close" onclick="closeModal('forgotModal')">✕</button>

        <h2 class="modal-title">Reset Password</h2>

        <form method="POST" action="{{ route('password.email') }}" class="modal-form">
            @csrf

            <div class="modal-group">
                <label>Institutional Email</label>
                <input 
                    type="email" 
                    class="modal-input" 
                    name="email" 
                    placeholder="Enter your institutional email"
                    required
                >
            </div>

            <button class="modal-btn-primary">Send Reset Link</button>
        </form>

        <p class="modal-link"
           onclick="closeModal('forgotModal'); openModal('loginModal')">
           Back to Sign in
        </p>

    </div>
</div>
