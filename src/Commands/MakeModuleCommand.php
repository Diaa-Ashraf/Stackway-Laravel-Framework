<?php

namespace Stackway\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'stackway:module
                            {name : The name of the module (e.g. Product)}
                            {--api : Generate API controller and routes}
                            {--service : Generate Service class}
                            {--repo : Generate Repository with Interface}
                            {--cache : Include cache integration in Repository}
                            {--translation : Include translation support}
                            {--media : Include media upload support}
                            {--filter : Generate Filter class}
                            {--interactive : Ask about each option interactively}
                            {--all : Generate all layers}';

    /**
     * The console command description.
     */
    protected $description = 'Create a new Stackway module with all necessary files';

    /**
     * Module configuration resolved from flags or interactive mode.
     */
    protected array $options = [];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = Str::studly($this->argument('name'));

        $this->resolveOptions();

        $this->info('');
        $this->info("⚡ Creating module: {$name}");
        $this->info('');

        $modulePath = base_path(config('stackway.module.base_path', 'app/Modules') . "/{$name}");
        $namespace = config('stackway.module.namespace', 'App\\Modules') . "\\{$name}";

        // Replacements map
        $replacements = [
            '{{moduleName}}'        => $name,
            '{{moduleLower}}'       => Str::snake($name),
            '{{moduleKebab}}'       => Str::kebab($name),
            '{{modulePlural}}'      => Str::plural($name),
            '{{modulePluralLower}}' => Str::snake(Str::plural($name)),
            '{{modulePluralKebab}}' => Str::kebab(Str::plural($name)),
            '{{moduleCamel}}'       => Str::camel($name),
            '{{namespace}}'         => $namespace,
            '{{moduleLabel}}'       => Str::headline($name),
            '{{moduleLabelPlural}}' => Str::headline(Str::plural($name)),
        ];

        // ── Always create these ──
        $this->createFile($modulePath, 'Controllers', "{$name}Controller.php", 'controller', $replacements);
        $this->createFile($modulePath, 'Models', "{$name}.php", 'model', $replacements);
        $this->createFile($modulePath, 'Requests', "Store{$name}Request.php", 'request-store', $replacements);
        $this->createFile($modulePath, 'Requests', "Update{$name}Request.php", 'request-update', $replacements);
        $this->createFile($modulePath, 'Database/Migrations', date('Y_m_d_His') . "_create_" . Str::snake(Str::plural($name)) . "_table.php", 'migration', $replacements);

        // Views
        $this->createFile($modulePath, 'Views', 'index.blade.php', 'views/index', $replacements);
        $this->createFile($modulePath, 'Views', 'create.blade.php', 'views/create', $replacements);
        $this->createFile($modulePath, 'Views', 'edit.blade.php', 'views/edit', $replacements);
        $this->createFile($modulePath, 'Views', 'show.blade.php', 'views/show', $replacements);

        // ── Optional layers ──
        if ($this->options['service']) {
            $this->createFile($modulePath, 'Services', "{$name}Service.php", 'service', $replacements);
        }

        if ($this->options['repo']) {
            $this->createFile($modulePath, 'Repositories', "{$name}Repository.php", 'repository', $replacements);
            $this->createFile($modulePath, 'Contracts', "{$name}RepositoryInterface.php", 'interface', $replacements);
        }

        if ($this->options['api']) {
            $this->createFile($modulePath, 'Controllers/Api', "{$name}Controller.php", 'api-controller', $replacements);
            $this->createFile($modulePath, 'Resources', "{$name}Resource.php", 'resource', $replacements);
            $this->createFile($modulePath, 'Routes', 'api.php', 'routes/api', $replacements);
        }

        if ($this->options['filter']) {
            $this->createFile($modulePath, 'Filters', "{$name}Filter.php", 'filter', $replacements);
        }

        $this->info('');
        $this->info("✅ Module [{$name}] created successfully!");
        $this->info("📁 Location: {$modulePath}");
        $this->info('');

        // Show what was generated
        $this->table(['Layer', 'Status'], $this->getSummaryTable());

        // Show route snippet reminder for routes/web.php
        $snake = Str::snake($name);
        $this->newLine();
        $this->info("📌 Add this route to your main routes/web.php:");
        $this->line("   Route::prefix('admin/{$snake}')->name('{$snake}.')->group(function () {");
        $this->line("       Route::get('/', [\\{$namespace}\\Controllers\\{$name}Controller::class, 'index'])->name('index');");
        $this->line("       Route::get('/create', [\\{$namespace}\\Controllers\\{$name}Controller::class, 'create'])->name('create');");
        $this->line("       Route::post('/', [\\{$namespace}\\Controllers\\{$name}Controller::class, 'store'])->name('store');");
        $this->line("       Route::get('/{id}', [\\{$namespace}\\Controllers\\{$name}Controller::class, 'show'])->name('show');");
        $this->line("       Route::get('/{id}/edit', [\\{$namespace}\\Controllers\\{$name}Controller::class, 'edit'])->name('edit');");
        $this->line("       Route::put('/{id}', [\\{$namespace}\\Controllers\\{$name}Controller::class, 'update'])->name('update');");
        $this->line("       Route::delete('/{id}', [\\{$namespace}\\Controllers\\{$name}Controller::class, 'destroy'])->name('destroy');");
        $this->line("   });");

        // Show binding reminder if repo was created
        if ($this->options['repo']) {
            $this->newLine();
            $this->warn("📌 Don't forget to add this binding to AppServiceProvider:");
            $this->line("   \$this->app->bind(\\{$namespace}\\Contracts\\{$name}RepositoryInterface::class, \\{$namespace}\\Repositories\\{$name}Repository::class);");
        }

        return self::SUCCESS;
    }

    /**
     * Resolve options from flags or interactive prompts.
     */
    protected function resolveOptions(): void
    {
        $all = $this->option('all');

        if ($this->option('interactive')) {
            $this->options = [
                'service'     => $this->confirm('Need Service Layer?', true),
                'repo'        => $this->confirm('Need Repository Layer?', false),
                'api'         => $this->confirm('Need API support?', false),
                'cache'       => $this->confirm('Need Caching?', false),
                'translation' => $this->confirm('Need Translation?', false),
                'media'       => $this->confirm('Need Media Upload?', false),
                'filter'      => $this->confirm('Need Filter class?', false),
            ];
        } else {
            $this->options = [
                'service'     => $all || $this->option('service'),
                'repo'        => $all || $this->option('repo'),
                'api'         => $all || $this->option('api'),
                'cache'       => $all || $this->option('cache'),
                'translation' => $all || $this->option('translation'),
                'media'       => $all || $this->option('media'),
                'filter'      => $all || $this->option('filter'),
            ];
        }
    }

    /**
     * Create a file from a stub template.
     */
    protected function createFile(string $modulePath, string $subDir, string $fileName, string $stubName, array $replacements): void
    {
        $directory = $modulePath . DIRECTORY_SEPARATOR . $subDir;
        $filePath = $directory . DIRECTORY_SEPARATOR . $fileName;

        if (File::exists($filePath)) {
            $this->warn("  ⚠ Already exists: {$subDir}/{$fileName}");
            return;
        }

        File::ensureDirectoryExists($directory);

        // Look for published stubs first, then package stubs
        $stubPath = base_path("stubs/stackway/module/{$stubName}.stub");
        if (!File::exists($stubPath)) {
            $stubPath = __DIR__ . "/../../stubs/module/{$stubName}.stub";
        }

        if (!File::exists($stubPath)) {
            $this->error("  ✗ Stub not found: {$stubName}.stub");
            return;
        }

        $content = File::get($stubPath);

        // Apply replacements
        foreach ($replacements as $placeholder => $value) {
            $content = str_replace($placeholder, $value, $content);
        }

        // Apply conditional blocks
        $content = $this->processConditionalBlocks($content);

        File::put($filePath, $content);

        $this->line("  <fg=green>✓</> {$subDir}/{$fileName}");
    }

    /**
     * Process conditional blocks in stub content.
     * Syntax: {{#if:option}}...content...{{/if:option}} or {{#if:!option}}...content...{{/if:!option}}
     */
    protected function processConditionalBlocks(string $content): string
    {
        $maxPasses = 5;
        $pass = 0;

        while ($pass < $maxPasses) {
            $matched = false;

            // Handle positive conditionals: {{#if:key}}content{{/if:key}}
            foreach ($this->options as $key => $enabled) {
                // Positive condition (no nested tags of same type)
                $posPattern = "/\{\{#if:{$key}\}\}((?:(?!\{\{#if:{$key}\}\}).)*?)\{\{\/if:{$key}\}\}/s";
                if (preg_match($posPattern, $content)) {
                    $matched = true;
                    $content = preg_replace($posPattern, $enabled ? '$1' : '', $content);
                }

                // Negative condition: {{#if:!key}}content{{/if:!key}}
                $negPattern = "/\{\{#if:!{$key}\}\}((?:(?!\{\{#if:!{$key}\}\}).)*?)\{\{\/if:!{$key}\}\}/s";
                if (preg_match($negPattern, $content)) {
                    $matched = true;
                    $content = preg_replace($negPattern, !$enabled ? '$1' : '', $content);
                }
            }

            if (!$matched) {
                break;
            }

            $pass++;
        }

        // Clean up any remaining unhandled if tags
        $content = preg_replace('/\{\{#if:[^}]+\}\}/', '', $content);
        $content = preg_replace('/\{\{\/if:[^}]+\}\}/', '', $content);

        return $content;
    }

    /**
     * Get summary table for output.
     */
    protected function getSummaryTable(): array
    {
        $rows = [
            ['Controller', '✅ Created'],
            ['Model', '✅ Created'],
            ['Requests (Store/Update)', '✅ Created'],
            ['Migration', '✅ Created'],
            ['Views (CRUD)', '✅ Created'],
        ];

        $optionalLayers = [
            'service'     => 'Service',
            'repo'        => 'Repository + Interface',
            'api'         => 'API (Controller + Resource + Routes)',
            'filter'      => 'Filter',
            'cache'       => 'Cache Integration',
            'translation' => 'Translation Support',
            'media'       => 'Media Upload',
        ];

        foreach ($optionalLayers as $key => $label) {
            $rows[] = [$label, $this->options[$key] ? '✅ Created' : '⏭ Skipped'];
        }

        return $rows;
    }
}
