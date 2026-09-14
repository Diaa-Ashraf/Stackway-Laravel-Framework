@extends('stackway::layouts.dashboard')

@section('title', 'لوحة التحكم المركزية')

@section('content')
<div class="space-y-6">

    {{-- Executive Header Banner --}}
    <div class="rounded-2xl p-6 md:p-8 transition-all"
         style="background: linear-gradient(135deg, #042F2E 0%, #09090B 100%); border: 1px solid rgba(20, 184, 166, 0.2); box-shadow: 0 4px 20px -2px rgba(9, 9, 11, 0.25);">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold rounded-full"
                     style="background: rgba(20, 184, 166, 0.15); color: #5EEAD4; border: 1px solid rgba(94, 234, 212, 0.25);">
                    <span>Stackway Modular Core</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-white">
                    لوحة التحكم المركزية
                </h1>
                <p class="text-sm max-w-2xl leading-relaxed" style="color: #A1A1AA;">
                    نظام إدارة موحد يكتشف الوحدات البرمجية المسجلة في التطبيق تلقائياً مع توفير واجهات الإدارة والإحصائيات.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <div class="px-4 py-2.5 rounded-xl text-center"
                     style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.1);">
                    <span class="block text-xl font-bold text-white font-mono">{{ $stats['modules_count'] ?? 0 }}</span>
                    <span class="text-xs" style="color: #A1A1AA;">وحدات نشطة</span>
                </div>
                <div class="px-4 py-2.5 rounded-xl text-center"
                     style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.1);">
                    <span class="block text-xl font-bold text-white font-mono">{{ $stats['total_records'] ?? 0 }}</span>
                    <span class="text-xs" style="color: #A1A1AA;">إجمالي السجلات</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Cards Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-sw-stat-card
            title="الوحدات المثبتة"
            :value="$stats['modules_count'] ?? 0"
            icon="products"
            color="primary"
        />
        <x-sw-stat-card
            title="إجمالي السجلات"
            :value="$stats['total_records'] ?? 0"
            icon="chart"
            color="success"
        />
        <x-sw-stat-card
            title="المستخدمين"
            :value="$stats['users_count'] ?? 1"
            icon="users"
            color="info"
        />
        <x-sw-stat-card
            title="إصدار النظام"
            :value="'Laravel ' . ($stats['laravel_ver'] ?? '12')"
            icon="revenue"
            color="secondary"
        />
    </div>

    {{-- Installed Modules Grid --}}
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold flex items-center gap-2" style="color: var(--sw-text-primary);">
                    <span>الوحدات البرمجية النشطة</span>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full" style="background: var(--sw-primary-50); color: var(--sw-primary); border: 1px solid var(--sw-primary-100);">
                        {{ count($modules) }} متاح
                    </span>
                </h2>
                <p class="text-xs mt-0.5" style="color: var(--sw-text-muted);">الوحدات البرمجية المنشأة في مجلد التطبيق المكتشفة تلقائياً</p>
            </div>
        </div>

        @if(empty($modules))
            <x-sw-card padding="p-8">
                <x-sw-empty-state
                    title="لا توجد وحدات برمجية حالياً"
                    description="قم بإنشاء وحدتك الأولى باستخدام أمر: php artisan stackway:module Name --all"
                />
            </x-sw-card>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($modules as $module)
                    <div class="sw-card p-5 flex flex-col justify-between transition-all"
                         style="background: var(--sw-surface-card); border: 1px solid var(--sw-border);">
                        <div class="space-y-3">
                            <div class="flex items-start justify-between gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                                     style="background: var(--sw-primary-50); color: var(--sw-primary);">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                                        <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                                        <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
                                        <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                                    </svg>
                                </div>
                                <span class="px-2.5 py-1 text-xs font-mono font-bold rounded-lg"
                                      style="background: var(--sw-surface-hover); color: var(--sw-text-secondary); border: 1px solid var(--sw-border);">
                                    {{ $module['count'] }} سجل
                                </span>
                            </div>

                            <div>
                                <h3 class="text-base font-bold" style="color: var(--sw-text-primary);">
                                    {{ $module['label'] }}
                                </h3>
                                <p class="text-xs mt-1 line-clamp-2" style="color: var(--sw-text-muted); line-height: 1.5;">
                                    {{ $module['description'] }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 pt-3.5 flex items-center justify-between gap-2" style="border-top: 1px solid var(--sw-border);">
                            @if($module['has_index'])
                                <x-sw-button href="{{ $module['index_url'] }}" variant="secondary" size="sm" class="flex-1">
                                    <span>عرض الوحدة</span>
                                    <span class="text-xs">←</span>
                                </x-sw-button>
                            @endif

                            @if($module['has_create'])
                                <x-sw-button href="{{ $module['create_url'] }}" variant="primary" size="sm">
                                    <span>+ إضافة</span>
                                </x-sw-button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Recent Activities & System Specifications --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        {{-- Activity Stream (2 cols) --}}
        <div class="lg:col-span-2">
            <x-sw-card title="سجل العمليات والنشاط" subtitle="الأحداث والعمليات المنفذة في النظام">
                <div class="divide-y" style="border-color: var(--sw-border);">
                    @forelse($recentActivities as $act)
                        <div class="py-3 flex items-center justify-between gap-4" style="border-color: var(--sw-border);">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                                     style="background: var(--sw-primary-50); color: var(--sw-primary);">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold" style="color: var(--sw-text-primary);">{{ $act['title'] }}</p>
                                    <p class="text-xs" style="color: var(--sw-text-muted);">{{ $act['description'] }}</p>
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
        <div>
            <x-sw-card title="بيئة التشغيل" subtitle="معلومات الخادم والمنصة">
                <div class="space-y-2.5 text-xs">
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
                        <span class="font-semibold" style="color: var(--sw-text-primary);">تلقائي (Dark / Light)</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span style="color: var(--sw-text-secondary); font-weight: 500;">المعمارية:</span>
                        <span class="font-bold" style="color: var(--sw-success);">Modular Clean Architecture</span>
                    </div>
                </div>
            </x-sw-card>
        </div>
    </div>
</div>
@endsection
