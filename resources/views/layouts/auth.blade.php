<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
      data-theme="{{ session('theme', config('stackway.theme.mode', 'system')) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'تسجيل الدخول') — {{ config('app.name', 'Stackway') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    {{-- Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 flex items-center justify-center p-4 relative overflow-x-hidden selection:bg-violet-500 selection:text-white">

    {{-- Background Decorative Ambient Blobs --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -start-40 w-96 h-96 bg-violet-600/20 dark:bg-violet-600/15 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -end-40 w-96 h-96 bg-indigo-600/20 dark:bg-indigo-600/15 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 start-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-cyan-600/10 dark:bg-cyan-600/5 rounded-full blur-3xl"></div>
    </div>

    {{-- Theme Mode Toggle (Top Floating) --}}
    <div class="absolute top-6 end-6 z-20">
        <button type="button" onclick="window.toggleTheme()" class="p-2.5 rounded-2xl bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border border-slate-200/80 dark:border-slate-800 text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white shadow-sm transition" title="تبديل الوضع">
            <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
        </button>
    </div>

    {{-- Main Container --}}
    <div class="relative z-10 w-full max-w-md py-8">
        {{-- Brand Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-tr from-violet-600 to-indigo-600 text-white shadow-lg shadow-violet-500/25 mb-4 transform hover:scale-105 transition-transform duration-300">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                {{ config('app.name', 'Stackway') }}
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">منصة إدارة الأنظمة واللوحات المتطورة</p>
        </div>

        {{-- Auth Card --}}
        <div class="rounded-3xl border border-slate-200/80 dark:border-slate-800 bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl shadow-xl shadow-slate-200/50 dark:shadow-none p-6 sm:p-8">
            @yield('content')
        </div>

        {{-- Footer Note --}}
        <div class="text-center mt-6 text-xs text-slate-400 dark:text-slate-500">
            <p>© {{ date('Y') }} {{ config('app.name', 'Stackway') }}. جميع الحقوق محفوظة.</p>
        </div>
    </div>

    {{-- Theme Init Script --}}
    <script>
        (function() {
            const savedTheme = localStorage.getItem('sw_theme') || "{{ config('stackway.theme.mode', 'system') }}";
            if (savedTheme === 'system') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.setAttribute('data-theme', prefersDark ? 'dark' : 'light');
            } else {
                document.documentElement.setAttribute('data-theme', savedTheme);
            }
        })();

        window.toggleTheme = function() {
            const current = document.documentElement.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('sw_theme', next);
        };
    </script>

    @stack('scripts')
</body>
</html>
