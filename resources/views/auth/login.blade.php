@extends('stackway::layouts.auth')

@section('title', 'تسجيل الدخول')

@section('content')
<div class="space-y-6">

    <div class="text-center">
        <h1 class="text-xl font-bold text-slate-900 dark:text-white">مرحباً بك مجدداً 👋</h1>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">أدخل بيانات حسابك للمتابعة إلى لوحة التحكم</p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="p-3.5 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-xs font-medium border border-emerald-200 dark:border-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if (isset($errors) && $errors->any())
        <div class="p-3.5 rounded-2xl bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 text-xs font-medium border border-rose-200 dark:border-rose-800 space-y-1">
            @foreach ($errors->all() as $error)
                <p>• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        {{-- Email Address --}}
        <div>
            <label for="email" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">البريد الإلكتروني</label>
            <div class="relative rounded-xl">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="name@example.com"
                    class="sw-input w-full px-4 py-2.5 text-sm rounded-xl ps-10 border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-900 transition"
                />
            </div>
        </div>

        {{-- Password --}}
        <div x-data="{ showPass: false }">
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-bold text-slate-700 dark:text-slate-300">كلمة المرور</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-[var(--sw-primary)] hover:underline font-medium">
                        نسيت كلمة المرور؟
                    </a>
                @endif
            </div>

            <div class="relative rounded-xl">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <input
                    id="password"
                    :type="showPass ? 'text' : 'password'"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="sw-input w-full px-4 py-2.5 text-sm rounded-xl ps-10 pe-10 border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-900 transition"
                />
                <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 end-0 flex items-center pe-3 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg x-show="showPass" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Remember Me --}}
        <div class="flex items-center justify-between py-1">
            <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="w-4 h-4 rounded text-[var(--sw-primary)] border-slate-300 dark:border-slate-700 focus:ring-[var(--sw-primary)]/20 dark:bg-slate-800"
                >
                <span class="text-xs text-slate-600 dark:text-slate-400 font-medium">تذكر هذا الجهاز</span>
            </label>
        </div>

        {{-- Submit Button --}}
        <button
            type="submit"
            class="w-full py-3 px-4 rounded-xl text-white font-bold text-sm bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-700 hover:to-indigo-700 shadow-md shadow-violet-500/25 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-violet-500/50 cursor-pointer flex items-center justify-center gap-2"
        >
            <span>تسجيل الدخول</span>
            <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
        </button>
    </form>

    {{-- Quick Demo Credentials Card (For testing) --}}
    <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-800 text-xs space-y-2">
        <div class="flex items-center justify-between text-slate-500">
            <span class="font-bold flex items-center gap-1 text-slate-700 dark:text-slate-300">
                <span>🔑</span>
                <span>بيانات الحساب التجريبي:</span>
            </span>
            <button
                type="button"
                onclick="document.getElementById('email').value='admin@stackway.dev'; document.getElementById('password').value='password';"
                class="px-2 py-1 rounded-lg bg-violet-100 dark:bg-violet-900/40 text-[var(--sw-primary)] font-bold hover:bg-violet-200 transition text-[11px]"
            >
                تعبئة تلقائية
            </button>
        </div>
        <div class="font-mono text-[11px] text-slate-500 dark:text-slate-400 space-y-0.5">
            <p>البريد: <strong class="text-slate-700 dark:text-slate-200">admin@stackway.dev</strong></p>
            <p>المرور: <strong class="text-slate-700 dark:text-slate-200">password</strong></p>
        </div>
    </div>

    {{-- Register link if available --}}
    @if (Route::has('register'))
        <div class="text-center pt-2">
            <p class="text-xs text-slate-500 dark:text-slate-400">
                ليس لديك حساب بعد؟
                <a href="{{ route('register') }}" class="font-bold text-[var(--sw-primary)] hover:underline">
                    إنشاء حساب جديد
                </a>
            </p>
        </div>
    @endif

</div>
@endsection
