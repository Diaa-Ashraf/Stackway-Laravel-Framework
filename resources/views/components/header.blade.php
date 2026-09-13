{{-- Stackway Header Component --}}
@props(['breadcrumbs' => []])

<header class="sw-header">
    <div class="flex items-center gap-4">
        {{-- Breadcrumbs --}}
        @if(!empty($breadcrumbs))
            <x-sw-breadcrumb :items="$breadcrumbs" />
        @endif
    </div>

    <div class="flex items-center gap-2.5">
        {{-- Search --}}
        <div class="hidden md:block relative">
            <input type="text" placeholder="بحث..."
                   class="sw-input text-sm w-64"
                   style="padding-inline-start: 2.25rem; border-radius: var(--sw-radius-full); height: 38px;">
            <svg class="absolute top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none"
                 style="inset-inline-start: 0.85rem; color: var(--sw-text-muted);"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
        </div>

        {{-- Theme Toggle --}}
        <button onclick="toggleTheme()" class="sw-btn sw-btn-ghost sw-btn-icon"
                type="button" title="تغيير المظهر">
            {{-- Sun icon (shown in dark mode) --}}
            <svg class="w-4 h-4" style="display: var(--sun-display, none);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
            </svg>
            {{-- Moon icon (shown in light mode) --}}
            <svg class="w-4 h-4" style="display: var(--moon-display, block);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
            </svg>
        </button>

        {{-- Notifications --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="sw-btn sw-btn-ghost sw-btn-icon relative" type="button" title="الإشعارات">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
            </button>

            {{-- Notifications Dropdown --}}
            <div x-show="open" @click.away="open = false" x-transition
                 class="absolute mt-2 w-80 rounded-xl overflow-hidden z-50 shadow-lg"
                 style="inset-inline-end: 0; background: var(--sw-surface-card); border: 1px solid var(--sw-border);"
                 x-cloak>
                <div class="p-3.5 border-b flex items-center justify-between" style="border-color: var(--sw-border);">
                    <h3 class="font-bold text-sm" style="color: var(--sw-text-primary);">الإشعارات</h3>
                    <span class="text-xs font-mono" style="color: var(--sw-text-muted);">0 غير مقروء</span>
                </div>
                <div class="p-5 text-center text-xs" style="color: var(--sw-text-muted);">
                    لا توجد إشعارات جديدة حالياً
                </div>
            </div>
        </div>

        {{-- User Dropdown --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                    class="flex items-center gap-2 py-1 px-2 rounded-lg transition"
                    style="color: var(--sw-text-primary);"
                    onmouseover="this.style.background='var(--sw-surface-hover)'"
                    onmouseout="this.style.background='transparent'"
                    type="button">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                     style="background: var(--sw-primary);">
                    {{ mb_substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <span class="hidden sm:block text-xs font-semibold" style="color: var(--sw-text-primary);">
                    {{ Auth::user()->name ?? 'User' }}
                </span>
                <svg class="w-3.5 h-3.5" style="color: var(--sw-text-muted);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
            </button>

            <div x-show="open" @click.away="open = false" x-transition
                 class="absolute mt-2 w-56 rounded-xl overflow-hidden z-50 shadow-lg"
                 style="inset-inline-end: 0; background: var(--sw-surface-card); border: 1px solid var(--sw-border);"
                 x-cloak>
                <div class="p-3 border-b" style="border-color: var(--sw-border);">
                    <p class="text-xs font-bold" style="color: var(--sw-text-primary);">{{ Auth::user()->name ?? '' }}</p>
                    <p class="text-xs font-mono truncate mt-0.5" style="color: var(--sw-text-muted);">{{ Auth::user()->email ?? '' }}</p>
                </div>
                <div class="py-1">
                    @if(Route::has('profile.edit'))
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-xs font-medium transition"
                           style="color: var(--sw-text-secondary);"
                           onmouseover="this.style.background='var(--sw-surface-hover)'"
                           onmouseout="this.style.background='transparent'">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            الملف الشخصي
                        </a>
                    @endif
                </div>
                <div class="border-t" style="border-color: var(--sw-border);">
                    @if(Route::has('logout'))
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 w-full px-3 py-2 text-xs font-medium transition"
                                    style="color: var(--sw-danger);"
                                    onmouseover="this.style.background='var(--sw-surface-hover)'"
                                    onmouseout="this.style.background='transparent'">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                تسجيل الخروج
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>
