<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
      data-theme="{{ session('theme', config('stackway.theme.mode', 'light')) }}"
      data-bs-theme="{{ session('theme', config('stackway.theme.mode', 'light')) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $appSettingName = setting('app_name', config('app.name', 'InApp'));
        $appFavicon = setting('app_favicon');
        $faviconUrl = $appFavicon ? asset('storage/' . $appFavicon) : asset('assets/images/favicon_io/favicon-32x32.png');
        $appleFaviconUrl = $appFavicon ? asset('storage/' . $appFavicon) : asset('assets/images/favicon_io/apple-touch-icon.png');
        $primaryColor = setting('primary_color', config('stackway.theme.colors.primary', '#C85A32'));
    @endphp

    <title>@yield('title', 'تسجيل الدخول') — {{ $appSettingName }}</title>

    {{-- Favicons --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $appleFaviconUrl }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $faviconUrl }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" href="{{ $faviconUrl }}">

    {{-- Fonts (Poppins & Arabic) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap 5.3 (RTL / LTR) --}}
    @if(app()->getLocale() === 'ar')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    @endif

    {{-- Tabler Icons --}}
    <link rel="stylesheet" href="{{ asset('assets/tabler-icons/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.35.0/tabler-icons.min.css">

    {{-- InApp Design System Overrides & Color Variables --}}
    <style>
        :root {
            /* 🎨 Palette: Terracotta + Sand + Deep Olive */
            --sw-primary: {{ $primaryColor }};
            --sw-primary-hover: #B84722;
            --sw-primary-rgb: 200, 90, 50;

            /* Hook into Bootstrap 5 Tokens */
            --bs-primary: var(--sw-primary);
            --bs-primary-rgb: var(--sw-primary-rgb);
            --bs-link-color: var(--sw-primary);
            --bs-link-hover-color: var(--sw-primary-hover);
            --bs-body-font-family: 'Poppins', 'IBM Plex Sans Arabic', -apple-system, sans-serif;
            --bs-body-bg: #FAF7F2;
            --bs-card-bg: #FFFFFF;
            --bs-card-border-color: #E8E2D9;
            --bs-border-color: #E8E2D9;
        }

        [dir="rtl"] {
            --bs-body-font-family: 'IBM Plex Sans Arabic', 'Poppins', -apple-system, sans-serif;
        }

        /* ── Dark Mode: Warm Tinted Black (#14110F), strictly never navy/slate ── */
        [data-theme="dark"], .dark {
            --bs-body-bg: #14110F;
            --bs-body-color: #F5EFEB;
            --bs-card-bg: #1C1815;
            --bs-card-border-color: #332B25;
            --bs-border-color: #332B25;
        }

        body {
            background-color: var(--bs-body-bg);
            font-family: var(--bs-body-font-family);
            min-height: 100vh;
        }

        .btn-primary {
            background-color: var(--sw-primary) !important;
            border-color: var(--sw-primary) !important;
            color: #FFFFFF !important;
            box-shadow: 0 2px 6px rgba(230, 98, 57, 0.25);
            transition: all 0.2s ease;
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--sw-primary-hover) !important;
            border-color: var(--sw-primary-hover) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(230, 98, 57, 0.35);
        }

        .form-control:focus {
            border-color: var(--sw-primary) !important;
            box-shadow: 0 0 0 0.25rem rgba(230, 98, 57, 0.2) !important;
        }

        .form-check-input:checked {
            background-color: var(--sw-primary) !important;
            border-color: var(--sw-primary) !important;
        }

        .theme-toggle-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid #dee2e6;
            background: #ffffff;
            color: #495057;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: all 0.2s ease;
        }

        [dir="rtl"] .theme-toggle-btn {
            right: auto;
            left: 20px;
        }

        .theme-toggle-btn:hover {
            color: var(--sw-primary);
            border-color: var(--sw-primary);
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- Dark/Light Mode Switcher --}}
    <button type="button" onclick="window.toggleTheme()" class="theme-toggle-btn" title="تغيير المظهر">
        <i class="ti ti-moon" id="theme-moon-icon"></i>
        <i class="ti ti-sun d-none" id="theme-sun-icon"></i>
    </button>

    {{-- InApp Signin Page Structure --}}
    <div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
        <div class="card shadow-sm border-0" style="max-width: 440px; width: 100%; border-radius: 12px;">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    @php
                        $customLogo = setting('app_logo');
                    @endphp
                    <a href="{{ url('/') }}" class="mb-3 d-inline-flex align-items-center justify-content-center text-decoration-none">
                        @if($customLogo)
                            <img src="{{ asset('storage/' . $customLogo) }}" alt="{{ $appSettingName }}" style="max-height: 48px; max-width: 220px; object-fit: contain;">
                        @else
                            <img src="{{ asset('assets/images/logo-icon.svg') }}" alt="" width="36" height="36">
                            <span class="ms-2 fw-bold fs-4" style="letter-spacing: -0.5px; color: var(--sw-text-primary);">
                                {{ $appSettingName }}
                            </span>
                        @endif
                    </a>
                    <h1 class="card-title h5 fw-bold mb-1">@yield('heading', 'تسجيل الدخول إلى حسابك')</h1>
                    <p class="text-secondary small mb-0">@yield('subheading', 'أدخل بيانات حسابك للمتابعة إلى لوحة التحكم')</p>
                </div>

                @yield('content')
            </div>
        </div>
    </div>

    {{-- Bootstrap Bundle JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Theme Mode Script --}}
    <script>
        (function() {
            const savedTheme = localStorage.getItem('sw_theme') || "{{ config('stackway.theme.mode', 'light') }}";
            let theme = savedTheme;
            if (savedTheme === 'system') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                theme = prefersDark ? 'dark' : 'light';
            }
            document.documentElement.setAttribute('data-theme', theme);
            document.documentElement.setAttribute('data-bs-theme', theme);
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            updateIcons(theme);
        })();

        window.toggleTheme = function() {
            const current = document.documentElement.getAttribute('data-theme') || 'light';
            const next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            document.documentElement.setAttribute('data-bs-theme', next);
            if (next === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            localStorage.setItem('sw_theme', next);
            updateIcons(next);
        };

        function updateIcons(theme) {
            const sun = document.getElementById('theme-sun-icon');
            const moon = document.getElementById('theme-moon-icon');
            if (sun && moon) {
                if (theme === 'dark') {
                    sun.classList.remove('d-none');
                    moon.classList.add('d-none');
                } else {
                    sun.classList.add('d-none');
                    moon.classList.remove('d-none');
                }
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
