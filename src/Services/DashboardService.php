<?php

namespace Stackway\Core\Services;

use App\Models\User;
use App\Modules\Note\Models\Note;
use App\Modules\Product\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class DashboardService
{
    /**
     * Get complete dynamic dashboard statistics and datasets.
     */
    public function getDashboardData(): array
    {
        $modules = $this->discoverModules();
        $stats = $this->calculateOverviewStats($modules);
        $chartData = $this->buildChartData();
        $latestProducts = $this->getLatestProducts();
        $latestNotes = $this->getLatestNotes();
        $recentActivities = $this->getRecentActivities($modules);

        return compact(
            'modules',
            'stats',
            'chartData',
            'latestProducts',
            'latestNotes',
            'recentActivities'
        );
    }

    /**
     * Auto-discover all modules and their metadata, counts, and routes.
     */
    public function discoverModules(): array
    {
        $modulesPath = base_path(config('stackway.module.base_path', 'app/Modules'));
        $namespace = config('stackway.module.namespace', 'App\\Modules');
        $discovered = [];

        if (!File::isDirectory($modulesPath)) {
            return $discovered;
        }

        $directories = File::directories($modulesPath);

        foreach ($directories as $dir) {
            $name = basename($dir);
            $snake = Str::snake($name);
            $modelClass = "{$namespace}\\{$name}\\Models\\{$name}";

            $count = 0;
            if (class_exists($modelClass)) {
                try {
                    $count = $modelClass::count();
                } catch (\Throwable $e) {
                    $count = 0;
                }
            }

            $indexRoute = "{$snake}.index";
            $createRoute = "{$snake}.create";
            $meta = $this->resolveModuleMeta($name);

            $discovered[] = [
                'name'         => $name,
                'slug'         => $snake,
                'label'        => $meta['label'],
                'description'  => $meta['description'],
                'icon'         => $meta['icon'],
                'color'        => $meta['color'],
                'count'        => $count,
                'has_index'    => Route::has($indexRoute),
                'index_url'    => Route::has($indexRoute) ? route($indexRoute) : null,
                'has_create'   => Route::has($createRoute),
                'create_url'   => Route::has($createRoute) ? route($createRoute) : null,
            ];
        }

        return $discovered;
    }

    /**
     * Calculate global system and modules statistics from database.
     */
    protected function calculateOverviewStats(array $modules): array
    {
        $productsCount = class_exists(Product::class) ? Product::count() : 0;
        $activeProductsCount = class_exists(Product::class) ? Product::where('status', 'active')->count() : 0;
        $inactiveProductsCount = $productsCount - $activeProductsCount;

        $notesCount = class_exists(Note::class) ? Note::count() : 0;
        $pinnedNotesCount = class_exists(Note::class) ? Note::where('is_pinned', true)->count() : 0;
        $highPriorityNotesCount = class_exists(Note::class) ? Note::where('priority', 'high')->count() : 0;

        $usersCount = class_exists(User::class) ? User::count() : 1;
        $totalRecords = array_sum(array_column($modules, 'count'));

        return [
            'total_products'       => $productsCount,
            'active_products'      => $activeProductsCount,
            'inactive_products'    => $inactiveProductsCount,
            'total_notes'          => $notesCount,
            'pinned_notes'         => $pinnedNotesCount,
            'high_priority_notes'  => $highPriorityNotesCount,
            'users_count'          => $usersCount,
            'modules_count'        => count($modules),
            'total_records'        => $totalRecords,
            'php_version'          => PHP_VERSION,
            'laravel_ver'          => app()->version(),
            'app_name'             => config('app.name', 'Stackway Core'),
        ];
    }

    /**
     * Build dynamic chart data from database records.
     */
    protected function buildChartData(): array
    {
        // 7-day trend (days of week)
        $days = [];
        $arabicDayNames = [
            'Saturday'  => 'السبت',
            'Sunday'    => 'الأحد',
            'Monday'    => 'الإثنين',
            'Tuesday'   => 'الثلاثاء',
            'Wednesday' => 'الأربعاء',
            'Thursday'  => 'الخميس',
            'Friday'    => 'الجمعة',
        ];

        $productCounts = [];
        $noteCounts = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dayEnglish = $date->format('l');
            $days[] = $arabicDayNames[$dayEnglish] ?? $date->format('d M');

            $pCount = class_exists(Product::class)
                ? Product::whereDate('created_at', $date)->count()
                : 0;

            $nCount = class_exists(Note::class)
                ? Note::whereDate('created_at', $date)->count()
                : 0;

            $productCounts[] = $pCount;
            $noteCounts[] = $nCount;
        }

        // If today is initial seed day and past days have 0, show distribution over the week or cumulative
        $totalP = array_sum($productCounts);
        $totalN = array_sum($noteCounts);
        if ($totalP === 0 && class_exists(Product::class)) {
            $productCounts[6] = Product::count();
        }
        if ($totalN === 0 && class_exists(Note::class)) {
            $noteCounts[6] = Note::count();
        }

        // Distribution Breakdown (Radial / Donut)
        $activeP = class_exists(Product::class) ? Product::where('status', 'active')->count() : 0;
        $inactiveP = class_exists(Product::class) ? Product::where('status', '!=', 'active')->count() : 0;
        $notesP = class_exists(Note::class) ? Note::count() : 0;

        $distSeries = [$activeP, $inactiveP, $notesP];
        $distLabels = ['منتجات نشطة', 'منتجات غير نشطة', 'ملاحظات مسجلة'];

        // If all 0, provide fallback non-zero for visual display
        if (array_sum($distSeries) === 0) {
            $distSeries = [1, 0, 1];
        }

        return [
            'days'             => $days,
            'products_trend'   => $productCounts,
            'notes_trend'      => $noteCounts,
            'dist_series'      => $distSeries,
            'dist_labels'      => $distLabels,
        ];
    }

    /**
     * Get real latest products from database.
     */
    protected function getLatestProducts()
    {
        if (!class_exists(Product::class)) {
            return collect();
        }

        return Product::select(['id', 'name', 'status', 'description', 'created_at'])
            ->latest()
            ->take(5)
            ->get();
    }

    /**
     * Get real latest notes from database.
     */
    protected function getLatestNotes()
    {
        if (!class_exists(Note::class)) {
            return collect();
        }

        return Note::select(['id', 'title', 'category', 'priority', 'color', 'is_pinned', 'created_at'])
            ->latest()
            ->take(5)
            ->get();
    }

    /**
     * Retrieve recent activities from ActivityLog or latest models.
     */
    protected function getRecentActivities(array $modules): array
    {
        $activities = [];

        if (class_exists(\Spatie\Activitylog\Models\Activity::class)) {
            try {
                $logs = \Spatie\Activitylog\Models\Activity::with('causer')->latest()->take(5)->get();
                if ($logs->isNotEmpty()) {
                    foreach ($logs as $log) {
                        $activities[] = [
                            'title'       => $log->description,
                            'description' => ($log->causer ? $log->causer->name : 'النظام') . ' • ' . ($log->subject_type ? class_basename($log->subject_type) : 'عام'),
                            'time'        => $log->created_at ? $log->created_at->diffForHumans() : 'الآن',
                            'type'        => 'info',
                            'icon'        => 'ti ti-activity',
                        ];
                    }
                    return $activities;
                }
            } catch (\Throwable $e) {
                // fallback
            }
        }

        // Build dynamic activity feed from latest database records
        $recentProducts = $this->getLatestProducts();
        foreach ($recentProducts as $p) {
            $activities[] = [
                'title'       => 'إضافة منتج: ' . $p->name,
                'description' => 'المخزون • الحالة: ' . ($p->status === 'active' ? 'نشط' : 'غير نشط'),
                'time'        => $p->created_at ? $p->created_at->diffForHumans() : 'مؤخراً',
                'type'        => 'success',
                'icon'        => 'ti ti-box-seam',
            ];
        }

        $recentNotes = $this->getLatestNotes();
        foreach ($recentNotes as $n) {
            $activities[] = [
                'title'       => 'تدوين ملاحظة: ' . Str::limit($n->title, 40),
                'description' => 'دفتر الملاحظات • أولوية ' . $n->priority,
                'time'        => $n->created_at ? $n->created_at->diffForHumans() : 'مؤخراً',
                'type'        => 'primary',
                'icon'        => 'ti ti-notes',
            ];
        }

        if (empty($activities)) {
            $activities[] = [
                'title'       => 'تشغيل لوحة التحكم بنجاح',
                'description' => 'نظام Stackway Modular Core جاهز للعمل',
                'time'        => 'الآن',
                'type'        => 'success',
                'icon'        => 'ti ti-rocket',
            ];
        }

        return array_slice($activities, 0, 5);
    }

    /**
     * Get Arabic label and metadata for standard module names.
     */
    protected function resolveModuleMeta(string $name): array
    {
        return match ($name) {
            'Product' => [
                'label'       => 'المخزون والمنتجات',
                'description' => 'كتالوج المنتجات، الأسعار، والمخزون',
                'icon'        => 'ti ti-box-seam',
                'color'       => 'primary',
            ],
            'Note' => [
                'label'       => 'الملاحظات والمهام',
                'description' => 'تدوين الملاحظات، المهام والأولويات',
                'icon'        => 'ti ti-notes',
                'color'       => 'amber',
            ],
            'Order' => [
                'label'       => 'الطلبات والمبيعات',
                'description' => 'متابعة وفواتير طلبات العملاء',
                'icon'        => 'ti ti-receipt',
                'color'       => 'emerald',
            ],
            'Customer', 'Client' => [
                'label'       => 'العملاء',
                'description' => 'قاعدة بيانات العملاء وسجل المعاملات',
                'icon'        => 'ti ti-users',
                'color'       => 'cyan',
            ],
            default => [
                'label'       => Str::headline($name),
                'description' => 'إدارة وحدة ' . Str::headline($name),
                'icon'        => 'ti ti-layout-grid',
                'color'       => 'primary',
            ],
        };
    }
}
