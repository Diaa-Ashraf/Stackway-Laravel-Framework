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
    {{-- Core Design System Baseline & Tokens --}}
    <style>
        [x-cloak] { display: none !important; }
        @media (min-width: 1024px) { .sw-mobile-toggle { display: none !important; } }

        :root, [data-theme="light"] {
            --sw-primary: #6D28D9;
            --sw-primary-light: #8B5CF6;
            --sw-primary-dark: #5B21B6;
            --sw-primary-50: #F5F3FF;
            --sw-primary-100: #EDE9FE;
            --sw-secondary: #0891B2;
            --sw-secondary-light: #22D3EE;
            --sw-secondary-dark: #0E7490;
            --sw-accent: #D97706;
            --sw-accent-light: #FBBF24;
            --sw-success: #059669;
            --sw-success-light: #34D399;
            --sw-danger: #DC2626;
            --sw-danger-light: #F87171;
            --sw-warning: #D97706;
            --sw-info: #0284C7;
            --sw-surface: #F8FAFC;
            --sw-surface-card: #FFFFFF;
            --sw-surface-elevated: #FFFFFF;
            --sw-surface-hover: #F1F5F9;
            --sw-surface-pressed: #E2E8F0;
            --sw-text-primary: #0F172A;
            --sw-text-secondary: #475569;
            --sw-text-muted: #64748B;
            --sw-text-inverse: #F8FAFC;
            --sw-border: #E2E8F0;
            --sw-border-light: #F1F5F9;
            --sw-sidebar-width: 260px;
            --sw-sidebar-collapsed-width: 72px;
            --sw-header-height: 64px;
            --sw-radius-sm: 6px;
            --sw-radius: 10px;
            --sw-radius-lg: 14px;
            --sw-radius-xl: 18px;
            --sw-radius-2xl: 24px;
            --sw-radius-full: 9999px;
            --sw-shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --sw-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
            --sw-shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
            --sw-shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
            --sw-shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            --sun-display: none;
            --moon-display: block;
        }

        [data-theme="dark"], .dark {
            --sw-primary: #8B5CF6;
            --sw-primary-light: #A78BFA;
            --sw-primary-dark: #6D28D9;
            --sw-primary-50: rgba(139, 92, 246, 0.1);
            --sw-primary-100: rgba(139, 92, 246, 0.2);
            --sw-surface: #0B0F19;
            --sw-surface-card: #111827;
            --sw-surface-elevated: #1F2937;
            --sw-surface-hover: #1E293B;
            --sw-surface-pressed: #334155;
            --sw-text-primary: #F8FAFC;
            --sw-text-secondary: #CBD5E1;
            --sw-text-muted: #94A3B8;
            --sw-text-inverse: #0F172A;
            --sw-border: #1E293B;
            --sw-border-light: #1E293B;
            --sun-display: block;
            --moon-display: none;
        }

        body {
            background-color: var(--sw-surface);
            color: var(--sw-text-primary);
            font-family: 'IBM Plex Sans Arabic', 'Inter', system-ui, -apple-system, sans-serif;
            margin: 0;
            padding: 0;
        }

        .sw-sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            inset-inline-start: 0;
            width: var(--sw-sidebar-width);
            background: var(--sw-surface-card);
            border-inline-end: 1px solid var(--sw-border);
            z-index: 40;
            display: flex;
            flex-direction: column;
            transition: width 300ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sw-sidebar.collapsed {
            width: var(--sw-sidebar-collapsed-width);
        }

        .sw-header {
            position: fixed;
            top: 0;
            inset-inline-end: 0;
            inset-inline-start: var(--sw-sidebar-width);
            height: var(--sw-header-height);
            background: var(--sw-surface-card);
            border-bottom: 1px solid var(--sw-border);
            z-index: 30;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            transition: inset-inline-start 300ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sw-sidebar.collapsed ~ .sw-main .sw-header,
        .sw-sidebar.collapsed ~ .sw-header {
            inset-inline-start: var(--sw-sidebar-collapsed-width);
        }

        .sw-main {
            margin-inline-start: var(--sw-sidebar-width);
            padding-top: var(--sw-header-height);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-inline-start 300ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sw-main.collapsed {
            margin-inline-start: var(--sw-sidebar-collapsed-width);
        }

        .sw-content {
            flex: 1;
            padding: 1.5rem;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
            box-sizing: border-box;
        }

        .sw-card {
            background: var(--sw-surface-card);
            border: 1px solid var(--sw-border);
            border-radius: var(--sw-radius-xl);
            box-shadow: var(--sw-shadow-sm);
        }

        .sw-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-weight: 600;
            border-radius: var(--sw-radius);
            transition: all 150ms ease;
            cursor: pointer;
            border: none;
            text-decoration: none;
        }

        .sw-btn-primary {
            background: var(--sw-primary);
            color: #ffffff !important;
        }
        .sw-btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .sw-btn-ghost {
            background: transparent;
            color: var(--sw-text-secondary);
        }
        .sw-btn-ghost:hover {
            background: var(--sw-surface-hover);
            color: var(--sw-text-primary);
        }
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
