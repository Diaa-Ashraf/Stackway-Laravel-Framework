@extends('stackway::layouts.auth')

@section('title', 'استعادة كلمة المرور')

@section('content')
<div class="space-y-6">

    <div class="text-center">
        <h1 class="text-xl font-bold text-slate-900 dark:text-white">استعادة كلمة المرور 🔒</h1>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">أدخل بريدك الإلكتروني وسنرسل لك رابط إعادة التعيين</p>
    </div>

    @if (session('status'))
        <div class="p-3.5 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-xs font-medium border border-emerald-200 dark:border-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    @if (isset($errors) && $errors->any())
        <div class="p-3.5 rounded-2xl bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 text-xs font-medium border border-rose-200 dark:border-rose-800 space-y-1">
            @foreach ($errors->all() as $error)
                <p>• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        {{-- Email Address --}}
        <div>
            <label for="email" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">البريد الإلكتروني</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                placeholder="name@example.com"
                class="sw-input w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900 focus:bg-white dark:focus:bg-slate-900 transition"
            />
        </div>

        {{-- Submit Button --}}
        <button
            type="submit"
            class="w-full py-3 px-4 rounded-xl text-white font-bold text-sm bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 shadow-md shadow-teal-500/25 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 cursor-pointer"
        >
            إرسال رابط إعادة التعيين
        </button>
    </form>

    <div class="text-center pt-2">
        <a href="{{ route('login') }}" class="text-xs font-bold text-[var(--sw-primary)] hover:underline">
            ← العودة لتسجيل الدخول
        </a>
    </div>

</div>
@endsection
