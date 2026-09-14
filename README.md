# 🚀 Stackway Core — Laravel 12 SaaS & Modular Framework

[![Laravel 12](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![PHP 8.2+](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php)](https://php.net)
[![License: MIT](https://img.shields.io/badge/License-MIT-teal.svg?style=for-the-badge)](LICENSE)

**Stackway Core** هو إطار عمل Laravel شخصي و **SaaS Starter Kit** مبني وفق أعلى معايير **Clean Architecture** و **Modular Architecture**. يوفر لك لوحة تحكم عصرية جاهزة (Obsidian Teal)، أكثر من 21 مكون Blade متطور، مولد موديولات ذكي، وربط تلقائي للـ Repositories مع دعم كامل للغة العربية (RTL) والوضع الليلي (Dark Mode).

---

## 🌟 الميزات الرئيسية

- 🏗️ **معمارية معيارية (Modular Architecture):** عزل كامل لكل موديول داخل `app/Modules/{Name}` بجميع طبقاته.
- ⚡ **Clean Architecture Generator:** توليد موديول متكامل بضغطة زر (Controller, Model, Service, Repository, Requests, Views, API).
- 📊 **لوحة تحكم ديناميكية (Obsidian Teal):** اكتشاف تلقائي للموديولات المنشأة وعرض إحصائياتها لحظياً.
- 🧩 **أكثر من 21 مكون Blade جاهز (`<x-sw-*>`):** بطاقات، جداول، نوافذ منبثقة، أزرار، حقول إدخال، رفع ملفات، وتنبيهات.
- 🔄 **ربط تلقائي للـ Repositories:** يتم ربط الـ Interfaces بالـ Repositories تلقائياً عبر `StackwayServiceProvider`.
- 🔐 **واجهات Auth و API Auth جاهزة:** واجهات تسجيل الدخول والملف الشخصي + نظام كامل لـ API Authentication عبر Sanctum.
- 🛠️ **حزمة خدمات جاهزة (Batteries Included):** إدارة الكاش، رفع الصور، دعم الترجمة، الصلاحيات، وسجل الأنشطة.

---

## 📦 التثبيت السريع في أي مشروع جديد

### 1. إضافة الـ Repository في `composer.json`

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/Diaa-Ashraf/Stackway-Laravel-Framework.git"
    }
]
```

### 2. تثبيت الحزمة عبر Composer

```bash
composer require stackway/core:dev-main
```

### 3. تشغيل أمر التهيئة والتثبيت

```bash
php artisan stackway:install
```

### 4. إعداد الـ Authentication (اختياري للـ API)

```bash
php artisan stackway:api-auth
```

### 5. تشغيل المايجريشن

```bash
php artisan migrate
```

---

## 🎨 إعداد Tailwind CSS (اختياري)

إذا كنت تستخدم Tailwind CSS في مشروعك، أضف مسار الموديولات في مصفوفة `content` داخل `tailwind.config.js`:

```javascript
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./app/Modules/**/*.blade.php", // 👈 مسار موديولات Stackway
  ],
  // ...
}
```

---

## 🛠️ أوامر Artisan المتاحة

### 1. توليد موديول جديد (`stackway:module`)

```bash
# إنشاء موديول كامل بجميع الطبقات (12 طبقة)
php artisan stackway:module Customer --all

# إنشاء موديول واستبدال الملفات القديمة (Force Overwrite)
php artisan stackway:module Customer --all --force

# الوضع التفاعلي خطوة بخطوة
php artisan stackway:module Customer --interactive

# إنشاء طبقات محددة
php artisan stackway:module Customer --service --repo --api
```

#### الخيارات المتاحة لأمر `stackway:module`:

| الخيار | الوصف |
| :--- | :--- |
| `--all` | توليد جميع الطبقات (Service, Repository, API, Views, Filter, Cache, Media, Translation) |
| `--force` | إعادة كتابة واستبدال الملفات إذا كانت موجودة مسبقاً |
| `--service` | توليد طبقة الـ Service لقواعد ومنطق الأعمال |
| `--repo` | توليد طبقة الـ Repository مع الـ Interface الخاص بها |
| `--api` | توليد API Controller و API Resource وراوت `api.php` |
| `--filter` | توليد كلاس Filter للبحث والفلترة المتقدمة |
| `--cache` | تفعيل التخزين المؤقت التلقائي في الـ Repository |
| `--media` | تفعيل رفع ومعالجة الصور عبر Spatie MediaLibrary |
| `--translation`| تفعيل ترجمة الحقول عبر Spatie Translatable |
| `--interactive` | تشغيل المعالج التفاعلي لاختيار الطبقات |

---

### 2. تهيئة وتثبيت الداش بورد (`stackway:install`)

```bash
php artisan stackway:install

