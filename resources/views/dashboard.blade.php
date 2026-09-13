@extends('stackway::layouts.dashboard')

@section('title', 'لوحة التحكم المركزية')

@section('content')
<div class="space-y-8">

    {{-- Hero Welcome Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-violet-900 via-indigo-900 to-slate-900 text-white p-6 md:p-8 shadow-xl border border-violet-800/40">
        <div class="absolute -end-10 -bottom-10 w-72 h-72 bg-violet-600/25 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute start-1/3 -top-10 w-60 h-60 bg-cyan-600/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold rounded-full bg-violet-500/25 text-violet-200 border border-violet-400/30">
                    <span>⚡ النظام المعياري التلقائي (Stackway Core)</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">
                    أهلاً بك مجدداً، {{ auth()->user()->name ?? 'المدير' }} 👋
                </h1>
                <p class="text-slate-300 text-sm max-w-2xl leading-relaxed">
                    لوحة التحكم المركزية مكتشفة لجميع الوحدات البرمجية النشطة تلقائياً دون الحاجة لكتابة كود يدوي.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <div class="px-4 py-2 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 text-center">
                    <span class="block text-xl font-bold text-white">{{ $stats['modules_count'] ?? 0 }}</span>
                    <span class="text-xs text-slate-300">وحدة نشطة</span>
                </div>
                <div class="px-4 py-2 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 text-center">
                    <span class="block text-xl font-bold text-white">{{ $stats['total_records'] ?? 0 }}</span>
                    <span class="text-xs text-slate-300">إجمالي السجلات</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Cards Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <x-sw-stat-card
            title="الوحدات المثبتة"
            :value="$stats['modules_count'] ?? 0"
            icon="products"
            color="primary"
        />
        <x-sw-stat-card
            title="إجمالي البيانات المسجلة"
            :value="$stats['total_records'] ?? 0"
            icon="chart"
            color="success"
        />
        <x-sw-stat-card
            title="المستخدمين والمدراء"
            :value="$stats['users_count'] ?? 1"
            icon="users"
            color="secondary"
        />
        <x-sw-stat-card
            title="إصدار النظام"
            :value="'Laravel ' . ($stats['laravel_ver'] ?? '12')"
            icon="revenue"
            color="info"
        />
    </div>

    {{-- Installed Modules Grid --}}
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold flex items-center gap-2" style="color: var(--sw-text-primary);">
                    <span>🧩 الوحدات البرمجية النشطة (Installed Modules)</span>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full" style="background: var(--sw-primary-50); color: var(--sw-primary); border: 1px solid var(--sw-primary-100);">
                        {{ count($modules) }} مكتشفة
                    </span>
                </h2>
                <p class="text-xs mt-1" style="color: var(--sw-text-secondary);">يتم رصد وإتاحة أي وحدة جديدة تُنشأ عبر <code class="font-mono font-bold" style="color: var(--sw-primary);">php artisan stackway:module</code> تلقائياً هنا</p>
            </div>
        </div>

        @if(empty($modules))
            <x-sw-card padding="p-8">
                <x-sw-empty-state
                    title="لم يتم العثور على وحدات في app/Modules"
                    description="قم بإنشاء وحدتك الأولى فوراً باستخدام أوامر Stackway."
                />
            </x-sw-card>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($modules as $module)
                    <div class="rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 p-5 flex flex-col justify-between group"
                         style="background: var(--sw-surface-card); border: 1px solid var(--sw-border);">
                        <div class="space-y-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-xl group-hover:scale-105 transition shadow-sm"
                                     style="background: var(--sw-primary-50); color: var(--sw-primary);">
                                    @if($module['slug'] === 'product') 📦
                                    @elseif($module['slug'] === 'note') 📝
                                    @elseif($module['slug'] === 'order') 🛍️
                                    @elseif($module['slug'] === 'customer') 👥
                                    @else ⚡
                                    @endif
                                </div>
                                <span class="px-3 py-1 text-xs font-mono font-bold rounded-xl"
                                      style="background: var(--sw-surface-hover); color: var(--sw-text-secondary); border: 1px solid var(--sw-border);">
                                    {{ $module['count'] }} سجل
                                </span>
                            </div>

                            <div>
                                <h3 class="text-base font-bold" style="color: var(--sw-text-primary);">
                                    {{ $module['label'] }}
                                </h3>
                                <p class="text-xs mt-1 line-clamp-2" style="color: var(--sw-text-muted);">
                                    {{ $module['description'] }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 flex items-center justify-between gap-2" style="border-top: 1px solid var(--sw-border);">
                            @if($module['has_index'])
                                <x-sw-button href="{{ $module['index_url'] }}" variant="secondary" size="sm" class="flex-1">
                                    <span>عرض الوحدة</span>
                                    <span class="text-xs">←</span>
                                </x-sw-button>
                            @endif

                            @if($module['has_create'])
                                <x-sw-button href="{{ $module['create_url'] }}" variant="primary" size="sm">
                                    <span>+ جديد</span>
                                </x-sw-button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Recent Activities & System Specifications --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Activity Stream (2 cols) --}}
        <div class="lg:col-span-2">
            <x-sw-card title="سجل العمليات والنشاط" subtitle="حركة الأحداث والعمليات عبر النظام">
                <div class="divide-y" style="border-color: var(--sw-border);">
                    @forelse($recentActivities as $act)
                        <div class="py-3.5 flex items-center justify-between gap-4" style="border-color: var(--sw-border);">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm"
                                     style="background: var(--sw-primary-50); color: var(--sw-primary);">
                                    {{ $act['icon'] ?? '⚡' }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold" style="color: var(--sw-text-primary);">{{ $act['title'] }}</p>
                                    <p class="text-xs mt-0.5" style="color: var(--sw-text-muted);">{{ $act['description'] }}</p>
                                </div>
                            </div>
                            <span class="text-xs font-mono" style="color: var(--sw-text-muted);">{{ $act['time'] }}</span>
                        </div>
                    @empty
                        <p class="py-6 text-center text-xs" style="color: var(--sw-text-muted);">لا يوجد نشاط مسجل حالياً.</p>
                    @endforelse
                </div>
            </x-sw-card>
        </div>

        {{-- System Specs & Environment (1 col) --}}
        <div class="space-y-6">
            <x-sw-card title="بيئة التشغيل" subtitle="معلومات خادم الويب والمكتبات">
                <div class="space-y-3 text-xs">
                    <div class="flex justify-between py-2" style="border-bottom: 1px solid var(--sw-border);">
                        <span style="color: var(--sw-text-secondary); font-weight: 500;">حزمة التحكم:</span>
                        <span class="font-bold" style="color: var(--sw-primary);">Stackway Core v1.0</span>
                    </div>
                    <div class="flex justify-between py-2" style="border-bottom: 1px solid var(--sw-border);">
                        <span style="color: var(--sw-text-secondary); font-weight: 500;">إصدار PHP:</span>
                        <span class="font-mono font-bold" style="color: var(--sw-text-primary);">{{ PHP_VERSION }}</span>
                    </div>
                    <div class="flex justify-between py-2" style="border-bottom: 1px solid var(--sw-border);">
                        <span style="color: var(--sw-text-secondary); font-weight: 500;">محرك Laravel:</span>
                        <span class="font-mono font-bold" style="color: var(--sw-text-primary);">v{{ app()->version() }}</span>
                    </div>
                    <div class="flex justify-between py-2" style="border-bottom: 1px solid var(--sw-border);">
                        <span style="color: var(--sw-text-secondary); font-weight: 500;">وضع الثيم:</span>
                        <span class="font-semibold" style="color: var(--sw-text-primary);">Dark / Light Automatic</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span style="color: var(--sw-text-secondary); font-weight: 500;">المعمارية:</span>
                        <span class="font-bold" style="color: var(--sw-success);">Modular SaaS</span>
                    </div>
                </div>
            </x-sw-card>
        </div>
    </div>
</div>
@endsection
