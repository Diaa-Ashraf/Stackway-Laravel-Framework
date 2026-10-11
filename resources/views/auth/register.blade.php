@extends('stackway::layouts.auth')

@section('title', 'إنشاء حساب جديد')
@section('heading', 'إنشاء حساب جديد ✨')
@section('subheading', 'سجل حسابك للوصول إلى لوحة التحكم')

@section('content')
<div>
    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger py-2 px-3 small mb-3">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="needs-validation">
        @csrf

        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label small fw-semibold">الاسم الكامل</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                placeholder="محمد علي"
                class="form-control"
            />
        </div>

        {{-- Email Address --}}
        <div class="mb-3">
            <label for="email" class="form-label small fw-semibold">البريد الإلكتروني</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="username"
                placeholder="name@example.com"
                class="form-control"
            />
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label small fw-semibold">كلمة المرور</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="••••••••"
                class="form-control"
            />
        </div>

        {{-- Confirm Password --}}
        <div class="mb-4">
            <label for="password_confirmation" class="form-label small fw-semibold">تأكيد كلمة المرور</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="••••••••"
                class="form-control"
            />
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            <span>إنشاء الحساب</span>
            <i class="ti ti-arrow-left ms-1"></i>
        </button>
    </form>

    {{-- Login link --}}
    @if (Route::has('login'))
        <div class="text-center mt-4 small text-secondary">
            لديك حساب بالفعل؟
            <a href="{{ route('login') }}" class="link-primary text-decoration-none fw-semibold">
                تسجيل الدخول
            </a>
        </div>
    @endif
</div>
@endsection
