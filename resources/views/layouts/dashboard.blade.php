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

    <title>@yield('title', $title ?? $appSettingName) — {{ $appSettingName }}</title>

    {{-- Dynamic Favicons --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $appleFaviconUrl }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $faviconUrl }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" href="{{ $faviconUrl }}">

    {{-- Fonts (Poppins & IBM Plex Sans Arabic) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    {{-- Tabler Icons Webfont --}}
    <link rel="stylesheet" href="{{ asset('assets/tabler-icons/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.35.0/tabler-icons.min.css">

    {{-- Bootstrap 5.3 (RTL / LTR) --}}
    @if(app()->getLocale() === 'ar')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    @endif

    {{-- ApexCharts Library --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    {{-- Design System Tokens Dynamic Inline Fallback --}}
    <style>
        :root {
            --sw-primary: {{ $primaryColor }};
            --sw-accent: {{ config('stackway.theme.colors.accent', '#3A5A40') }};
            --sw-secondary: {{ config('stackway.theme.colors.secondary', '#5C554E') }};
            --sw-success: {{ config('stackway.theme.colors.success', '#3A5A40') }};
            --sw-danger: {{ config('stackway.theme.colors.danger', '#C0392B') }};
            --sw-warning: {{ config('stackway.theme.colors.warning', '#D48B28') }};
            --sw-info: {{ config('stackway.theme.colors.info', '#4A7C59') }};
        }
        [x-cloak] { display: none !important; }
    </style>

    {{-- Vite CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="antialiased">

    {{-- InApp Mobile Overlay --}}
    <div id="overlay" class="overlay"></div>

    {{-- InApp Topbar --}}
    <nav id="topbar" class="topbar">
        <div class="d-flex align-items-center gap-2">
            {{-- Desktop Sidebar Collapse Toggle --}}
            <button id="toggleBtn" class="btn btn-light btn-icon btn-sm d-none d-lg-inline-flex" type="button" title="Toggle Sidebar">
                <i class="ti ti-menu-2 fs-5"></i>
            </button>

            {{-- Mobile Sidebar Open Button --}}
            <button id="mobileBtn" class="btn btn-light btn-icon btn-sm d-lg-none" type="button" title="Open Menu">
                <i class="ti ti-menu-2 fs-5"></i>
            </button>

            {{-- Breadcrumb / Current Page Title --}}
            <div class="d-none d-md-flex align-items-center ms-2">
                <span class="fw-semibold text-secondary small">
                    @yield('title', $title ?? 'لوحة التحكم')
                </span>
            </div>
        </div>

        {{-- Topbar Right Actions --}}
        <div class="d-flex align-items-center gap-2">
            {{-- Search Bar (Desktop) --}}
            <div class="d-none d-md-block position-relative me-1" style="width: 220px;">
                <input type="text" class="form-control form-control-sm" placeholder="بحث سريع..." style="border-radius: 9999px; padding-inline-start: 2.25rem; padding-inline-end: 1rem;">
                <i class="ti ti-search position-absolute top-50 translate-middle-y text-muted" style="inset-inline-start: 0.75rem;"></i>
            </div>

            {{-- Dark / Light Mode Toggle --}}
            <button onclick="toggleTheme()" class="btn btn-light btn-icon btn-sm rounded-circle" type="button" title="تغيير المظهر (Light/Dark)">
                <i class="ti ti-sun" style="display: var(--sun-display, none);"></i>
                <i class="ti ti-moon" style="display: var(--moon-display, block);"></i>
            </button>

            {{-- Notifications Dropdown (InApp Rich List) --}}
            <div class="position-relative" x-data="{ open: false }">
                <button @click="open = !open" class="btn btn-light btn-icon btn-sm rounded-circle position-relative" type="button">
                    <i class="ti ti-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px; padding: 2px 5px; margin-top: 6px; margin-left: -6px;">
                        3
                    </span>
                </button>

                <div x-show="open" @click.away="open = false" x-transition
                     class="dropdown-menu dropdown-menu-end p-0 shadow-lg"
                     style="min-width: 300px; display: none;" x-cloak>
                    <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
                        <span class="fw-bold small">الإشعارات</span>
                        <span class="badge bg-primary-subtle text-primary">3 جديدة</span>
                    </div>
                    <ul class="list-unstyled p-0 m-0">
                        <li class="p-3 border-bottom">
                            <div class="d-flex gap-3">
                                <img src="{{ asset('assets/images/avatar/avatar-1.jpg') }}" alt="" class="avatar avatar-sm rounded-circle" onerror="this.src='https://ui-avatars.com/api/?name=User&background=E66239&color=fff'" />
                                <div class="flex-grow-1 small">
                                    <p class="mb-0 fw-semibold">طلب جديد مسجل #1024</p>
                                    <p class="mb-1 text-muted" style="font-size: 12px;">تم إنشاء طلب جديد بواسطة العميل</p>
                                    <div class="text-secondary" style="font-size: 11px;">منذ 5 دقائق</div>
                                </div>
                            </div>
                        </li>
                        <li class="p-3 border-bottom">
                            <div class="d-flex gap-3">
                                <img src="{{ asset('assets/images/avatar/avatar-2.jpg') }}" alt="" class="avatar avatar-sm rounded-circle" onerror="this.src='https://ui-avatars.com/api/?name=Order&background=00C951&color=fff'" />
                                <div class="flex-grow-1 small">
                                    <p class="mb-0 fw-semibold">تأكيد عملية الدفع</p>
                                    <p class="mb-1 text-muted" style="font-size: 12px;">تم استلام دفعة بقيمة $299</p>
                                    <div class="text-secondary" style="font-size: 11px;">منذ 45 دقيقة</div>
                                </div>
                            </div>
                        </li>
                        <li class="p-3 border-bottom">
                            <div class="d-flex gap-3">
                                <img src="{{ asset('assets/images/avatar/avatar-4.jpg') }}" alt="" class="avatar avatar-sm rounded-circle" onerror="this.src='https://ui-avatars.com/api/?name=Admin&background=00B8DB&color=fff'" />
                                <div class="flex-grow-1 small">
                                    <p class="mb-0 fw-semibold">مستخدم جديد مسجل</p>
                                    <p class="mb-1 text-muted" style="font-size: 12px;">انضمام مستخدم جديد للنظام</p>
                                    <div class="text-secondary" style="font-size: 11px;">منذ ساعتين</div>
                                </div>
                            </div>
                        </li>
                        <li class="p-2 text-center">
                            <a href="#" class="text-primary small fw-semibold">عرض كافة الإشعارات</a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- User Profile Dropdown --}}
            <div class="position-relative ms-1" x-data="{ userMenu: false }">
                <a href="javascript:void(0)" @click="userMenu = !userMenu" class="d-flex align-items-center gap-2 text-decoration-none">
                    <img src="{{ asset('assets/images/avatar/avatar-1.jpg') }}" alt="Avatar" class="avatar avatar-sm rounded-circle" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=E66239&color=fff'">
                    <span class="d-none d-md-inline fw-semibold text-secondary small">{{ Auth::user()->name ?? 'المدير' }}</span>
                    <i class="ti ti-chevron-down text-muted small d-none d-md-inline"></i>
                </a>

                <div x-show="userMenu" @click.away="userMenu = false" x-transition
                     class="dropdown-menu dropdown-menu-end p-0 shadow-lg"
                     style="min-width: 220px; display: none;" x-cloak>
                    <div class="d-flex gap-3 align-items-center border-bottom border-dashed px-3 py-3">
                        <img src="{{ asset('assets/images/avatar/avatar-1.jpg') }}" alt="" class="avatar avatar-md rounded-circle" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=E66239&color=fff'">
                        <div class="overflow-hidden">
                            <h6 class="mb-0 small fw-bold text-truncate">{{ Auth::user()->name ?? 'المدير' }}</h6>
                            <p class="mb-0 text-muted text-truncate" style="font-size: 11px;">{{ Auth::user()->email ?? 'admin@stackway.local' }}</p>
                        </div>
                    </div>
                    <div class="p-2 d-flex flex-column gap-1 small">
                        <a href="{{ Route::has('stackway.dashboard') ? route('stackway.dashboard') : url('/admin') }}" class="d-flex align-items-center gap-2 px-2 py-1.5 rounded text-secondary">
                            <i class="ti ti-dashboard"></i>
                            <span>الرئيسية</span>
                        </a>
                        @if(Route::has('profile.edit'))
                            <a href="{{ route('profile.edit') }}" class="d-flex align-items-center gap-2 px-2 py-1.5 rounded text-secondary">
                                <i class="ti ti-user-cog"></i>
                                <span>إعدادات الحساب</span>
                            </a>
                        @endif
                        <div class="border-top my-1"></div>
                        @if(Route::has('logout'))
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-100 d-flex align-items-center gap-2 px-2 py-1.5 rounded text-danger border-0 bg-transparent text-start">
                                    <i class="ti ti-logout"></i>
                                    <span>تسجيل الخروج</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- InApp Sidebar --}}
    <aside id="sidebar" class="sidebar">
        {{-- Logo Area --}}
        @php
            $customLogo = setting('app_logo');
        @endphp
        <div class="logo-area">
            <a href="{{ Route::has('stackway.dashboard') ? route('stackway.dashboard') : url('/admin') }}" class="d-flex align-items-center text-decoration-none">
                @if($customLogo)
                    <img src="{{ asset('storage/' . $customLogo) }}" alt="{{ $appSettingName }}" style="max-height: 36px; max-width: 175px; object-fit: contain;">
                @else
                    <img src="{{ asset('assets/images/logo-icon.svg') }}" alt="Icon" width="26" height="26">
                    <span class="logo-text ms-2 fw-bold fs-5" style="letter-spacing: -0.3px; color: var(--sw-text-primary);">
                        {{ $appSettingName }}
                    </span>
                @endif
            </a>
        </div>

        {{-- Navigation Menu --}}
        <ul class="nav flex-column">
            {{-- Main Section --}}
            <li class="nav-section-title"><small class="nav-text">الرئيسية</small></li>

            @php
                $dashRoute = Route::has('stackway.dashboard') ? route('stackway.dashboard') : (Route::has('dashboard') ? route('dashboard') : url('/admin'));
                $isDashActive = request()->routeIs('stackway.dashboard') || request()->routeIs('dashboard') || request()->is('admin');
            @endphp
            <li>
                <a class="nav-link {{ $isDashActive ? 'active' : '' }}" href="{{ $dashRoute }}">
                    <i class="ti ti-home"></i>
                    <span class="nav-text">لوحة التحكم</span>
                </a>
            </li>

            {{-- Auto-Discovered Modules Section --}}
            @php
                $modulesPath = base_path(config('stackway.module.base_path', 'app/Modules'));
                $modulesList = [];
                if (\Illuminate\Support\Facades\File::isDirectory($modulesPath)) {
                    foreach (\Illuminate\Support\Facades\File::directories($modulesPath) as $mDir) {
                        $mName = basename($mDir);
                        $mSnake = \Illuminate\Support\Str::snake($mName);
                        $mRoute = "{$mSnake}.index";
                        if (\Illuminate\Support\Facades\Route::has($mRoute)) {
                            $mLabel = match($mName) {
                                'Product' => 'المخزون والمنتجات',
                                'Note' => 'الملاحظات والمهام',
                                'Order' => 'الطلبات والمبيعات',
                                'Customer', 'Client' => 'العملاء',
                                'Setting' => 'إعدادات النظام',
                                default => \Illuminate\Support\Str::headline($mName),
                            };
                            $mIcon = match($mName) {
                                'Product' => 'ti ti-box-seam',
                                'Note' => 'ti ti-notes',
                                'Order' => 'ti ti-receipt',
                                'Customer', 'Client' => 'ti ti-users',
                                'Setting' => 'ti ti-settings',
                                default => 'ti ti-layout-grid',
                            };
                            $modulesList[] = [
                                'name' => $mName,
                                'label' => $mLabel,
                                'url' => route($mRoute),
                                'icon' => $mIcon,
                                'active' => request()->routeIs("{$mSnake}.*"),
                            ];
                        }
                    }
                }
            @endphp

            @if(count($modulesList) > 0)
                <li class="nav-section-title mt-2"><small class="nav-text">الوحدات البرمجية</small></li>
                @foreach($modulesList as $mItem)
                    <li>
                        <a class="nav-link {{ $mItem['active'] ? 'active' : '' }}" href="{{ $mItem['url'] }}">
                            <i class="{{ $mItem['icon'] }}"></i>
                            <span class="nav-text">{{ $mItem['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            @endif

            {{-- Quick Actions Section --}}
            @if(Route::has('product.create'))
                <li class="nav-section-title mt-2"><small class="nav-text">إجراءات سريعة</small></li>
                <li>
                    <a class="nav-link {{ request()->routeIs('product.create') ? 'active' : '' }}" href="{{ route('product.create') }}">
                        <i class="ti ti-plus"></i>
                        <span class="nav-text">إضافة منتج جديد</span>
                    </a>
                </li>
            @endif

            {{-- Account Section --}}
            <li class="nav-section-title mt-3"><small class="nav-text">الحساب والنظام</small></li>
            @if(Route::has('profile.edit'))
                <li>
                    <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                        <i class="ti ti-user-cog"></i>
                        <span class="nav-text">الملف الشخصي</span>
                    </a>
                </li>
            @endif
            @if(Route::has('setting.index'))
                <li>
                    <a class="nav-link {{ request()->routeIs('setting.*') ? 'active' : '' }}" href="{{ route('setting.index') }}">
                        <i class="ti ti-settings"></i>
                        <span class="nav-text">إعدادات النظام والواجهة</span>
                    </a>
                </li>
            @endif
            @if(Route::has('logout'))
                <li>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar">
                        @csrf
                        <a class="nav-link text-danger" href="javascript:void(0)" onclick="document.getElementById('logout-form-sidebar').submit();">
                            <i class="ti ti-logout"></i>
                            <span class="nav-text">تسجيل الخروج</span>
                        </a>
                    </form>
                </li>
            @endif
        </ul>
    </aside>

    {{-- Main Content Container (Fluid 100% Responsive) --}}
    <main id="content" class="content">
        <div class="content-body">
            <div class="container-fluid p-0">
                {{-- Flash Alerts --}}
                @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center gap-2 p-3 mb-4 rounded-3 border-0 bg-success-subtle text-success">
                        <i class="ti ti-check fs-5"></i>
                        <div class="small fw-semibold">{{ session('success') }}</div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger d-flex align-items-center gap-2 p-3 mb-4 rounded-3 border-0 bg-danger-subtle text-danger">
                        <i class="ti ti-alert-circle fs-5"></i>
                        <div class="small fw-semibold">{{ session('error') }}</div>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning d-flex align-items-center gap-2 p-3 mb-4 rounded-3 border-0 bg-warning-subtle text-warning">
                        <i class="ti ti-alert-triangle fs-5"></i>
                        <div class="small fw-semibold">{{ session('warning') }}</div>
                    </div>
                @endif

                {{-- Dynamic Slot or Content --}}
                @if(isset($slot) && !empty((string) $slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </div>
        </div>

        {{-- InApp Modern Footer --}}
        <footer class="text-center py-3 mt-auto text-secondary small border-top" style="background: var(--sw-surface);">
            <p class="mb-0">
                حقوق النشر &copy; {{ date('Y') }} {{ config('app.name', 'Stackway Core') }}. مبني بمعمارية معيارية ذكية.
            </p>
        </footer>
    </main>

    {{-- Core Sidebar & Theme Javascript --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const topbar = document.getElementById('topbar');
            const toggleBtn = document.getElementById('toggleBtn');
            const mobileBtn = document.getElementById('mobileBtn');
            const overlay = document.getElementById('overlay');

            // Load saved sidebar state
            const savedSidebarState = localStorage.getItem('inapp_sidebar_collapsed');
            if (savedSidebarState === 'true' && window.innerWidth >= 992) {
                if (sidebar) sidebar.classList.add('collapsed');
                if (content) content.classList.add('full');
                if (topbar) topbar.classList.add('full');
            }

            // Desktop collapse
            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    const isCollapsed = sidebar ? sidebar.classList.toggle('collapsed') : false;
                    if (content) content.classList.toggle('full');
                    if (topbar) topbar.classList.toggle('full');
                    localStorage.setItem('inapp_sidebar_collapsed', isCollapsed ? 'true' : 'false');
                });
            }

            // Mobile sidebar open
            if (mobileBtn) {
                mobileBtn.addEventListener('click', () => {
                    if (sidebar) sidebar.classList.add('mobile-show');
                    if (overlay) overlay.classList.add('show');
                });
            }

            // Click outside to close (mobile)
            if (overlay) {
                overlay.addEventListener('click', () => {
                    if (sidebar) sidebar.classList.remove('mobile-show');
                    if (overlay) overlay.classList.remove('show');
                });
            }

            // Theme toggle logic
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
            };

            const savedTheme = localStorage.getItem('sw_theme') || "{{ config('stackway.theme.mode', 'light') }}";
            let activeTheme = savedTheme;
            if (savedTheme === 'system') {
                activeTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }
            document.documentElement.setAttribute('data-theme', activeTheme);
            document.documentElement.setAttribute('data-bs-theme', activeTheme);
            if (activeTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        });
    </script>

    {{-- Bootstrap Bundle JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
