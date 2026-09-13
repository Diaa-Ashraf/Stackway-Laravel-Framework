# Stackway Core Framework

Stackway Core is a modular Laravel package and SaaS foundation designed for rapid application development. It enforces Clean Architecture principles by automating the generation of Models, Migrations, Controllers, Services, Repositories, Form Requests, and Blade Views, coupled with a dynamic admin dashboard and reusable UI components.

## Features

- **Module Generator**: Generates full-stack modules with clean separation of concerns (Controller -> Service -> Repository -> Model).
- **Admin Dashboard**: Automatic module discovery, KPI summary cards, dark/light theme switching, and full RTL (Arabic) localization.
- **Blade UI Component Library**: A comprehensive set of 20+ pre-built components including cards, buttons, modals, data tables, and form controls (`<x-sw-*>`).
- **Authentication & Profile Management**: Modern UI views for login, registration, password recovery, and user account management.
- **Base Layer & Utility Traits**: Includes `BaseController`, `BaseService`, `BaseRepository`, `BaseRequest`, `ApiResponseTrait`, `DashboardResponseTrait`, `ImageUploadTrait`, and `SlugTrait`.

---

## Requirements

- PHP 8.2 or higher
- Laravel 11.x or 12.x
- Composer 2.x

---

## Installation

### 1. Add Repository to composer.json

Add the repository configuration to your project's `composer.json`:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/Diaa-Ashraf/Stackway-Laravel-Framework.git"
    }
]
```

### 2. Install the Package

Run Composer require:

```bash
composer require stackway/core:dev-main
```

### 3. Run Package Installation

Publish the configuration, assets, and views:

```bash
php artisan stackway:install
```

### 4. Run Migrations

```bash
php artisan migrate
```

---

## Available Artisan Commands

### Module Generator (`stackway:module`)

Generates a complete modular structure in `app/Modules/{ModuleName}`.

```bash
# Generate complete module with all layers
php artisan stackway:module Customer --all

# Generate specific layers only
php artisan stackway:module Customer --model --migration
php artisan stackway:module Customer --controller --service --repository
php artisan stackway:module Customer --views
```

#### Generated Module Architecture
When running with `--all`, the following layers are created:
- `Models/Customer.php`
- `Database/Migrations/xxxx_create_customers_table.php`
- `Controllers/CustomerController.php`
- `Services/CustomerService.php`
- `Repositories/CustomerRepository.php` & `CustomerRepositoryInterface.php`
- `Requests/StoreCustomerRequest.php` & `UpdateCustomerRequest.php`
- `Views/index.blade.php`, `create.blade.php`, `edit.blade.php`, `show.blade.php`
- `Routes/api.php` and `Resources/CustomerResource.php`

### Package Setup (`stackway:install`)

Publishes the package configuration file and core assets.

```bash
php artisan stackway:install

# Overwrite existing published files
php artisan stackway:install --force
```

### API Authentication Setup (`stackway:api-auth`)

Scaffolds Sanctum-based API authentication controllers and routes.

```bash
php artisan stackway:api-auth
```

---

## Web Routing Setup

Define your modular admin routes inside your main `routes/web.php` file:

```php
use App\Modules\Customer\Controllers\CustomerController;
use Stackway\Core\Controllers\DashboardController;

Route::middleware(['web', 'auth'])->prefix('admin')->group(function () {
    // Main Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('stackway.dashboard');

    // Customer Module Routes
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('/create', [CustomerController::class, 'create'])->name('create');
        Route::post('/', [CustomerController::class, 'store'])->name('store');
        Route::get('/{id}', [CustomerController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CustomerController::class, 'update'])->name('update');
        Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('destroy');
    });
});
```

---

## Blade Components Reference

Stackway includes pre-styled Blade components accessible via the `<x-sw-*>` prefix:

| Component | Usage | Description |
|---|---|---|
| `<x-sw-card>` | `<x-sw-card title="Title">...</x-sw-card>` | Standard container card |
| `<x-sw-stat-card>` | `<x-sw-stat-card title="Users" value="1,200" />` | Metric indicator card |
| `<x-sw-button>` | `<x-sw-button variant="primary">Save</x-sw-button>` | Button with multiple variants |
| `<x-sw-input>` | `<x-sw-input name="email" label="Email" type="email" />` | Input with validation binding |
| `<x-sw-select>` | `<x-sw-select name="status" :options="$options" />` | Form select dropdown |
| `<x-sw-modal>` | `<x-sw-modal id="confirmModal">...</x-sw-modal>` | Alpine.js dialog modal |
| `<x-sw-alert>` | `<x-sw-alert type="success" message="Saved!" />` | Status feedback alert |
| `<x-sw-data-table>` | `<x-sw-data-table>...</x-sw-data-table>` | Responsive data table |
| `<x-sw-file-upload>` | `<x-sw-file-upload name="avatar" />` | File dropzone upload |
| `<x-sw-empty-state>` | `<x-sw-empty-state title="No records found" />` | Empty state placeholder |

---

## Configuration

You can customize the package behavior in `config/stackway.php`:

```php
return [
    'prefix' => 'admin',
    'middleware' => ['web', 'auth'],
    'theme' => [
        'default' => 'light',
        'rtl' => true,
    ],
    'module' => [
        'base_path' => 'app/Modules',
        'namespace' => 'App\\Modules',
    ],
];
```

---

## License

This software is released under the MIT License.
Developed and maintained by Diaa Ashraf.
