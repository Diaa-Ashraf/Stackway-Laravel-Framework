@extends('stackway::layouts.auth')

@section('title', 'تسجيل الدخول')
@section('heading', 'تسجيل الدخول إلى حسابك')
@section('subheading', 'أدخل بيانات حسابك للمتابعة إلى لوحة التحكم')

@section('content')
<div>
    {{-- Session Status --}}
    @if (session('status'))
        <div class="alert alert-success py-2 px-3 small mb-3">
            {{ session('status') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger py-2 px-3 small mb-3">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="needs-validation">
        @csrf

        {{-- Email Address --}}
        <div class="mb-3">
            <label for="email" class="form-label small fw-semibold">البريد الإلكتروني</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                placeholder="name@example.com"
                class="form-control"
            />
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="password" class="form-label small fw-semibold mb-0">كلمة المرور</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="small link-primary text-decoration-none">
                        نسيت كلمة المرور؟
                    </a>
                @endif
            </div>

            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="••••••••"
                class="form-control"
            />
        </div>

        {{-- Remember Me --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="form-check-input"
                >
                <label class="form-check-label small" for="remember_me">
                    تذكر هذا الجهاز
                </label>
            </div>
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            <span>تسجيل الدخول</span>
            <i class="ti ti-arrow-left ms-1"></i>
        </button>
    </form>

    {{-- Quick Demo Credentials Card (For testing) --}}
    <div class="card bg-light border-dashed border p-3 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <span class="small fw-bold text-dark">🔑 بيانات الحساب التجريبي:</span>
            <button
                type="button"
                onclick="document.getElementById('email').value='admin@stackway.dev'; document.getElementById('password').value='password';"
                class="btn btn-sm btn-outline-primary py-0 px-2"
                style="font-size: 11px;"
            >
                تعبئة تلقائية
            </button>
        </div>
        <div class="small text-muted font-monospace" style="font-size: 11px;">
            <div>البريد: <strong>admin@stackway.dev</strong></div>
            <div>المرور: <strong>password</strong></div>
        </div>
    </div>

    {{-- Register link if available --}}
    @if (Route::has('register'))
        <div class="text-center mt-4 small text-secondary">
            ليس لديك حساب بعد؟
            <a href="{{ route('register') }}" class="link-primary text-decoration-none fw-semibold">
                إنشاء حساب جديد
            </a>
        </div>
    @endif
</div>
@endsection