# استبدال وإعادة نشر الملفات
php artisan stackway:install --force
```

يقوم هذا الأمر بـ:
1. نشر ملف الإعدادات `config/stackway.php`.
2. نشر ملف الثيم المحدث `resources/css/stackway-theme.css`.
3. إنشاء مجلد الموديولات `app/Modules/`.
4. تهيئة `resources/css/app.css` و `resources/js/app.js` تلقائياً.

---

### 3. إعداد مصادقة الـ API عبر Sanctum (`stackway:api-auth`)

```bash
php artisan stackway:api-auth
```

يولد نظام مصادقة API متكامل داخل `app/Modules/Auth`:
- `Controllers/Api/AuthController.php` (login, register, logout, me).
- كلاسات التحقق `LoginRequest.php` و `RegisterRequest.php`.
- مسارات الـ API في `Routes/api.php`.

---

## 🏛️ هيكل الموديول المولد (Module Architecture)

عند تشغيل `php artisan stackway:module Article --all`، يتم إنشاء المعمارية التالية داخل `app/Modules/Article`:

```text
app/Modules/Article/
├── Models/
│   └── Article.php              # Eloquent Model مع SoftDeletes وتتبع الأنشطة
├── Database/
│   └── Migrations/              # ملف المايجريشن للجدول
├── Controllers/
│   ├── ArticleController.php    # Thin Controller لإدارة واجهات الويب
│   └── Api/
│       └── ArticleController.php# API Controller لخدمة الموبايل والفرونت
├── Services/
│   └── ArticleService.php       # Business Logic والعمليات المعقدة
├── Repositories/
│   └── ArticleRepository.php    # استعلامات وتخزين قاعدة البيانات
├── Contracts/
│   └── ArticleRepositoryInterface.php # واجهة العقد (SOLID)
├── Requests/
│   ├── StoreArticleRequest.php  # التحقق من الإضافة برسائل عربية
│   └── UpdateArticleRequest.php # التحقق من التعديل برسائل عربية
├── Resources/
│   └── ArticleResource.php      # تنسيق ردود الـ JSON للـ API
├── Filters/
│   └── ArticleFilter.php        # فلترة وبحث متقدم
├── Routes/
│   └── api.php                  # مسارات الـ API الخاصة بالموديول
└── Views/
    ├── index.blade.php          # جدول البيانات والبحث
    ├── create.blade.php         # نموذج الإضافة
    ├── edit.blade.php           # نموذج التعديل
    └── show.blade.php           # صفحة تفاصيل السجل
```

---

## 🧩 مكتبة مكونات Blade (`<x-sw-*>`)

توفر الحزمة أكثر من 21 مكون Blade متطور وعالي الجودة:

| المكون | مثال الاستخدام | الوصف |
| :--- | :--- | :--- |
| **البطاقات** | `<x-sw-card title="العنوان">...</x-sw-card>` | بطاقة بتصميم Soft UI للوضعين الفاتح والداكن |
| **الأزرار** | `<x-sw-button variant="primary">حفظ</x-sw-button>` | أزرار تفاعلية (Primary, Secondary, Danger, Ghost) |
| **بطاقات KPI** | `<x-sw-stat-card title="المبيعات" value="1,240" icon="chart" />` | بطاقات إحصائيات تدعم الأيقونات والتدرجات |
| **الجداول** | `<table class="sw-table">...</table>` | جداول عالية التباين متوافقة مع RTL/LTR |
| **حقول الإدخال** | `<x-sw-input name="title" label="العنوان" required />` | حقل إدخال مع كشف أخطاء التحقق تلقائياً |
| **القوائم** | `<x-sw-select name="status" :options="$options" />` | قائمة منسدلة مجهزة للخيارات |
| **رفع الملفات** | `<x-sw-file-upload name="image" label="الصورة" />` | منطقة سحب وإفلات لرفع الصور ومعاينتها |
| **النوافذ** | `<x-sw-modal id="createModal">...</x-sw-modal>` | نافذة منبثقة تفاعلية مدعومة بـ Alpine.js |
| **الشارات** | `<x-sw-badge type="success" :dot="true">نشط</x-sw-badge>` | شارات الحالة الملونة |
| **التنبيهات** | `<x-sw-alert type="success" message="تم بنجاح" />` | رسائل تنبيهية ملونة قابلة للإغلاق |
| **الحالة الفارغة**| `<x-sw-empty-state title="لا توجد بيانات" />` | واجهة توضيحية عند خلو الجداول |

---

## 🛣️ تسجيل مسارات الموديول (Routing)

أضف مسارات أي موديول جديد داخل `routes/web.php` بسهولة:

```php
use App\Modules\Article\Controllers\ArticleController;

Route::prefix('admin/article')->name('article.')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('index');
    Route::get('/create', [ArticleController::class, 'create'])->name('create');
    Route::post('/', [ArticleController::class, 'store'])->name('store');
    Route::get('/{id}', [ArticleController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [ArticleController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ArticleController::class, 'update'])->name('update');
    Route::delete('/{id}', [ArticleController::class, 'destroy'])->name('destroy');
});
```

> **ملاحظة:** مسارات الـ API داخل الموديول `app/Modules/{Name}/Routes/api.php` يتم تحميلها **تلقائياً** بواسطة الحزمة تحت بادئة `/api`.

---

## 💻 الترخيص والمطور

- **المطور:** ضياء أشرف (Diaa Ashraf)
- **الترخيص:** MIT License © 2026 Stackway
