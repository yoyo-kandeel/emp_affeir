@extends('layouts.master2')
@section('title','مرحبا بك في بنامج شئون العاملين | تسجيل الدخول ')

@section('styles.master2')
    <link rel="stylesheet" href="{{ asset('assets/css/loginform.css') }}">

@endsection

@section('content')

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h2>{{ __('مرحباً بك') }}</h2>
            <p>{{ __('تسجيل الدخول') }}</p>
        </div>

        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="form-group">
                <div class="input-wrapper">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        autofocus
                        class="@error('email') is-invalid @enderror"
                    >
                    <label for="email">{{ __('عنوان البريد الإلكتروني') }}</label>
                    <span class="focus-border"></span>
                </div>
                @error('email')
                    <div class="error-message d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group password-wrapper">
                <div class="input-wrapper">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="@error('password') is-invalid @enderror"
                    >
                    <label for="password">{{ __('كلمة المرور') }}</label>
                    <button type="button" class="password-toggle" id="passwordToggle" aria-label="{{ __('إظهار / إخفاء كلمة المرور') }}">
                    </button>
                    <span class="focus-border"></span>
                </div>
                @error('password')
                    <div class="error-message d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- Remember + Forgot --}}
            <div class="form-options">
                <label class="remember-wrapper" for="remember">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span class="checkbox-label">
                        <span class="checkmark"></span>
                        {{ __('تذكرني') }}
                    </span>
                </label>

                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-password">{{ __('هل نسيت كلمة المرور؟') }}</a>
                @endif
            </div>

            {{-- Submit --}}
            <button type="submit" class="login-btn btn">
                <span class="btn-text">{{ __('دخول') }}</span>
                <span class="btn-loader"></span>
            </button>
        </form>
        {{-- Success Message --}}
        <div class="success-message" id="successMessage">
            <div class="success-icon">✓</div>
            <h3>{{ __('تم تسجيل الدخول بنجاح!') }}</h3>
            <p>{{ __('جارٍ إعادة التوجيه إلى لوحة التحكم...') }}</p>
        </div>
    </div>
</div>
@endsection

@section('scripts.master2')
    <script src="{{ asset('assets/js/form-utils.js') }}"></script>
    <script src="{{ asset('assets/js/loginform.js') }}"></script>
@endsection
