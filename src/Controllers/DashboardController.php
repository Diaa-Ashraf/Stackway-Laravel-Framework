<?php

namespace Stackway\Core\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Stackway\Core\Base\BaseController;

class DashboardController extends BaseController
{
    /**
     * Display the built-in dynamic Stackway Dashboard.
     */
    public function index(Request $request): View
    {
        $modules = $this->discoverModules();
        $stats = $this->calculateOverviewStats($modules);
        $recentActivities = $this->getRecentActivities($modules);

        return view('stackway::dashboard', compact('modules', 'stats', 'recentActivities'));
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
            $hasModel = class_exists($modelClass);
            if ($hasModel) {
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
     * Calculate global system and modules statistics.
     */
    protected function calculateOverviewStats(array $modules): array
    {
        $totalRecords = array_sum(array_column($modules, 'count'));
        $usersCount = class_exists(User::class) ? User::count() : 1;

        return [
            'modules_count'  => count($modules),
            'total_records'  => $totalRecords,
            'users_count'    => $usersCount,
            'php_version'    => PHP_VERSION,
            'laravel_ver'    => app()->version(),
            'app_name'       => config('app.name', 'Stackway'),
        ];
    }

    /**
     * Retrieve recent activities from ActivityLog or latest models.
     */
    protected function getRecentActivities(array $modules): array
    {
        $activities = [];

        // 1. Try Spatie ActivityLog if available
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
                            'icon'        => '⚡',
                        ];
                    }
                    return $activities;
                }
            } catch (\Throwable $e) {
                // fallback
            }
        }

        // 2. Default initial activities
        return [
            [
                'title'       => 'تشغيل لوحة التحكم المدمجة بنجاح',
                'description' => 'نظام Stackway Modular Core جاهز للعمل',
                'time'        => 'الآن',
                'type'        => 'success',
                'icon'        => '🚀',
            ],
            [
                'title'       => 'اكتشاف الوحدات التلقائي نشط',
                'description' => count($modules) . ' وحدة برمجية مكتشفة في app/Modules',
                'time'        => 'الآن',
                'type'        => 'info',
                'icon'        => '🧩',
            ],
        ];
    }

    /**
     * Get Arabic label and metadata for standard module names.
     */
    protected function resolveModuleMeta(string $name): array
    {
        return match ($name) {
            'Product' => [
                'label'       => 'إدارة المنتجات',
                'description' => 'كتالوج المنتجات، الأسعار، والمخزون',
                'icon'        => 'products',
                'color'       => 'primary',
            ],
            'Note' => [
                'label'       => 'دفتر الملاحظات',
                'description' => 'تدوين الملاحظات، المهام والأولويات',
                'icon'        => 'notes',
                'color'       => 'amber',
            ],
            'Order' => [
                'label'       => 'إدارة الطلبات',
                'description' => 'متابعة وفواتير طلبات العملاء',
                'icon'        => 'orders',
                'color'       => 'emerald',
            ],
            'Customer', 'Client' => [
                'label'       => 'العملاء',
                'description' => 'قاعدة بيانات العملاء وسجل المعاملات',
                'icon'        => 'users',
                'color'       => 'cyan',
            ],
            'Category' => [
                'label'       => 'الأقسام والتصنيفات',
                'description' => 'هيكلية وتصنيف عناصر النظام',
                'icon'        => 'chart',
                'color'       => 'secondary',
            ],
            default => [
                'label'       => Str::headline($name),
                'description' => 'إدارة وحدة ' . Str::headline($name),
                'icon'        => 'chart',
                'color'       => 'primary',
            ],
        };
    }
}
