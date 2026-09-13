<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
      data-theme="{{ session('theme', config('stackway.theme.mode', 'light')) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $title ?? config('app.name', 'Dashboard')) — {{ config('app.name', 'Stackway') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    {{-- Styles --}}
    <style>
        [x-cloak] { display: none !important; }
        @media (min-width: 1024px) { .sw-mobile-toggle { display: none !important; } }
        {!! file_get_contents(__DIR__ . '/../../css/stackway-theme.css') !!}
    </style>

    {{-- Alpine.js Bundle (Standalone & Auto-initializing) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased" x-data="{ sidebarCollapsed: localStorage.getItem('sw_sidebar') === 'collapsed', mobileOpen: false }"
      @keydown.escape.window="mobileOpen = false">

    {{-- Mobile Overlay --}}
    <div x-show="mobileOpen" x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 z-30 lg:hidden" @click="mobileOpen = false" style="display:none;"></div>

    {{-- Sidebar --}}
    <x-sw-sidebar :items="$sidebarItems ?? []" />

    {{-- Main Content Wrapper --}}
    <div class="sw-main" :class="{ 'lg:ml-[72px]': sidebarCollapsed, 'lg:ml-[260px]': !sidebarCollapsed }"
         style="transition: margin-left 300ms cubic-bezier(0.4, 0, 0.2, 1);">

        {{-- Header --}}
        <x-sw-header :breadcrumbs="$breadcrumbs ?? []" />

        {{-- Page Content --}}
        <main class="sw-content">
            {{-- Dynamic Page Header if header-actions defined --}}
            @hasSection('header-actions')
                <div class="mb-6 flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-2xl font-bold" style="color: var(--sw-text-primary);">@yield('title')</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        @yield('header-actions')
                    </div>
                </div>
            @elseif(isset($pageTitle))
                <div class="mb-6 flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-2xl font-bold" style="color: var(--sw-text-primary);">{{ $pageTitle }}</h1>
                        @isset($pageDescription)
                            <p class="mt-1 text-sm" style="color: var(--sw-text-muted);">{{ $pageDescription }}</p>
                        @endisset
                    </div>
                    @isset($pageActions)
                        <div class="flex items-center gap-3">
                            {{ $pageActions }}
                        </div>
                    @endisset
                </div>
            @endif

            {{-- Flash Messages --}}
            @if(session('success'))
                <x-sw-alert type="success" :message="session('success')" dismissible />
            @endif
            @if(session('error'))
                <x-sw-alert type="danger" :message="session('error')" dismissible />
            @endif
            @if(session('warning'))
                <x-sw-alert type="warning" :message="session('warning')" dismissible />
            @endif

            {{-- Main Content --}}
            @if(isset($slot) && !empty((string) $slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </main>

        {{-- Footer --}}
        <x-sw-footer />
    </div>

    {{-- Toast Container --}}
    <x-sw-toast />

    {{-- Theme Toggle Script --}}
    <script>
        // Theme initialization
        (function() {
            const savedTheme = localStorage.getItem('sw_theme') || "{{ config('stackway.theme.mode', 'light') }}";
            let theme = savedTheme;
            if (savedTheme === 'system') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                theme = prefersDark ? 'dark' : 'light';
            }
            document.documentElement.setAttribute('data-theme', theme);
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();

        // Toggle theme function
        window.toggleTheme = function() {
            const current = document.documentElement.getAttribute('data-theme') || 'light';
            const next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            if (next === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            localStorage.setItem('sw_theme', next);
        };
    </script>

    @stack('scripts')
</body>
</html>
