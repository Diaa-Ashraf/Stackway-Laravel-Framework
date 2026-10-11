@extends('stackway::layouts.dashboard')

@section('title', 'لوحة التحكم المركزية')

@section('content')
<div class="container-fluid p-0">

    {{-- Welcome Banner --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                <div>
                    <h3 class="fw-bold mb-1" style="color: var(--sw-text-primary);">
                        مرحباً بك، {{ auth()->user()->name ?? 'مدير النظام' }} 👋
                    </h3>
                    <p class="text-muted mb-0 small">
                        إليك ملخص حي وتفاعلي لبيانات المخزون، الملاحظات، والوحدات البرمجية النشطة بالنظام اليوم.
                    </p>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    @if(Route::has('product.create'))
                        <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1 shadow-sm px-3 py-2">
                            <i class="ti ti-plus fs-5"></i>
                            <span class="fw-semibold">إضافة منتج جديد</span>
                        </a>
                    @endif
                    @if(Route::has('note.create'))
                        <a href="{{ route('note.create') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1 px-3 py-2">
                            <i class="ti ti-notes fs-5"></i>
                            <span>تدوين ملاحظة</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- 1. Main Stat Cards Row (100% Dynamic from Database) --}}
    <div class="row g-3 mb-4">
        {{-- Card 1: Total Products --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card p-3 p-xl-4 bg-primary-subtle border border-primary-subtle rounded-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-shape icon-md bg-primary text-white rounded-2 flex-shrink-0">
                        <i class="ti ti-box-seam fs-3"></i>
                    </div>
                    <div class="flex-grow-1">
                        <span class="text-muted small fw-medium">إجمالي المنتجات</span>
                        <h3 class="fw-bold mb-0">{{ $stats['total_products'] }}</h3>
                        <small class="text-primary fw-semibold d-block">
                            {{ $stats['active_products'] }} نشط &bull; {{ $stats['inactive_products'] }} غير نشط
                        </small>
                    </div>
                </div>
                @if(Route::has('product.index'))
                    <div class="mt-3 pt-2 border-top border-primary-subtle d-flex justify-content-between align-items-center">
                        <a href="{{ route('product.index') }}" class="small text-primary fw-semibold text-decoration-none">إدارة المخزون &larr;</a>
                        <span class="badge bg-primary text-white font-monospace">{{ $stats['total_products'] }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Card 2: Total Notes --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card p-3 p-xl-4 bg-success-subtle border border-success-subtle rounded-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-shape icon-md bg-success text-white rounded-2 flex-shrink-0">
                        <i class="ti ti-notes fs-3"></i>
                    </div>
                    <div class="flex-grow-1">
                        <span class="text-muted small fw-medium">الملاحظات والمهام</span>
                        <h3 class="fw-bold mb-0">{{ $stats['total_notes'] }}</h3>
                        <small class="text-success fw-semibold d-block">
                            {{ $stats['pinned_notes'] }} مثبتة &bull; {{ $stats['high_priority_notes'] }} أولوية عاجلة
                        </small>
                    </div>
                </div>
                @if(Route::has('note.index'))
                    <div class="mt-3 pt-2 border-top border-success-subtle d-flex justify-content-between align-items-center">
                        <a href="{{ route('note.index') }}" class="small text-success fw-semibold text-decoration-none">فتح دفتر الملاحظات &larr;</a>
                        <span class="badge bg-success text-white font-monospace">{{ $stats['total_notes'] }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Card 3: System Users --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card p-3 p-xl-4 bg-warning-subtle border border-warning-subtle rounded-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-shape icon-md bg-warning text-white rounded-2 flex-shrink-0">
                        <i class="ti ti-users fs-3"></i>
                    </div>
                    <div class="flex-grow-1">
                        <span class="text-muted small fw-medium">مستخدمو النظام</span>
                        <h3 class="fw-bold mb-0">{{ $stats['users_count'] }}</h3>
                        <small class="text-warning fw-semibold d-block">مدراء ومستخدمين مصرح لهم</small>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top border-warning-subtle d-flex justify-content-between align-items-center">
                    <span class="small text-muted">حسابات نشطة</span>
                    <span class="badge bg-warning text-dark font-monospace">{{ $stats['users_count'] }}</span>
                </div>
            </div>
        </div>

        {{-- Card 4: Discovered Modules --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card p-3 p-xl-4 bg-info-subtle border border-info-subtle rounded-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-shape icon-md bg-info text-white rounded-2 flex-shrink-0">
                        <i class="ti ti-layout-grid fs-3"></i>
                    </div>
                    <div class="flex-grow-1">
                        <span class="text-muted small fw-medium">الوحدات المعيارية</span>
                        <h3 class="fw-bold mb-0">{{ $stats['modules_count'] }} وحدات</h3>
                        <small class="text-info fw-semibold d-block">{{ $stats['total_records'] }} إجمالي السجلات النشطة</small>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top border-info-subtle d-flex justify-content-between align-items-center">
                    <span class="small text-muted">المعمارية المعيارية</span>
                    <span class="badge bg-info text-white font-monospace">Modular v2</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Performance & Health Summary Row --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card border h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                        <div>
                            @php
                                $activeRatio = $stats['total_products'] > 0 ? round(($stats['active_products'] / $stats['total_products']) * 100) : 100;
                            @endphp
                            <h3 class="fw-bold mb-1">{{ $activeRatio }}%</h3>
                            <span class="text-muted small">نسبة جاهزية المخزون</span>
                        </div>
                        <div class="icon-shape icon-md rounded-circle bg-success-subtle text-success">
                            <i class="ti ti-circle-check fs-2"></i>
                        </div>
                    </div>
                    <div class="small text-muted d-flex align-items-center gap-1">
                        <i class="ti ti-info-circle text-primary"></i>
                        <span>{{ $stats['active_products'] }} منتج بحالة نشطة من أصل {{ $stats['total_products'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                        <div>
                            <h3 class="fw-bold mb-1">{{ $stats['pinned_notes'] }}</h3>
                            <span class="text-muted small">ملاحظات ومهام مثبتة</span>
                        </div>
                        <div class="icon-shape icon-md rounded-circle bg-primary-subtle text-primary">
                            <i class="ti ti-pin fs-2"></i>
                        </div>
                    </div>
                    <div class="small text-muted d-flex align-items-center gap-1">
                        <i class="ti ti-alert-circle text-danger"></i>
                        <span>{{ $stats['high_priority_notes'] }} مهام ذات أولوية قصوى وعاجلة</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                        <div>
                            <h3 class="fw-bold mb-1 font-monospace">{{ $stats['php_version'] }}</h3>
                            <span class="text-muted small">إصدار بيئة التشغيل</span>
                        </div>
                        <div class="icon-shape icon-md rounded-circle bg-info-subtle text-info">
                            <i class="ti ti-server fs-2"></i>
                        </div>
                    </div>
                    <div class="small text-muted d-flex align-items-center gap-1">
                        <i class="ti ti-brand-laravel text-danger"></i>
                        <span>Laravel v{{ $stats['laravel_ver'] }} &bull; Stackway Core</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. Dynamic ApexCharts Section --}}
    <div class="row g-3 mb-4">
        {{-- Chart 1: Activity Trend by Day --}}
        <div class="col-12 col-lg-7">
            <div class="card border h-100">
                <div class="card-header bg-transparent px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold">حركة السجلات والنشاط</h5>
                        <small class="text-muted">مقارنة حركة إضافة المنتجات والمهام اليومية</small>
                    </div>
                    <span class="badge bg-light text-secondary border">آخر 7 أيام</span>
                </div>
                <div class="card-body p-4">
                    <div id="salesPurchaseChart" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>

        {{-- Chart 2: Distribution Overview --}}
        <div class="col-12 col-lg-5">
            <div class="card border h-100">
                <div class="card-header bg-transparent px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold">توزيع السجلات وحالتها</h5>
                        <small class="text-muted">نسبة المنتجات النشطة والملاحظات بالنظام</small>
                    </div>
                    <span class="badge bg-light text-secondary border">إجمالي حي</span>
                </div>
                <div class="card-body p-4">
                    <div id="customerChart" style="min-height: 280px;"></div>
                    <div class="row text-center mt-3 g-2">
                        <div class="col-4">
                            <span class="text-muted small d-block">نشط</span>
                            <strong class="text-success">{{ $stats['active_products'] }}</strong>
                        </div>
                        <div class="col-4">
                            <span class="text-muted small d-block">غير نشط</span>
                            <strong class="text-danger">{{ $stats['inactive_products'] }}</strong>
                        </div>
                        <div class="col-4">
                            <span class="text-muted small d-block">ملاحظات</span>
                            <strong class="text-primary">{{ $stats['total_notes'] }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 4. Auto-Discovered Modular Framework Modules Section --}}
    @if(isset($modules) && count($modules) > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border">
                <div class="card-header bg-transparent px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold">الوحدات المعيارية المكتشفة تلقائياً (Stackway Modules)</h5>
                        <small class="text-muted">إدارة كل موديول برمجياً داخل مجلد app/Modules</small>
                    </div>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1">
                        {{ count($modules) }} موديول نشط
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @foreach($modules as $module)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="icon-shape icon-md bg-primary-subtle rounded-2 text-primary">
                                            <i class="{{ $module['icon'] ?? 'ti ti-box-seam' }} fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $module['label'] ?? $module['name'] }}</h6>
                                            <small class="text-muted">{{ $module['count'] ?? 0 }} سجلات مسجلة</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        @if(!empty($module['create_url']))
                                            <a href="{{ $module['create_url'] }}" class="btn btn-sm btn-light border text-primary" title="إضافة جديد">
                                                <i class="ti ti-plus"></i>
                                            </a>
                                        @endif
                                        @if(!empty($module['index_url']))
                                            <a href="{{ $module['index_url'] }}" class="btn btn-sm btn-outline-secondary">
                                                إدارة
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- 5. Real Database Tables Row: Latest Products & Latest Notes --}}
    <div class="row g-3 mb-4">
        {{-- Widget 1: Latest Products from Database --}}
        <div class="col-12 col-lg-6">
            <div class="card border h-100">
                <div class="card-header bg-transparent px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold">أحدث المنتجات المضافة</h5>
                        <small class="text-muted">آخر ما تم إضافته لكتالوج المخزون</small>
                    </div>
                    @if(Route::has('product.index'))
                        <a href="{{ route('product.index') }}" class="btn btn-sm btn-outline-secondary">
                            عرض الكل &larr;
                        </a>
                    @endif
                </div>
                <div class="card-body p-0">
                    @if($latestProducts->isEmpty())
                        <div class="p-4 text-center text-muted small">
                            <i class="ti ti-box-seam fs-1 d-block mb-2 text-secondary opacity-50"></i>
                            لا توجد منتجات مسجلة في المخزون حالياً.
                            @if(Route::has('product.create'))
                                <a href="{{ route('product.create') }}" class="d-block mt-2 fw-semibold text-primary">إضافة أول منتج &rarr;</a>
                            @endif
                        </div>
                    @else
                        <ul class="list-group list-group-flush mb-0">
                            @foreach($latestProducts as $p)
                                @php
                                    $pImg = method_exists($p, 'getFirstMediaUrl') ? $p->getFirstMediaUrl('images') : null;
                                @endphp
                                <li class="list-group-item d-flex align-items-center gap-3 px-4 py-3">
                                    @if($pImg)
                                        <img src="{{ $pImg }}" class="rounded-2 border flex-shrink-0" width="44" height="44" style="object-fit: cover;">
                                    @else
                                        <div class="icon-shape icon-md rounded-2 bg-light text-secondary flex-shrink-0 border">
                                            <i class="ti ti-package fs-4"></i>
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <a href="{{ route('product.show', $p->id) }}" class="mb-1 fw-semibold text-decoration-none text-reset hover-primary d-block">
                                            {{ $p->name }}
                                        </a>
                                        <div class="d-flex align-items-center gap-2 text-muted small">
                                            <span>#{{ $p->id }}</span>
                                            <span>&bull;</span>
                                            <span>{{ $p->created_at ? $p->created_at->diffForHumans() : '-' }}</span>
                                        </div>
                                    </div>
                                    @if($p->status === 'active')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">نشط</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">غير نشط</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        {{-- Widget 2: Latest Notes / Tasks from Database --}}
        <div class="col-12 col-lg-6">
            <div class="card border h-100">
                <div class="card-header bg-transparent px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold">أحدث الملاحظات والمهام</h5>
                        <small class="text-muted">ملاحظات العمل والخطط الحالية</small>
                    </div>
                    @if(Route::has('note.index'))
                        <a href="{{ route('note.index') }}" class="btn btn-sm btn-outline-secondary">
                            عرض الكل &larr;
                        </a>
                    @endif
                </div>
                <div class="card-body p-0">
                    @if($latestNotes->isEmpty())
                        <div class="p-4 text-center text-muted small">
                            <i class="ti ti-notes fs-1 d-block mb-2 text-secondary opacity-50"></i>
                            لا توجد ملاحظات مسجلة بعد.
                            @if(Route::has('note.create'))
                                <a href="{{ route('note.create') }}" class="d-block mt-2 fw-semibold text-primary">تدوين ملاحظة جديدة &rarr;</a>
                            @endif
                        </div>
                    @else
                        <ul class="list-group list-group-flush mb-0">
                            @foreach($latestNotes as $note)
                                <li class="list-group-item d-flex align-items-center gap-3 px-4 py-3">
                                    <div class="icon-shape icon-md rounded-2 bg-light text-primary flex-shrink-0 border">
                                        <i class="ti ti-note fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <a href="{{ route('note.show', $note->id) }}" class="mb-1 fw-semibold text-decoration-none text-reset hover-primary d-block">
                                            {{ Str::limit($note->title, 45) }}
                                        </a>
                                        <div class="d-flex align-items-center gap-2 text-muted small">
                                            <span>{{ $note->category ?? 'عام' }}</span>
                                            <span>&bull;</span>
                                            <span>{{ $note->created_at ? $note->created_at->diffForHumans() : '-' }}</span>
                                        </div>
                                    </div>
                                    @if($note->is_pinned)
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle" title="مثبتة">
                                            <i class="ti ti-pin"></i>
                                        </span>
                                    @endif
                                    <span class="badge bg-light text-secondary border">
                                        {{ $note->priority }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- 6. Real Recent Activities Timeline --}}
    @if(isset($recentActivities) && count($recentActivities) > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border">
                <div class="card-header bg-transparent px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold">سجل العمليات والنشاط الأخير</h5>
                        <small class="text-muted">تتبع حي لأحدث الأحداث والإضافات بالنظام</small>
                    </div>
                    <span class="badge bg-light text-secondary border">سجل حي</span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @foreach($recentActivities as $act)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="p-3 border rounded-3 bg-light d-flex align-items-start gap-3 h-100">
                                    <div class="icon-shape icon-sm rounded-circle bg-primary-subtle text-primary flex-shrink-0 mt-1">
                                        <i class="{{ $act['icon'] ?? 'ti ti-activity' }} fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold small">{{ $act['title'] }}</h6>
                                        <p class="text-muted mb-1" style="font-size: 0.75rem;">{{ $act['description'] }}</p>
                                        <span class="text-secondary small font-monospace" style="font-size: 0.7rem;">
                                            <i class="ti ti-clock me-1"></i>{{ $act['time'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var isDark = document.documentElement.getAttribute('data-theme') === 'dark' || document.documentElement.classList.contains('dark');
    var primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--sw-primary').trim() || '#C85A32';
    var oliveColor   = getComputedStyle(document.documentElement).getPropertyValue('--sw-accent').trim() || '#3A5A40';
    var sandColor    = getComputedStyle(document.documentElement).getPropertyValue('--sw-sand').trim() || '#DDB892';
    var gridBorder   = isDark ? '#38302A' : '#E8E2D9';
    var labelColor   = isDark ? '#A89B92' : '#8C827A';

    // 1. Dynamic Trend Bar Chart
    if (document.getElementById('salesPurchaseChart') && typeof ApexCharts !== 'undefined') {
        var daysCategories = @json($chartData['days'] ?? []);
        var productsSeries = @json($chartData['products_trend'] ?? []);
        var notesSeries    = @json($chartData['notes_trend'] ?? []);

        var trendOptions = {
            series: [
                {
                    name: 'المنتجات المضافة',
                    data: productsSeries,
                },
                {
                    name: 'الملاحظات والمهام',
                    data: notesSeries,
                },
            ],
            colors: [primaryColor, oliveColor],
            chart: {
                type: 'bar',
                height: 350,
                width: '100%',
                toolbar: { show: false },
                fontFamily: 'Poppins, IBM Plex Sans Arabic, sans-serif',
                background: 'transparent',
            },
            theme: {
                mode: isDark ? 'dark' : 'light',
            },
            grid: {
                show: true,
                borderColor: gridBorder,
                strokeDashArray: 3,
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%',
                    borderRadius: 4,
                    borderRadiusApplication: 'end',
                },
            },
            dataLabels: { enabled: false },
            stroke: { show: true, width: 2, colors: ['transparent'] },
            xaxis: {
                categories: daysCategories,
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: { colors: labelColor },
                },
            },
            yaxis: {
                labels: {
                    style: { colors: labelColor },
                    formatter: function (val) { return Math.round(val); },
                },
            },
            tooltip: {
                theme: isDark ? 'dark' : 'light',
                y: {
                    formatter: function (val) { return val + ' سجل'; },
                },
            },
        };

        var trendChart = new ApexCharts(document.querySelector("#salesPurchaseChart"), trendOptions);
        trendChart.render();
    }

    // 2. Dynamic Radial / Donut Chart
    if (document.getElementById('customerChart') && typeof ApexCharts !== 'undefined') {
        var distSeries = @json($chartData['dist_series'] ?? [1, 0, 1]);
        var distLabels = @json($chartData['dist_labels'] ?? ['منتجات نشطة', 'غير نشطة', 'ملاحظات']);

        var distOptions = {
            series: distSeries,
            labels: distLabels,
            chart: {
                height: 280,
                type: 'donut',
                fontFamily: 'Poppins, IBM Plex Sans Arabic, sans-serif',
                background: 'transparent',
            },
            theme: {
                mode: isDark ? 'dark' : 'light',
            },
            colors: [oliveColor, primaryColor, sandColor],
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'إجمالي السجلات',
                                color: isDark ? '#FAF6F3' : '#1E1B18',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce(function(a, b) { return a + b; }, 0);
                                }
                            },
                            value: {
                                color: isDark ? '#FAF6F3' : '#1E1B18',
                            }
                        }
                    }
                }
            },
            legend: {
                position: 'bottom',
                labels: {
                    colors: labelColor,
                },
            },
            dataLabels: {
                enabled: false,
            },
        };

        var distChart = new ApexCharts(document.querySelector("#customerChart"), distOptions);
        distChart.render();
    }
});
</script>
@endpush
@endsection
