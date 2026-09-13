# Stackway Core Framework

🚀 **Stackway Core** - Personal Laravel Framework & SaaS Starter Kit with Built-in Modular Architecture, Dynamic Dashboard, 21+ Blade Components, and Clean Architecture Generators.

## ✨ Features

- 🏗️ **Clean Architecture Generators**: Single-command module generation (`Model`, `Migration`, `Controller`, `Service`, `Repository`, `FormRequests`, `Views`).
- 📊 **Dynamic Admin Dashboard**: Real-time KPI cards, dynamic module discovery, dark/light mode toggle, and full RTL / Arabic localization.
- 🧩 **21+ Ready Blade Components**: `<x-sw-card>`, `<x-sw-button>`, `<x-sw-stat-card>`, `<x-sw-data-table>`, `<x-sw-modal>`, `<x-sw-input>`, `<x-sw-select>`, and more.
- 🔐 **Pre-styled Auth & Profile Views**: Complete modern UI for login, registration, password reset, and user account management.
- ⚡ **Reusable Traits**: `ApiResponseTrait`, `DashboardResponseTrait`, `ImageUploadTrait`, `SlugTrait`, and `ActivityLogTrait`.

---

## 📦 Installation

Add repository to your `composer.json`:
```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/Diaa-Ashraf/Stackway-Laravel-Framework.git"
    }
]
```

Install via Composer:
```bash
composer require stackway/core
```

Run installation & auth setup commands:
```bash
php artisan stackway:install
php artisan stackway:auth
php artisan migrate
```

---

## 🛠️ Usage

### Generate a Complete Module
```bash
php artisan stackway:module Customer --all
```

### Access Dashboard
Visit: `http://127.0.0.1:8000/admin`

---

## 📄 License
Proprietary / MIT - Developed by Diaa Ashraf.
