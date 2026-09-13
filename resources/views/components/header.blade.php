{{-- Stackway Header Component --}}
@props(['breadcrumbs' => []])

<header class="sw-header"
        :style="sidebarCollapsed ? 'left: var(--sw-sidebar-collapsed-width)' : 'left: var(--sw-sidebar-width)'">
    <div class="flex items-center gap-4">
        {{-- Breadcrumbs --}}
        @if(!empty($breadcrumbs))
            <x-sw-breadcrumb :items="$breadcrumbs" />
        @endif
    </div>

    <div class="flex items-center gap-3">
        {{-- Search --}}
        <div class="hidden md:block relative">
            <input type="text" placeholder="بحث..."
                   class="sw-input pl-10 pr-4 py-2 text-sm w-64"
                   style="background: var(--sw-surface); border-radius: var(--sw-radius-full);">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color: var(--sw-text-muted);"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
        </div>

        {{-- Theme Toggle --}}
        <button onclick="toggleTheme()" class="sw-btn sw-btn-ghost sw-btn-icon"
                style="border-radius: var(--sw-radius);" type="button" title="تغيير المظهر">
            {{-- Sun icon (shown in dark mode) --}}
            <svg class="w-5 h-5" style="display: var(--sun-display, none);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
            </svg>
            {{-- Moon icon (shown in light mode) --}}
            <svg class="w-5 h-5" style="display: var(--moon-display, block);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
            </svg>
        </button>

        {{-- Notifications --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="sw-btn sw-btn-ghost sw-btn-icon relative" type="button"
                    style="border-radius: var(--sw-radius);">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
                <span class="absolute -top-0.5 -right-0.5 w-2 h-2 rounded-full"
                      style="background: var(--sw-danger);"></span>
            </button>

            {{-- Notifications Dropdown --}}
            <div x-show="open" @click.away="open = false" x-transition
                 class="absolute right-0 mt-2 w-80 rounded-xl overflow-hidden z-50"
                 style="background: var(--sw-surface-card); border: 1px solid var(--sw-border); box-shadow: var(--sw-shadow-xl);"
                 x-cloak>
                <div class="p-4 border-b" style="border-color: var(--sw-border);">
                    <h3 class="font-semibold text-sm" style="color: var(--sw-text-primary);">الإشعارات</h3>
                </div>
                <div class="p-4 text-center text-sm" style="color: var(--sw-text-muted);">
                    لا توجد إشعارات جديدة
                </div>
            </div>
        </div>

        {{-- User Dropdown --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-black/5 transition" type="button">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold text-white"
                     style="background: linear-gradient(135deg, var(--sw-primary), var(--sw-secondary));">
                    {{ mb_substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <span class="hidden sm:block text-sm font-medium" style="color: var(--sw-text-primary);">
                    {{ Auth::user()->name ?? 'User' }}
                </span>
                <svg class="w-4 h-4" style="color: var(--sw-text-muted);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
            </button>

            <div x-show="open" @click.away="open = false" x-transition
                 class="absolute right-0 mt-2 w-56 rounded-xl overflow-hidden z-50"
                 style="background: var(--sw-surface-card); border: 1px solid var(--sw-border); box-shadow: var(--sw-shadow-xl);"
                 x-cloak>
                <div class="p-3 border-b" style="border-color: var(--sw-border);">
                    <p class="text-sm font-medium" style="color: var(--sw-text-primary);">{{ Auth::user()->name ?? '' }}</p>
                    <p class="text-xs" style="color: var(--sw-text-muted);">{{ Auth::user()->email ?? '' }}</p>
                </div>
                <div class="py-1">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm transition"
                       style="color: var(--sw-text-secondary);"
                       onmouseover="this.style.background='var(--sw-surface-hover)'"
                       onmouseout="this.style.background='transparent'">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        الملف الشخصي
                    </a>
                </div>
                <div class="border-t" style="border-color: var(--sw-border);">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-sm transition"
                                style="color: var(--sw-danger);"
                                onmouseover="this.style.background='var(--sw-surface-hover)'"
                                onmouseout="this.style.background='transparent'">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            تسجيل الخروج
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
    [data-theme="dark"] { --sun-display: block; --moon-display: none; }
    [data-theme="light"] { --sun-display: none; --moon-display: block; }
</style>
