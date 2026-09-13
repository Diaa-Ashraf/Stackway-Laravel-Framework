<?php

namespace Stackway\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallDashboardCommand extends Command
{
    protected $signature = 'stackway:install {--force : Overwrite existing files}';

    protected $description = 'Install Stackway Dashboard (publish config, theme, views, create Modules directory)';

    public function handle(): int
    {
        $this->info('');
        $this->info('⚡ Installing Stackway Dashboard...');
        $this->info('');

        // 1. Publish config
        $this->call('vendor:publish', [
            '--tag'   => 'stackway-config',
            '--force' => $this->option('force'),
        ]);
        $this->line('  <fg=green>✓</> Config published');

        // 2. Publish theme CSS
        $this->call('vendor:publish', [
            '--tag'   => 'stackway-theme',
            '--force' => $this->option('force'),
        ]);
        $this->line('  <fg=green>✓</> Theme CSS published');

        // 3. Create Modules directory
        $modulesPath = base_path(config('stackway.module.base_path', 'app/Modules'));
        File::ensureDirectoryExists($modulesPath);
        File::put($modulesPath . '/.gitkeep', '');
        $this->line('  <fg=green>✓</> Modules directory created');

        // 4. Update CSS import
        $this->updateAppCss();
        $this->line('  <fg=green>✓</> Updated resources/css/app.css');

        // 5. Publish Sanctum config
        if (class_exists(\Laravel\Sanctum\SanctumServiceProvider::class)) {
            $this->callSilently('vendor:publish', [
                '--provider' => 'Laravel\\Sanctum\\SanctumServiceProvider',
                '--force'    => $this->option('force'),
            ]);
            $this->line('  <fg=green>✓</> Sanctum config published');
        }

        // 6. Publish Spatie Permission
        if (class_exists(\Spatie\Permission\PermissionServiceProvider::class)) {
            $this->callSilently('vendor:publish', [
                '--provider' => 'Spatie\\Permission\\PermissionServiceProvider',
                '--force'    => $this->option('force'),
            ]);
            $this->line('  <fg=green>✓</> Permission config & migrations published');
        }

        // 7. Publish Activity Log
        if (class_exists(\Spatie\Activitylog\ActivitylogServiceProvider::class)) {
            $this->callSilently('vendor:publish', [
                '--provider' => 'Spatie\\Activitylog\\ActivitylogServiceProvider',
                '--tag'      => 'activitylog-migrations',
                '--force'    => $this->option('force'),
            ]);
            $this->line('  <fg=green>✓</> Activity Log migrations published');
        }

        // 8. Publish Media Library
        if (class_exists(\Spatie\MediaLibrary\MediaLibraryServiceProvider::class)) {
            $this->callSilently('vendor:publish', [
                '--provider' => 'Spatie\\MediaLibrary\\MediaLibraryServiceProvider',
                '--tag'      => 'medialibrary-migrations',
                '--force'    => $this->option('force'),
            ]);
            $this->line('  <fg=green>✓</> Media Library migrations published');
        }

        $this->info('');
        $this->info('✅ Stackway Dashboard installed successfully!');
        $this->info('');
        $this->info('Next steps:');
        $this->line('  1. Run <fg=cyan>php artisan migrate</> to create database tables');
        $this->line('  2. Run <fg=cyan>php artisan stackway:module Product --interactive</> to create your first module');
        $this->line('  3. Visit <fg=cyan>/dashboard</> to see your dashboard');
        $this->info('');

        return self::SUCCESS;
    }

    /**
     * Update the app.css to import the Stackway theme.
     */
    protected function updateAppCss(): void
    {
        $appCssPath = resource_path('css/app.css');

        if (!File::exists($appCssPath)) {
            return;
        }

        $content = File::get($appCssPath);
        $importLine = "@import './stackway-theme.css';";

        if (!str_contains($content, 'stackway-theme')) {
            $content = "/* Stackway Design System */\n{$importLine}\n\n" . $content;
            File::put($appCssPath, $content);
        }
    }
}
