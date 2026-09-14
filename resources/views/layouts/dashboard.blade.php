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

        /* ═══════════════════════════════════════════════════════
           🎨 Obsidian Teal — Stackway Design System Tokens
           Primary: Deep Teal | Secondary: Electric Cyan
           ═══════════════════════════════════════════════════════ */

        :root, [data-theme="light"] {
            --sw-primary: #0D9488;
            --sw-primary-hover: #0F766E;
            --sw-primary-light: #14B8A6;
            --sw-primary-50: #F0FDFA;
            --sw-primary-100: #CCFBF1;
            --sw-secondary: #0891B2;
            --sw-secondary-hover: #0E7490;
            --sw-accent: #D97706;
            --sw-success: #059669;
            --sw-success-50: #ECFDF5;
            --sw-danger: #E11D48;
            --sw-danger-50: #FFF1F2;
            --sw-warning: #D97706;
            --sw-info: #0284C7;
            --sw-surface: #FAFAF9;
            --sw-surface-card: #FFFFFF;
            --sw-surface-elevated: #FFFFFF;
            --sw-surface-hover: #F5F5F4;
            --sw-surface-pressed: #E7E5E4;
            --sw-text-primary: #0C0A09;
            --sw-text-secondary: #44403C;
            --sw-text-muted: #78716C;
            --sw-text-inverse: #FAFAF9;
            --sw-border: #E7E5E4;
            --sw-border-hover: #D6D3D1;
            --sw-sidebar-bg: #FFFFFF;
            --sw-sidebar-text: #57534E;
            --sw-sidebar-text-active: #0D9488;
            --sw-sidebar-hover: #F0FDFA;
            --sw-sidebar-active: #F0FDFA;
            --sw-sidebar-active-border: #0D9488;
            --sw-sidebar-border: #E7E5E4;
            --sw-sidebar-section: #A8A29E;
            --sw-sidebar-logo-bg: linear-gradient(135deg, #0D9488, #0F766E);
            --sw-sidebar-width: 256px;
            --sw-sidebar-collapsed-width: 68px;
            --sw-header-height: 64px;
            --sw-radius-sm: 6px;
            --sw-radius: 8px;
            --sw-radius-lg: 12px;
            --sw-radius-xl: 16px;
            --sw-radius-full: 9999px;
            --sw-shadow-sm: 0 1px 2px 0 rgba(12, 10, 9, 0.04);
            --sw-shadow: 0 1px 3px 0 rgba(12, 10, 9, 0.06), 0 1px 2px -1px rgba(12, 10, 9, 0.06);
            --sw-shadow-md: 0 4px 6px -1px rgba(12, 10, 9, 0.05), 0 2px 4px -2px rgba(12, 10, 9, 0.05);
            --sw-shadow-lg: 0 10px 15px -3px rgba(12, 10, 9, 0.06), 0 4px 6px -4px rgba(12, 10, 9, 0.06);
            --sw-glow-primary: 0 0 0 3px rgba(13, 148, 136, 0.20);
            --sun-display: none;
            --moon-display: block;
        }

        [data-theme="dark"], .dark {
            --sw-primary: #14B8A6;
            --sw-primary-hover: #2DD4BF;
            --sw-primary-light: #5EEAD4;
            --sw-primary-50: rgba(20, 184, 166, 0.12);
            --sw-primary-100: rgba(20, 184, 166, 0.20);
            --sw-secondary: #06B6D4;
            --sw-secondary-hover: #22D3EE;
            --sw-accent: #F59E0B;
            --sw-success: #10B981;
            --sw-success-50: rgba(16, 185, 129, 0.12);
            --sw-danger: #F43F5E;
            --sw-danger-50: rgba(244, 63, 94, 0.12);
            --sw-warning: #F59E0B;
            --sw-info: #38BDF8;
            --sw-surface: #09090B;
            --sw-surface-card: #18181B;
            --sw-surface-elevated: #27272A;
            --sw-surface-hover: #27272A;
            --sw-surface-pressed: #3F3F46;
            --sw-text-primary: #FAFAFA;
            --sw-text-secondary: #D4D4D8;
            --sw-text-muted: #A1A1AA;
            --sw-text-inverse: #18181B;
            --sw-border: #27272A;
            --sw-border-hover: #3F3F46;
            --sw-sidebar-bg: #0A0A0C;
            --sw-sidebar-text: #A1A1AA;
            --sw-sidebar-text-active: #FAFAFA;
            --sw-sidebar-hover: rgba(20, 184, 166, 0.08);
            --sw-sidebar-active: rgba(20, 184, 166, 0.15);
            --sw-sidebar-active-border: #14B8A6;
            --sw-sidebar-border: rgba(255, 255, 255, 0.06);
            --sw-sidebar-section: #71717A;
            --sw-sidebar-logo-bg: linear-gradient(135deg, #0D9488, #0F766E);
            --sw-glow-primary: 0 0 0 3px rgba(20, 184, 166, 0.25);
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
            -moz-osx-font-smoothing: grayscale;
        }

        /* ── Sidebar ── */
        .sw-sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            inset-inline-start: 0;
            width: var(--sw-sidebar-width);
            background: var(--sw-sidebar-bg);
            border-inline-end: 1px solid var(--sw-sidebar-border);
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
            border-bottom: 1px solid var(--sw-sidebar-border);
        }

        .sw-sidebar-logo-icon {
            width: 34px;
            height: 34px;
            border-radius: var(--sw-radius);
            background: var(--sw-sidebar-logo-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            flex-shrink: 0;
            box-shadow: 0 2px 8px -2px rgba(13, 148, 136, 0.4);
        }

        .sw-sidebar-logo-text {
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--sw-sidebar-text-active);
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
            color: var(--sw-sidebar-section);
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
            color: var(--sw-sidebar-text);
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 200ms cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
            position: relative;
        }

        .sw-sidebar-item:hover {
            background: var(--sw-sidebar-hover);
            color: var(--sw-sidebar-text-active);
        }

        .sw-sidebar-item.active {
            background: var(--sw-sidebar-active);
            color: var(--sw-sidebar-text-active);
            font-weight: 600;
            border-inline-start: 3px solid var(--sw-sidebar-active-border);
            padding-inline-start: calc(0.75rem - 3px);
        }

        .sw-sidebar.collapsed .sw-sidebar-item {
            justify-content: center;
            padding: 0.6rem 0;
        }

        .sw-sidebar.collapsed .sw-sidebar-item.active {
            border-inline-start: none;
            padding-inline-start: 0;
        }

        .sw-sidebar.collapsed .sw-sidebar-item-text {
            display: none;
        }

        .sw-sidebar-footer {
            padding: 0.75rem;
            border-top: 1px solid var(--sw-sidebar-border);
        }

        /* ── Header ── */
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
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        [data-theme="dark"] .sw-header {
            background: rgba(24, 24, 27, 0.85);
        }

        .sw-sidebar.collapsed ~ .sw-main .sw-header,
        .sw-sidebar.collapsed ~ .sw-header {
            inset-inline-start: var(--sw-sidebar-collapsed-width);
        }

        /* ── Main Content ── */
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

        /* ── Cards ── */
        .sw-card {
            background: var(--sw-surface-card);
            border: 1px solid var(--sw-border);
            border-radius: var(--sw-radius-xl);
            box-shadow: var(--sw-shadow-sm);
            transition: border-color 200ms ease, box-shadow 200ms ease, transform 200ms ease;
        }

        .sw-card:hover {
            border-color: var(--sw-border-hover);
            box-shadow: var(--sw-shadow);
        }

        /* ── Buttons ── */
        .sw-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            border-radius: var(--sw-radius);
            padding: 0.5rem 1rem;
            transition: all 200ms cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: 1px solid transparent;
            text-decoration: none;
            line-height: 1.25;
        }

        .sw-btn:focus-visible {
            outline: none;
            box-shadow: var(--sw-glow-primary);
        }

        .sw-btn-primary {
            background: var(--sw-primary);
            color: #ffffff !important;
            border-color: var(--sw-primary);
            box-shadow: 0 2px 8px -2px rgba(13, 148, 136, 0.35);
        }

        .sw-btn-primary:hover {
            background: var(--sw-primary-hover);
            border-color: var(--sw-primary-hover);
            box-shadow: 0 4px 12px -2px rgba(13, 148, 136, 0.45);
            transform: translateY(-1px);
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

        /* ── Inputs ── */
        .sw-input {
            width: 100%;
            padding: 0.55rem 0.85rem;
            font-size: 0.875rem;
            border-radius: var(--sw-radius);
            border: 1px solid var(--sw-border);
            background: var(--sw-surface-card);
            color: var(--sw-text-primary);
            transition: all 200ms cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
        }

        .sw-input:focus {
            border-color: var(--sw-primary);
            box-shadow: var(--sw-glow-primary);
        }

        /* ── Custom Scrollbar ── */
        .sw-sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }
        .sw-sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }
        .sw-sidebar-nav::-webkit-scrollbar-thumb {
            background: var(--sw-border-hover);
            border-radius: 9999px;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js (Core Interactivity: Sidebar, Dropdowns, Modals) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

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
    <div class="sw-main" :class="{ 'collapsed': sidebarCollapsed }">

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
