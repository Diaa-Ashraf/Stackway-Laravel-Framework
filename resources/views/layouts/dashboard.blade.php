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
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- Design System Tokens & Global Styles --}}
    <style>
        [x-cloak] { display: none !important; }
        @media (min-width: 1024px) { .sw-mobile-toggle { display: none !important; } }

        :root, [data-theme="light"] {
            --sw-primary: #4F46E5;
            --sw-primary-hover: #4338CA;
            --sw-primary-light: #6366F1;
            --sw-primary-50: #EEF2FF;
            --sw-primary-100: #E0E7FF;
            --sw-secondary: #0284C7;
            --sw-secondary-hover: #0369A1;
            --sw-accent: #D97706;
            --sw-success: #16A34A;
            --sw-success-50: #F0FDF4;
            --sw-danger: #DC2626;
            --sw-danger-50: #FEF2F2;
            --sw-warning: #D97706;
            --sw-info: #0284C7;
            --sw-surface: #F8FAFC;
            --sw-surface-card: #FFFFFF;
            --sw-surface-elevated: #FFFFFF;
            --sw-surface-hover: #F1F5F9;
            --sw-surface-pressed: #E2E8F0;
            --sw-text-primary: #0F172A;
            --sw-text-secondary: #334155;
            --sw-text-muted: #64748B;
            --sw-text-inverse: #F8FAFC;
            --sw-border: #E2E8F0;
            --sw-border-hover: #CBD5E1;
            --sw-sidebar-width: 256px;
            --sw-sidebar-collapsed-width: 68px;
            --sw-header-height: 64px;
            --sw-radius-sm: 6px;
            --sw-radius: 10px;
            --sw-radius-lg: 14px;
            --sw-radius-xl: 18px;
            --sw-radius-full: 9999px;
            --sw-shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --sw-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.08), 0 1px 2px -1px rgba(0, 0, 0, 0.08);
            --sw-shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.07), 0 2px 4px -2px rgba(0, 0, 0, 0.07);
            --sw-shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -4px rgba(0, 0, 0, 0.08);
            --sun-display: none;
            --moon-display: block;
        }

        [data-theme="dark"], .dark {
            --sw-primary: #6366F1;
            --sw-primary-hover: #818CF8;
            --sw-primary-light: #A5B4FC;
            --sw-primary-50: rgba(99, 102, 241, 0.12);
            --sw-primary-100: rgba(99, 102, 241, 0.22);
            --sw-secondary: #38BDF8;
            --sw-secondary-hover: #0EA5E9;
            --sw-accent: #FBBF24;
            --sw-success: #22C55E;
            --sw-success-50: rgba(34, 197, 94, 0.12);
            --sw-danger: #EF4444;
            --sw-danger-50: rgba(239, 68, 68, 0.12);
            --sw-warning: #F59E0B;
            --sw-info: #38BDF8;
            --sw-surface: #090D16;
            --sw-surface-card: #0F172A;
            --sw-surface-elevated: #1E293B;
            --sw-surface-hover: #1E293B;
            --sw-surface-pressed: #334155;
            --sw-text-primary: #F8FAFC;
            --sw-text-secondary: #CBD5E1;
            --sw-text-muted: #94A3B8;
            --sw-text-inverse: #0F172A;
            --sw-border: #1E293B;
            --sw-border-hover: #334155;
            --sun-display: block;
            --moon-display: none;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: var(--sw-surface);
            color: var(--sw-text-primary);
            font-family: 'IBM Plex Sans Arabic', 'Inter', system-ui, -apple-system, sans-serif;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
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
            transition: width 250ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sw-sidebar.collapsed {
            width: var(--sw-sidebar-collapsed-width);
        }

        .sw-sidebar-logo {
            height: var(--sw-header-height);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0 1.25rem;
            border-bottom: 1px solid var(--sw-border);
        }

        .sw-sidebar-logo-icon {
            width: 34px;
            height: 34px;
            border-radius: var(--sw-radius);
            background: var(--sw-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            flex-shrink: 0;
        }

        .sw-sidebar-logo-text {
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--sw-text-primary);
            letter-spacing: -0.02em;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 200ms ease;
        }

        .sw-sidebar.collapsed .sw-sidebar-logo-text {
            opacity: 0;
            pointer-events: none;
        }

        .sw-sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 0.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .sw-sidebar-section-title {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--sw-text-muted);
            padding: 0.75rem 0.75rem 0.35rem 0.75rem;
            white-space: nowrap;
        }

        .sw-sidebar.collapsed .sw-sidebar-section-title {
            display: none;
        }

        .sw-sidebar-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 0.75rem;
            border-radius: var(--sw-radius);
            color: var(--sw-text-secondary);
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 150ms ease;
            white-space: nowrap;
        }

        .sw-sidebar-item:hover {
            background: var(--sw-surface-hover);
            color: var(--sw-text-primary);
        }

        .sw-sidebar-item.active {
            background: var(--sw-primary-50);
            color: var(--sw-primary);
            font-weight: 600;
        }

        .sw-sidebar.collapsed .sw-sidebar-item {
            justify-content: center;
            padding: 0.6rem 0;
        }

        .sw-sidebar.collapsed .sw-sidebar-item-text {
            display: none;
        }

        .sw-sidebar-footer {
            padding: 0.75rem;
            border-top: 1px solid var(--sw-border);
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
            transition: inset-inline-start 250ms cubic-bezier(0.4, 0, 0.2, 1);
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
            transition: margin-inline-start 250ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sw-main.collapsed {
            margin-inline-start: var(--sw-sidebar-collapsed-width);
        }

        .sw-content {
            flex: 1;
            padding: 1.75rem;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
        }

        .sw-card {
            background: var(--sw-surface-card);
            border: 1px solid var(--sw-border);
            border-radius: var(--sw-radius-xl);
            box-shadow: var(--sw-shadow-sm);
            transition: border-color 150ms ease, box-shadow 150ms ease;
        }

        .sw-card:hover {
            border-color: var(--sw-border-hover);
        }

        .sw-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            border-radius: var(--sw-radius);
            padding: 0.5rem 1rem;
            transition: all 150ms ease;
            cursor: pointer;
            border: 1px solid transparent;
            text-decoration: none;
            line-height: 1.25;
        }

        .sw-btn:focus-visible {
            outline: 2px solid var(--sw-primary);
            outline-offset: 2px;
        }

        .sw-btn-primary {
            background: var(--sw-primary);
            color: #ffffff !important;
            border-color: var(--sw-primary);
        }

        .sw-btn-primary:hover {
            background: var(--sw-primary-hover);
            border-color: var(--sw-primary-hover);
        }

        .sw-btn-secondary {
            background: var(--sw-surface-card);
            color: var(--sw-text-primary) !important;
            border-color: var(--sw-border);
        }

        .sw-btn-secondary:hover {
            background: var(--sw-surface-hover);
            border-color: var(--sw-border-hover);
        }

        .sw-btn-ghost {
            background: transparent;
            color: var(--sw-text-secondary);
            border-color: transparent;
        }

        .sw-btn-ghost:hover {
            background: var(--sw-surface-hover);
            color: var(--sw-text-primary);
        }

        .sw-btn-icon {
            padding: 0.5rem;
            width: 38px;
            height: 38px;
        }

        .sw-input {
            width: 100%;
            padding: 0.55rem 0.85rem;
            font-size: 0.875rem;
            border-radius: var(--sw-radius);
            border: 1px solid var(--sw-border);
            background: var(--sw-surface-card);
            color: var(--sw-text-primary);
            transition: all 150ms ease;
            outline: none;
        }

        .sw-input:focus {
            border-color: var(--sw-primary);
            box-shadow: 0 0 0 3px var(--sw-primary-50);
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
    <div x-show="mobileOpen" x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-150"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 backdrop-blur-xs z-30 lg:hidden" @click="mobileOpen = false" style="display:none;"></div>

    {{-- Sidebar --}}
    <x-sw-sidebar :items="$sidebarItems ?? []" />

    {{-- Main Content Wrapper --}}
    <div class="sw-main" :class="{ 'lg:ml-[68px]': sidebarCollapsed, 'lg:ml-[256px]': !sidebarCollapsed }">

        {{-- Header --}}
        <x-sw-header :breadcrumbs="$breadcrumbs ?? []" />

        {{-- Page Content --}}
        <main class="sw-content">
            {{-- Dynamic Page Header if header-actions defined --}}
            @hasSection('header-actions')
                <div class="mb-6 flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-2xl font-bold" style="color: var(--sw-text-primary); letter-spacing: -0.02em;">@yield('title')</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        @yield('header-actions')
                    </div>
                </div>
            @elseif(isset($pageTitle))
                <div class="mb-6 flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-2xl font-bold" style="color: var(--sw-text-primary); letter-spacing: -0.02em;">{{ $pageTitle }}</h1>
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
