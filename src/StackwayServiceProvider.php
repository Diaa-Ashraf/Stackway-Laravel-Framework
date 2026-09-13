<?php

namespace Stackway\Core;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;

use Illuminate\Support\Str;

class StackwayServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Merge config
        $this->mergeConfigFrom(__DIR__ . '/../config/stackway.php', 'stackway');

        // Register Support singletons
        $this->app->singleton(\Stackway\Core\Support\CacheManager::class);
        $this->app->singleton(\Stackway\Core\Support\StorageManager::class);
        $this->app->singleton(\Stackway\Core\Support\ImageManager::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerCommands();
        $this->registerPublishables();
        $this->registerViews();
        $this->registerBladeComponents();
        $this->loadModules();
    }

    /**
     * Register Artisan commands.
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Stackway\Core\Commands\MakeModuleCommand::class,
                \Stackway\Core\Commands\InstallDashboardCommand::class,
                \Stackway\Core\Commands\SetupAuthCommand::class,
            ]);
        }
    }

    /**
     * Register publishable resources.
     */
    protected function registerPublishables(): void
    {
        if ($this->app->runningInConsole()) {
            // Config
            $this->publishes([
                __DIR__ . '/../config/stackway.php' => config_path('stackway.php'),
            ], 'stackway-config');

            // Views
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/stackway'),
            ], 'stackway-views');

            // CSS Theme
            $this->publishes([
                __DIR__ . '/../resources/css/stackway-theme.css' => resource_path('css/stackway-theme.css'),
            ], 'stackway-theme');

            // Stubs (for customization)
            $this->publishes([
                __DIR__ . '/../stubs' => base_path('stubs/stackway'),
            ], 'stackway-stubs');
        }
    }

    /**
     * Register package views.
     */
    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'stackway');
    }

    /**
     * Register Blade components with 'sw-' prefix.
     */
    protected function registerBladeComponents(): void
    {
        // Layout components
        Blade::component('stackway::components.sidebar', 'sw-sidebar');
        Blade::component('stackway::components.header', 'sw-header');
        Blade::component('stackway::components.footer', 'sw-footer');
        Blade::component('stackway::components.breadcrumb', 'sw-breadcrumb');

        // UI components
        Blade::component('stackway::components.stat-card', 'sw-stat-card');
        Blade::component('stackway::components.data-table', 'sw-data-table');
        Blade::component('stackway::components.badge', 'sw-badge');
        Blade::component('stackway::components.avatar', 'sw-avatar');
        Blade::component('stackway::components.empty-state', 'sw-empty-state');
        Blade::component('stackway::components.alert', 'sw-alert');
        Blade::component('stackway::components.modal', 'sw-modal');
        Blade::component('stackway::components.toast', 'sw-toast');
        Blade::component('stackway::components.loading-spinner', 'sw-loading');

        // Form & Basic components
        Blade::component('stackway::components.input', 'sw-input');
        Blade::component('stackway::components.select', 'sw-select');
        Blade::component('stackway::components.textarea', 'sw-textarea');
        Blade::component('stackway::components.checkbox', 'sw-checkbox');
        Blade::component('stackway::components.file-upload', 'sw-file-upload');
        Blade::component('stackway::components.date-picker', 'sw-date-picker');
        Blade::component('stackway::components.button', 'sw-button');
        Blade::component('stackway::components.card', 'sw-card');
    }

    /**
     * Auto-load routes, views, and migrations from all Modules.
     *
     * Scans app/Modules/* and loads them automatically.
     */
    protected function loadModules(): void
    {
        $modulesPath = base_path(config('stackway.module.base_path', 'app/Modules'));

        if (!File::isDirectory($modulesPath)) {
            return;
        }

        $modules = File::directories($modulesPath);

        foreach ($modules as $modulePath) {
            $moduleName = basename($modulePath);
            $moduleSnake = Str::snake($moduleName);

            // 1. Load Views
            $viewsPath = $modulePath . DIRECTORY_SEPARATOR . 'Views';
            if (File::isDirectory($viewsPath)) {
                $this->loadViewsFrom($viewsPath, $moduleSnake);
            }

            // 2. Load Migrations
            $migrationsPath = $modulePath . DIRECTORY_SEPARATOR . 'Database' . DIRECTORY_SEPARATOR . 'Migrations';
            if (File::isDirectory($migrationsPath)) {
                $this->loadMigrationsFrom($migrationsPath);
            }

            // 3. Load Translations
            $langPath = $modulePath . DIRECTORY_SEPARATOR . 'Lang';
            if (File::isDirectory($langPath)) {
                $this->loadTranslationsFrom($langPath, $moduleSnake);
            }

            // 4. Load API Routes (if module has API enabled)
            $routesPath = $modulePath . DIRECTORY_SEPARATOR . 'Routes';
            if (File::isDirectory($routesPath)) {
                $apiRoutes = $routesPath . DIRECTORY_SEPARATOR . 'api.php';
                if (File::exists($apiRoutes)) {
                    Route::prefix('api')
                        ->middleware(['api'])
                        ->group($apiRoutes);
                }
            }
        }
    }
}
