@extends('stackway::layouts.auth')

@section('title', 'استعادة كلمة المرور')
@section('heading', 'استعادة كلمة المرور 🔐')
@section('subheading', 'أدخل بريدك الإلكتروني وسنرسل لك رابط إعادة التعيين')

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

    <form method="POST" action="{{ route('password.email') }}" class="needs-validation">
        @csrf

        {{-- Email Address --}}
        <div class="mb-4">
            <label for="email" class="form-label small fw-semibold">البريد الإلكتروني</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                placeholder="name@example.com"
                class="form-control"
            />
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            <span>إرسال رابط استعادة المرور</span>
            <i class="ti ti-mail ms-1"></i>
        </button>
    </form>

    {{-- Back to login --}}
    <div class="text-center mt-4 small text-secondary">
        <a href="{{ route('login') }}" class="link-primary text-decoration-none fw-semibold">
            ← العودة لتسجيل الدخول
        </a>
    </div>
</div>
@endsection
