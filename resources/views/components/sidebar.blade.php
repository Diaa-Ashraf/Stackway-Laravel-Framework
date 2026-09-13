{{-- Stackway Sidebar Component --}}
{{-- Usage: <x-sw-sidebar :items="$sidebarItems" /> --}}

@props(['items' => []])

<aside class="sw-sidebar sw-scrollbar"
       :class="{ 'collapsed': sidebarCollapsed, 'mobile-open': mobileOpen }"
       x-cloak>

    {{-- Logo Area --}}
    <div class="sw-sidebar-logo">
        <div class="sw-sidebar-logo-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
            </svg>
        </div>
        <span class="sw-sidebar-logo-text">{{ config('app.name', 'Stackway') }}</span>
    </div>

    {{-- Navigation --}}
    <nav class="sw-sidebar-nav">
        @forelse($items as $section)
            @if(isset($section['title']))
                <div class="sw-sidebar-section-title">{{ $section['title'] }}</div>
            @endif

            @foreach($section['items'] ?? [] as $item)
                <a href="{{ $item['url'] ?? '#' }}"
                   class="sw-sidebar-item {{ request()->routeIs($item['active'] ?? '') ? 'active' : '' }}"
                   @if(isset($item['tooltip']))
                       x-tooltip.placement.right="{{ $item['tooltip'] }}"
                   @endif>
                    {{-- Icon --}}
                    <span class="sw-sidebar-item-icon">
                        @if(isset($item['icon']))
                            {!! $item['icon'] !!}
                        @else
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        @endif
                    </span>
                    {{-- Text --}}
                    <span class="sw-sidebar-item-text">{{ $item['label'] ?? '' }}</span>

                    {{-- Badge --}}
                    @if(isset($item['badge']))
                        <span class="sw-sidebar-item-text ml-auto">
                            <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-medium rounded-full"
                                  style="background: var(--sw-primary); color: white; min-width: 20px;">
                                {{ $item['badge'] }}
                            </span>
                        </span>
                    @endif
                </a>

                {{-- Sub Items --}}
                @if(isset($item['children']) && count($item['children']) > 0)
                    <div class="pl-9" x-show="!sidebarCollapsed">
                        @foreach($item['children'] as $child)
                            <a href="{{ $child['url'] ?? '#' }}"
                               class="sw-sidebar-item text-sm py-1.5 {{ request()->routeIs($child['active'] ?? '') ? 'active' : '' }}">
                                <span class="sw-sidebar-item-text">{{ $child['label'] ?? '' }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            @endforeach
        @empty
            @php
                $dashboardRoute = Route::has('stackway.dashboard') ? route('stackway.dashboard') : (Route::has('dashboard') ? route('dashboard') : url('/admin'));

                // Dynamic Auto-Discovery of Modules
                $modulesPath = base_path(config('stackway.module.base_path', 'app/Modules'));
                $autoDiscoveredModules = [];
                if (\Illuminate\Support\Facades\File::isDirectory($modulesPath)) {
                    foreach (\Illuminate\Support\Facades\File::directories($modulesPath) as $dir) {
                        $mName = basename($dir);
                        $mSnake = \Illuminate\Support\Str::snake($mName);
                        $mRoute = "{$mSnake}.index";
                        if (\Illuminate\Support\Facades\Route::has($mRoute)) {
                            $mLabel = match($mName) {
                                'Product' => 'المنتجات',
                                'Note' => 'الملاحظات',
                                'Order' => 'الطلبات',
                                'Customer', 'Client' => 'العملاء',
                                default => \Illuminate\Support\Str::headline($mName),
                            };
                            $autoDiscoveredModules[] = [
                                'name'   => $mName,
                                'slug'   => $mSnake,
                                'label'  => $mLabel,
                                'route'  => $mRoute,
                                'active' => "{$mSnake}.*",
                            ];
                        }
                    }
                }
            @endphp

            {{-- Dashboard Home --}}
            <a href="{{ $dashboardRoute }}" class="sw-sidebar-item {{ request()->routeIs('stackway.dashboard') || request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="sw-sidebar-item-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                </span>
                <span class="sw-sidebar-item-text">لوحة التحكم</span>
            </a>

            @if(count($autoDiscoveredModules) > 0)
                <div class="sw-sidebar-section-title">الوحدات البرمجية</div>

                @foreach($autoDiscoveredModules as $m)
                    <a href="{{ route($m['route']) }}" class="sw-sidebar-item {{ request()->routeIs($m['active']) ? 'active' : '' }}">
                        <span class="sw-sidebar-item-icon">
                            @if($m['slug'] === 'product')
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                            @elseif($m['slug'] === 'note')
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                            @else
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                                </svg>
                            @endif
                        </span>
                        <span class="sw-sidebar-item-text">{{ $m['label'] }}</span>
                    </a>
                @endforeach
            @endif

            <div class="sw-sidebar-section-title">الحساب والإعدادات</div>

            @if(Route::has('profile.edit'))
                <a href="{{ route('profile.edit') }}" class="sw-sidebar-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <span class="sw-sidebar-item-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </span>
                    <span class="sw-sidebar-item-text">الملف الشخصي</span>
                </a>
            @endif
        @endforelse
    </nav>

    {{-- Sidebar Footer — Collapse Toggle --}}
    <div class="sw-sidebar-footer">
        <button @click="sidebarCollapsed = !sidebarCollapsed; localStorage.setItem('sw_sidebar', sidebarCollapsed ? 'collapsed' : 'expanded')"
                class="sw-sidebar-item w-full justify-center lg:justify-start" type="button">
            <span class="sw-sidebar-item-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                     :class="{ 'rotate-180': sidebarCollapsed }" style="transition: transform 300ms ease;">
                    <path d="M11 17l-5-5 5-5"/>
                    <path d="M18 17l-5-5 5-5"/>
                </svg>
            </span>
            <span class="sw-sidebar-item-text">طي القائمة</span>
        </button>
    </div>
</aside>

{{-- Mobile Toggle Button (shown in header on mobile) --}}
<button @click="mobileOpen = !mobileOpen"
        class="fixed top-4 left-4 z-50 lg:hidden sw-btn sw-btn-ghost p-2 rounded-lg"
        style="background: var(--sw-surface-card); box-shadow: var(--sw-shadow-md);" type="button">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path x-show="!mobileOpen" d="M4 6h16M4 12h16M4 18h16"/>
        <path x-show="mobileOpen" d="M6 18L18 6M6 6l12 12"/>
    </svg>
</button>
