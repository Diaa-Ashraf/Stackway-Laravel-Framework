@extends('stackway::layouts.auth')

@section('title', 'إنشاء حساب جديد')

@section('content')
<div class="space-y-6">

    <div class="text-center">
        <h1 class="text-xl font-bold text-slate-900 dark:text-white">إنشاء حساب جديد ✨</h1>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">سجل حسابك للوصول إلى لوحة التحكم</p>
    </div>

    @if (isset($errors) && $errors->any())
        <div class="p-3.5 rounded-2xl bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 text-xs font-medium border border-rose-200 dark:border-rose-800 space-y-1">
            @foreach ($errors->all() as $error)
                <p>• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">الاسم الكامل</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                placeholder="محمد علي"
                class="sw-input w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-900 transition"
            />
        </div>

        {{-- Email Address --}}
        <div>
            <label for="email" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">البريد الإلكتروني</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="username"
                placeholder="name@example.com"
                class="sw-input w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-900 transition"
            />
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">كلمة المرور</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="••••••••"
                class="sw-input w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-900 transition"
            />
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">تأكيد كلمة المرور</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="••••••••"
                class="sw-input w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-900 transition"
            />
        </div>

        {{-- Submit Button --}}
        <button
            type="submit"
            class="w-full py-3 px-4 rounded-xl text-white font-bold text-sm bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 shadow-md shadow-teal-500/25 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 cursor-pointer"
        >
            إنشاء الحساب
        </button>
    </form>

    <div class="text-center pt-2">
        <p class="text-xs text-slate-500 dark:text-slate-400">
            لديك حساب بالفعل؟
            <a href="{{ route('login') }}" class="font-bold text-[var(--sw-primary)] hover:underline">
                تسجيل الدخول
            </a>
        </p>
    </div>

</div>
@endsection
