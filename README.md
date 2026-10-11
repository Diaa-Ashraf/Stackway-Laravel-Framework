# ⚡ Stackway Laravel Framework

> **دليل منظم للهيكل المعماري، الاستخدام، النشر، وطريقة تشغيل الـ Framework.**

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Stackway Core">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel 12.x">
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/License-MIT-0ea5e9?style=for-the-badge" alt="License: MIT">
  <img src="https://img.shields.io/badge/Theme-Obsidian%20Teal-059669?style=for-the-badge" alt="Obsidian Teal Theme">
  <img src="https://img.shields.io/badge/Blade%20Components-21%2B-f59e0b?style=for-the-badge" alt="21+ Blade Components">
</p>

---

## 📌 نظرة عامة على المشروع (README)

🚀 **Stackway Core** — إطار عمل Laravel شخصي و **SaaS Starter Kit**، مبني وفق أعلى معايير **Clean Architecture** و **Modular Architecture**. يوفر لوحة تحكم عصرية جاهزة باسم **Obsidian Teal**، أكثر من 21 مكون Blade متطور، مولد موديولات ذكي، وربط تلقائي للـ Repositories مع دعم كامل للغة العربية (RTL) والوضع الليلي (Dark Mode).

---

## 🌟 الميزات (Features)

- 🏗️ **مولدات Clean Architecture:** توليد موديول كامل بأمر واحد فقط: Model و Migration و Controller و Service و Repository و FormRequests و Views.
- 📊 **لوحة تحكم ديناميكية:** بطاقات KPI لحظية، اكتشاف تلقائي للموديولات، تبديل بين الوضع الداكن والفاتح، ودعم كامل للعربية RTL.
- 🧩 **أكثر من 21 مكون Blade جاهز:** `<x-sw-card>`، `<x-sw-button>`، `<x-sw-stat-card>`، `<x-sw-data-table>`، `<x-sw-modal>`، `<x-sw-input>`، `<x-sw-select>` وغيرها.
- 🔐 **واجهات Auth والملف الشخصي جاهزة:** تصميم حديث متكامل لتسجيل الدخول والتسجيل واستعادة كلمة المرور وإدارة الحساب.
- ⚡ **Traits قابلة لإعادة الاستخدام:** `ApiResponseTrait`، `DashboardResponseTrait`، `ImageUploadTrait`، `SlugTrait`، و `ActivityLogTrait`.
- 🔄 **ربط تلقائي للـ Repositories:** يتم ربط الـ Interfaces بالـ Repositories تلقائياً عبر `StackwayServiceProvider` دون أي إعداد يدوي.
- 🛠️ **حزمة خدمات جاهزة (Batteries Included):** إدارة الكاش، رفع الصور، دعم الترجمة، الصلاحيات، وسجل الأنشطة — كلها متاحة من أول تثبيت.

---

## ⚡ التثبيت السريع (Quick Installation)

### 1. أضف الـ Repository في ملف `composer.json`:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/Diaa-Ashraf/Stackway-Laravel-Framework.git"
    }
]
```

### 2. ثبّت الحزمة عبر Composer:

```bash
composer require stackway/core:dev-main
```

### 3. شغّل أوامر التثبيت وإعداد الـ Auth:

```bash
php artisan stackway:install
php artisan stackway:api-auth
php artisan migrate
```

---

## 🎯 الاستخدام السريع (Quick Usage)

توليد موديول كامل:
```bash
php artisan stackway:module Customer --all
```

الوصول للوحة التحكم عبر: `http://127.0.0.1:8000/admin` أو `/dashboard`

---

## 📄 الترخيص
**MIT License** — تم التطوير بواسطة **Diaa Ashraf**.

---

## 01 | الهدف من المشروع

**Stackway** هو Framework شخصي مبني فوق **Laravel 12** ويتم تطويره كـ Composer Package مستقل، بهدف توحيد طريقة بناء المشاريع وتسريع التطوير مع الحفاظ على تنظيم الكود وقابلية إعادة الاستخدام:

1. **Dashboard احترافية** قابلة لإعادة الاستخدام.
2. **Module-Based Architecture** تنظيم متطور يعزل كل نطاق عمل (Domain).
3. **Smart Artisan Commands** لتوليد الأكواد المعيارية بضغطة زر.
4. **Base Classes و Traits و Support Classes** مشتركة وموحدة.
5. **دعم API و Authentication والمكونات الجاهزة** (Sanctum + Blade).
6. **إمكانية تثبيته في أي مشروع Laravel جديد** بسهولة تامة.

---

## 02 | الخريطة الهيكلية للباكدج

```text
packages/stackway/core/
├── composer.json
├── README.md
├── config/
│   └── stackway.php
├── resources/
│   ├── assets/
│   ├── css/
│   │   └── stackway-theme.css
│   └── views/
│       ├── dashboard.blade.php
│       ├── layouts/
│       │   ├── dashboard.blade.php
│       │   └── auth.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   ├── register.blade.php
│       │   └── forgot-password.blade.php
│       ├── profile/
│       │   └── edit.blade.php
│       └── components/
├── src/
│   ├── StackwayServiceProvider.php
│   ├── Base/
│   │   ├── BaseController.php
│   │   ├── BaseService.php
│   │   ├── BaseRepository.php
│   │   └── BaseRequest.php
│   ├── Commands/
│   │   ├── MakeModuleCommand.php
│   │   ├── InstallDashboardCommand.php
│   │   └── SetupAuthCommand.php
│   ├── Controllers/
│   │   └── DashboardController.php
│   ├── Contracts/
│   ├── Support/
│   │   ├── CacheManager.php
│   │   ├── StorageManager.php
│   │   └── ImageManager.php
│   └── Traits/
│       ├── ApiResponseTrait.php
│       ├── DashboardResponseTrait.php
│       ├── ImageUploadTrait.php
│       ├── SlugTrait.php
│       └── ActivityLogTrait.php
└── stubs/
    └── module/
        ├── controller.stub
        ├── model.stub
        ├── service.stub
        ├── repository.stub
        ├── interface.stub
        ├── request-store.stub
        ├── request-update.stub
        ├── resource.stub
        ├── filter.stub
        ├── migration.stub
        ├── routes/api.stub
        └── views/
```

### 2.1 أهم المجلدات والملفات
- **`composer.json`** — تعريف الباكدج والـ Auto-Discovery والـ Autoloading.
- **`config/stackway.php`** — إعدادات الـ Framework مثل Theme و Modules و Auth.
- **`StackwayServiceProvider.php`** — المحرك الرئيسي لتسجيل الأوامر والمكونات وتحميل الموديولات والربط التلقائي.
- **`Base/`** — الطبقات الأساسية مثل `BaseController` و `BaseService` و `BaseRepository` و `BaseRequest`.
- **`Commands/`** — أوامر Artisan الخاصة بـ Stackway.
- **`Support/`** — مدراء الأدوات المساعدة مثل `CacheManager` و `StorageManager` و `ImageManager`.
- **`Traits/`** — Traits لإعادة الاستخدام مثل `ApiResponseTrait` و `SlugTrait` و `ImageUploadTrait` و `DashboardResponseTrait`.
- **`stubs/`** — قوالب الملفات التي يستخدمها مولد الموديولات الذكي.

---

## 03 | Module-Based Architecture

كل Module مستقل تماماً داخل `app/Modules`، بحيث تكون ملفات الـ Model والـ Controller والـ Requests والـ Services والـ Repositories والـ Routes والـ Views الخاصة بالموديول مجمعة معًا:

```text
app/Modules/Product/
├── Models/
│   └── Product.php
├── Controllers/
│   ├── ProductController.php
│   └── Api/
│       └── ProductController.php
├── Services/
│   └── ProductService.php
├── Repositories/
│   └── ProductRepository.php
├── Contracts/
│   └── ProductRepositoryInterface.php
├── Requests/
│   ├── StoreProductRequest.php
│   └── UpdateProductRequest.php
├── Resources/
│   └── ProductResource.php
├── Views/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── Routes/
│   └── api.php
├── Database/
│   └── Migrations/
└── Filters/
    └── ProductFilter.php
```

> [!TIP]
> **الـ Layers الاختيارية يتم إنشاؤها حسب الحاجة:** ليس من الضروري إنشاء Service أو Repository لكل CRUD بسيط؛ يمكنك الاكتفاء بالطبقات التي يحتاجها مشروعك.

---

## 04 | Auto-Loading للموديولات (الاكتشاف التلقائي)

- كل Module تحتوي على Routes خاصة بها.
- `StackwayServiceProvider` يقوم بتحميل ملفات الـ Routes تلقائيًا.
- لا يحتاج المطور لتعديل `routes/web.php` الأساسي لكل مسارات الـ API.
- يمكن للموديول أن يحتوي على Web Routes و API Routes.
- مسارات الـ API في `app/Modules/{Name}/Routes/api.php` تُحمّل تلقائياً تحت بادئة `/api` مع `middleware(['api'])`.
- الفيوهات تُسجّل تلقائياً تحت namespace باسم الموديول بصيغة snake_case (مثال: `view('product::index')`).
- المايجريشن في `app/Modules/{Name}/Database/Migrations` تُحمّل تلقائياً في `php artisan migrate`.
- واجهات الـ Repositories تُربط تلقائياً بالـ Implementations في الـ IoC Container.

---

## 05 | أوامر Artisan الأساسية

### 5.1 إنشاء Module بالهيكل الأساسي
```bash
php artisan stackway:module Product
```

### 5.2 إنشاء Module مع واجهات API
```bash
php artisan stackway:module Product --api
```

### 5.3 إنشاء Module بكل الطبقات (12 طبقة)
```bash
php artisan stackway:module Product --all
```

### 5.4 الوضع التفاعلي (Interactive Mode)
```bash
php artisan stackway:module Product --interactive
```
يسألك عن الاحتياجات خطوة بخطوة قبل التوليد:
- *Enable API Controller & Resource?*
- *Enable Service Layer?*
- *Enable Repository Pattern with Interface?*
- *Include Cache in Repository?*
- *Enable Translatable fields (Spatie)?*
- *Enable Media Upload (Spatie)?*
- *Enable Pipeline Filter?*

---

## 06 | الملفات التي يولدها Module Generator

### الملفات الأساسية المحدثة دائماً:
1. `Controller` — نحيف ومتصل بالخدمات.
2. `Model` — مزود بـ SoftDeletes ومحددات الـ fillable.
3. `StoreRequest` — مع قواعد التحقق ورسائل عربية.
4. `UpdateRequest` — مع قواعد التعديل ورسائل عربية.
5. `Migration` — ملف إنشاء الجدول بأسماء وفهارس قياسية.
6. `Views` — صفحات الـ CRUD كاملة (`index`, `create`, `edit`, `show`).

### ومع الخيارات الإضافية (Flags):
- **`--service`** → توليد كلاس `Service` لمنطق وقواعد الأعمال.
- **`--repo`** → توليد `Repository` + `Interface` مع الربط التلقائي `binding`.
- **`--api`** → توليد `API Controller` + `JsonResource` + ملف مسارات `api.php`.
- **`--cache`** → تكامل التخزين المؤقت `CacheManager` داخل الـ Repository.
- **`--translation`** → تجهيز الموديل لدعم الحقول متعددة اللغات (Spatie Translatable).
- **`--media`** → تجهيز الموديل لمعالجة ورفع الوسائط (Spatie MediaLibrary).
- **`--filter`** → توليد كلاس `Filter` مخصص للبحث والاستعلامات المتتالية (Pipelines).
- **`--force`** → إعادة كتابة واستبدال الملفات إذا كانت موجودة مسبقاً.
- **`--interactive`** → اختيار المكونات خطوة بخطوة.

---

## 07 | Dashboard & Blade Components

جميع المكونات تستخدم Prefix موحداً: `<x-sw-*>`.

### مثال Stat Card:
```blade
<x-sw-stat-card
    title="إجمالي الطلبات"
    value="1,240"
    icon="shopping-bag"
    change="+12.5%"
    changeType="increase"
    color="primary"
/>
```

### مثال Data Table:
```blade
<x-sw-data-table
    :columns="['#', 'الاسم', 'البريد الإلكتروني', 'الحالة', 'العمليات']"
    :paginator="$users"
>
    @foreach($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td><x-sw-badge type="success" :dot="true">نشط</x-sw-badge></td>
        <td>
            <x-sw-button variant="ghost" size="sm">تعديل</x-sw-button>
        </td>
    </tr>
    @endforeach
</x-sw-data-table>
```

### قائمة الـ 21 مكون Blade المتوفرة:
| المكون | التاج | الوصف |
| :--- | :--- | :--- |
| **Alert** | `<x-sw-alert>` | رسائل تنبيهية ملونة قابلة للإغلاق |
| **Avatar** | `<x-sw-avatar>` | صورة شخصية أو الحروف الأولى من الاسم |
| **Badge** | `<x-sw-badge>` | شارة ملونة مع نقطة حالة (Dot) اختيارية |
| **Breadcrumb** | `<x-sw-breadcrumb>` | شريط التنقل الهرمي للصفحات |
| **Button** | `<x-sw-button>` | أزرار متعددة الأنماط (`primary`, `secondary`, `danger`, `ghost`, `outline`) |
| **Card** | `<x-sw-card>` | بطاقات محتوى بتصميم Soft Shadow أنيق |
| **Checkbox** | `<x-sw-checkbox>` | مربع اختيار حديث متوافق مع الفورم |
| **Data Table** | `<x-sw-data-table>` | جدول بيانات ذكي يدعم الترقيم والبحث |
| **Date Picker** | `<x-sw-date-picker>` | منتقي تواريخ متجاوب وعصري |
| **Empty State** | `<x-sw-empty-state>` | واجهة جذابة عند عدم وجود بيانات |
| **File Upload** | `<x-sw-file-upload>` | رفع ملفات وصور بالسحب والإفلات مع معاينة |
| **Footer** | `<x-sw-footer>` | تذييل الصفحة الخاص بالداشبورد |
| **Header** | `<x-sw-header>` | الهيدر العلوي، البحث، الإشعارات، ومبدل الثيم |
| **Input** | `<x-sw-input>` | حقل إدخال نصوص مع كشف أخطاء التحقق تلقائياً |
| **Loading** | `<x-sw-loading>` | سبينر مؤشر تحميل دائري خفيف |
| **Modal** | `<x-sw-modal>` | نافذة منبثقة تفاعلية مدعومة بـ Alpine.js |
| **Select** | `<x-sw-select>` | قائمة منسدلة أنيقة تدعم خيارات متعددة |
| **Sidebar** | `<x-sw-sidebar>` | القائمة الجانبية التفاعلية القابلة للطي |
| **Stat Card** | `<x-sw-stat-card>` | بطاقات KPI لإحصائيات لوحة التحكم |
| **Textarea** | `<x-sw-textarea>` | حقل نصوص متعدد الأسطر |
| **Toast** | `<x-sw-toast>` | إشعارات عائمة لحظية |

---

## 08 | Base Classes & Architecture

- **`BaseController`** — كلاس Controller أساسي مع helpers مشتركة بدون Business Logic.
- **`BaseService`** — كلاس Service أساسي لمعاملات الـ Database Transactions وقواعد الأعمال.
- **`BaseRepository`** — كلاس مستودع أساسي لعمليات الـ CRUD والـ Pagination والـ Caching.
- **`BaseRequest`** — كلاس FormRequest أساسي مع دوال التحقق ورسائل عربية موحدة.

### مثال Service:
```php
namespace App\Modules\Product\Services;

use Stackway\Core\Base\BaseService;
use App\Modules\Product\Repositories\ProductRepository;

class ProductService extends BaseService
{
    public function __construct(
        protected ProductRepository $repository
    ) {
        parent::__construct($repository);
    }

    public function createProduct(array $data)
    {
        return $this->transaction(function () use ($data) {
            return $this->repository->create($data);
        });
    }
}
```

---

## 09 | Support Classes

- **`CacheManager`** — إدارة الكاش والمفاتيح وعمليات الـ Invalidation الذكية بالبادئات (`forgetByPrefix`).
- **`StorageManager`** — إدارة الملفات والـ Disks والرفع والحذف مع دعم التخزين السحابي والمحلي.
- **`ImageManager`** — معالجة وتصغير الصور وتوليد الـ Thumbnails وصيغة WebP والتحقق من الأبعاد.

---

## 10 | Traits

- **`ApiResponseTrait`** — توحيد إرجاع ردود JSON في الـ APIs بنسق موحد (Success / Error / Paginated).
- **`DashboardResponseTrait`** — رسائل التنبيهات (Flash Messages) ودوال إعادة التوجيه السريعة للوحة التحكم.
- **`ActivityLogTrait`** — تسجيل وتتبع حركات وتعديلات المستخدمين عبر Spatie Activitylog.
- **`SlugTrait`** — إنشاء الـ Slugs الفريدة تلقائياً بالعربية والإنجليزية للموديلز.
- **`ImageUploadTrait`** — تبسيط عمليات رفع وتحديث وحذف الصور المرفقة.

---

## 11 | نشر Stackway على GitHub

يتم رفع محتويات `packages/stackway/core` فقط إلى Repository مستقل:

```bash
# تهيئة المستودع والدفع الأول
git init
git add .
git commit -m "feat: initial release of Stackway Core framework"
git branch -M main
git remote add origin https://github.com/Diaa-Ashraf/Stackway-Laravel-Framework.git
git push -u origin main

# وسم الإصدار
git tag -a v1.0.0 -m "Release version 1.0.0"
git push origin v1.0.0
```

### ملفات يُفضّل تجاهلها (`.gitignore`):
```gitignore
/vendor/
composer.lock
.phpunit.result.cache
.DS_Store
Thumbs.db
```

---

## 12 | استخدام Stackway في مشروع Laravel جديد

### 1. إضافة Repository في `composer.json`:
```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/Diaa-Ashraf/Stackway-Laravel-Framework.git"
    }
]
```

### 2. تثبيت الباكدج:
```bash
composer require stackway/core:dev-main
```

### 3. تشغيل التثبيت والتهيئة:
```bash
php artisan stackway:install
```

### 4. إعداد الـ Authentication للـ API:
```bash
php artisan stackway:api-auth
php artisan migrate
```

### 5. إنشاء Module جديد:
```bash
php artisan stackway:module Order --all
php artisan migrate
```

---

## 13 | شكل الاستخدام النهائي

```text
Laravel Project
│
├── composer require stackway/core:dev-main
│
├── php artisan stackway:install
│
├── php artisan stackway:api-auth
│
└── php artisan stackway:module Order --all
    │
    ├── Model
    ├── Controller
    ├── Requests
    ├── Service
    ├── Repository
    ├── API
    ├── Views
    └── Routes
```

---

## 14 | رفع الحزمة وإعادة استخدامها في أي مشروع قادم

تستطيع مشاركة الحزمة واستخدامها في أي مشروع لارافيل جديد بإحدى الطرق الثلاث التالية:

### 14.1 حزمة عامة أو خاصة على GitHub / Packagist (الأسهل والأشيع)
1. **إنشاء المستودع:** قم بإنشاء مستودع جديد على GitHub باسم مثلاً `Stackway-Laravel-Framework`.
2. **رفع محتوى الحزمة:** ارفع مجلد `packages/stackway/core` كاملاً إلى المستودع.
3. **النشر على Packagist (اختياري):** إذا أردت جعلها حزمة عامة، سجل في `packagist.org` واربط الـ Repository باسم `stackway/core`.
4. **التثبيت في أي مشروع جديد:**
   ```bash
   composer require stackway/core:dev-main
   ```

### 14.2 مستودع GitHub خاص (Private Repository)
إذا كانت الحزمة خاصة بك، أضف في ملف `composer.json` للمشروع الجديد:
```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/Diaa-Ashraf/Stackway-Laravel-Framework.git"
    }
]
```
ثم قم بتثبيتها عبر:
```bash
composer require stackway/core:dev-main
```

### 14.3 العمل المحلي على نفس الجهاز (Local Path Repository)
إذا كنت تطور على جهازك وتريد ربط الحزمة بمشاريع أخرى بدون رفعها إلى الإنترنت:
```json
"repositories": [
    {
        "type": "path",
        "url": "../packages/stackway/core"
    }
]
```
ثم تشغيل:
```bash
composer require stackway/core:dev-main
```

---

## 15 | أوامر Artisan المتاحة وكيفية استخدامها

الحزمة تزودك بثلاثة أوامر CLI قوية مخصصة لتسريع التطوير وتطبيق معمارية Clean Architecture:

### 15.1 الأمر الأول — `stackway:install`
```bash
php artisan stackway:install {--force}
```
**وظيفته:** تهيئة الحزمة في المشروع، ونشر ملف الإعدادات `config/stackway.php` وثيم التصميم والـ Assets الأساسية، وتهيئة Alpine.js و CSS، ونشر مايجريشن وإعدادات الحزم التابعة (Sanctum, Spatie Permission, Activitylog, MediaLibrary).

- `--force` — لإعادة الكتابة واستبدال الملفات القديمة المنشورة.

### 15.2 الأمر الثاني — `stackway:api-auth`
```bash
php artisan stackway:api-auth {--force}
```
**وظيفته:** تثبيت وتجهيز نظام كامل لتسجيل الدخول والتسجيل وإدارة الجلسات عبر الـ API باستخدام Laravel Sanctum.
- يولد `AuthController.php` و `LoginRequest.php` و `RegisterRequest.php` ومسارات `api.php`.
- `--force` — استبدال الملفات الحالية.

### 15.3 الأمر الثالث (العملاق) — `stackway:module {ModuleName}`
**وظيفته:** إنشاء موديول كامل مستقل داخل مجلد `app/Modules/{Name}` يتبع أفضل معايير التصميم النظيف.

```bash
php artisan stackway:module Order --all
```
يولد كل الطبقات دفعة واحدة:
- **Model + Migration**
- **Controller** — خفيف ومرتبط بالخدمة
- **Service** — لقواعد الأعمال والعمليات
- **Repository** — للاستعلامات وإدارة قواعد البيانات
- **StoreRequest & UpdateRequest** — مع رسائل تحقق عربية جاهزة
- **Views** — صفحات `index`, `create`, `edit`, `show` جاهزة ومتناسقة
- **API Controller + Resource + Routes**
- **Filter** — للبحث المتقدم

---

## 16 | هيكل المسارات (Routing Architecture)

تم ضبط الحزمة لتعمل وفق المعيار الأفضل في لارافيل: **Single Source of Truth** داخل ملف واحد مركزي للويب مع تحميل تلقائي للـ API.

### 📄 الملف المركزي: `routes/web.php`

#### 1. المسارات الأساسية للحزمة:
- `/admin` — لوحة التحكم الرئيسية (تكتشف الموديولات المنشأة تلقائياً وتنشئ إحصائياتها).
- `/admin/profile` — صفحة الملف الشخصي وتغيير كلمة المرور.
- `/login` & `/register` — صفحات المصادقة التابعة للحزمة.

#### 2. مسارات أي موديول جديد (مثال: Note):
تضاف بسهولة داخل مجموعة الراوت:
```php
use App\Modules\Note\Controllers\NoteController;

Route::middleware(['web', 'auth'])->prefix('admin/note')->name('note.')->group(function () {
    Route::get('/', [NoteController::class, 'index'])->name('index');
    Route::get('/create', [NoteController::class, 'create'])->name('create');
    Route::post('/', [NoteController::class, 'store'])->name('store');
    Route::get('/{id}', [NoteController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [NoteController::class, 'edit'])->name('edit');
    Route::put('/{id}', [NoteController::class, 'update'])->name('update');
    Route::delete('/{id}', [NoteController::class, 'destroy'])->name('destroy');
});
```

> [!NOTE]
> مسارات الـ API داخل الموديول `app/Modules/{Name}/Routes/api.php` يتم تحميلها **تلقائياً** بواسطة الحزمة تحت بادئة `/api` — لا حاجة لتسجيلها يدوياً.

---

## 17 | خطوات التثبيت بالتفصيل في مشروع جديد

عند بدء مشروع لارافيل جديد من الصفر:

1. **تثبيت الحزمة:**
   ```bash
   composer require stackway/core:dev-main
   ```
2. **تجهيز الإعدادات ونظام الـ Auth:**
   ```bash
   php artisan stackway:install
   php artisan stackway:api-auth
   ```
3. **تشغيل المايجريشن:**
   ```bash
   php artisan migrate
   ```
4. **تشغيل خادم التطوير والبناء:**
   ```bash
   npm run dev
   php artisan serve
   ```
5. **فتح لوحة التحكم:**
   افتح المتصفح على `http://127.0.0.1:8000/admin` وستكون لوحة التحكم جاهزة بالكامل.

---

## 18 | ماذا ينزل مع الحزمة (محتويات Stackway Core الداخلية)

### 18.1 المعمارية البرمجية الأساسية (Base Classes)
- `BaseController`
- `BaseService`
- `BaseRepository`
- `BaseRequest`

### 18.2 الـ Traits الخدمية الجاهزة
- **`ApiResponseTrait`** — لتوحيد إرجاع ردود JSON في الـ APIs.
- **`DashboardResponseTrait`** — لتبسيط إرجاع التنبيهات وإعادة التوجيه في لوحة التحكم.
- **`ImageUploadTrait`** — لمعالجة ورفع وضغط الصور بسهولة.
- **`SlugTrait`** — لتوليد الـ Slugs تلقائياً بالعربية والإنجليزية.
- **`ActivityLogTrait`** — لتسجيل أنشطة وتعديلات المستخدمين.

### 18.3 القوالب والتصميم (Views & Layouts)
- `stackway::layouts.dashboard` — قالب لوحة التحكم الشامل مع سايدبار تفاعلي وهيدر ذكي وتبديل لغات وبحث سريع.
- `stackway::layouts.auth` — قالب صفحات المصادقة.
- `stackway::dashboard` — صفحة لوحة التحكم الرئيسية.
- `stackway::profile.edit` — صفحة الملف الشخصي.

### 18.4 مكتبة مكونات Blade الشاملة (`<x-sw-*>`)
- **البطاقات:** `<x-sw-card title="العنوان">...</x-sw-card>`
- **الأزرار:** `<x-sw-button variant="primary">حفظ</x-sw-button>`
- **بطاقات الإحصائيات:** `<x-sw-stat-card title="المستخدمين" value="1,250" icon="users" />`
- **الجداول الذكية:** `<x-sw-data-table>...</x-sw-data-table>`
- **النوافذ المنبثقة:** `<x-sw-modal id="myModal">...</x-sw-modal>`
- **الحقول والنصوص:** `<x-sw-input name="title" label="العنوان" />`
- **القوائم المنسدلة:** `<x-sw-select name="status" :options="$options" />`
- **التنبيهات:** `<x-sw-alert type="success" message="تم بنجاح" />`
- **رفع الملفات:** `<x-sw-file-upload name="image" />`
- **الحالة الفارغة:** `<x-sw-empty-state title="لا توجد بيانات" />`

---

## 19 | ماذا تضيف في مشروعك بعد تنزيل الحزمة؟

1. **إنشاء موديولاتك الخاصة:**
   ```bash
   php artisan stackway:module Customer --all
   ```
2. **إضافة الحقول إلى الـ Migration والـ Views:**
   - عدّل ملف الـ Migration الناتج ليشمل أعمدة الجدول الخاصة بك.
   - افتح `app/Modules/Customer/Views/create.blade.php` وضع حقول الإدخال باستخدام `<x-sw-input>`.
3. **إضافة الـ Routes:**
   - أضف مسارات الموديول في `routes/web.php`.
4. **تلقائياً وبدون أي كود إضافي:**
   - ستظهر الموديولات الجديدة داخل القائمة الجانبية (Sidebar) في لوحة التحكم.
   - ستظهر إحصائيات الموديول في الصفحة الرئيسية للوحة التحكم.
   - سيعمل الوضع الليلي (Dark Mode) واللغة العربية (RTL) بشكل تلقائي ومتكامل 100%.

---

## 20 | الهيكل الداخلي الكامل لملفات ومجلدات الباكدج

```text
packages/stackway/core/
├── composer.json
├── README.md
├── config/
│   └── stackway.php
├── src/
│   ├── StackwayServiceProvider.php
│   ├── Base/
│   │   ├── BaseController.php
│   │   ├── BaseService.php
│   │   ├── BaseRepository.php
│   │   └── BaseRequest.php
│   ├── Commands/
│   │   ├── MakeModuleCommand.php
│   │   ├── InstallDashboardCommand.php
│   │   └── SetupAuthCommand.php
│   ├── Controllers/
│   │   └── DashboardController.php
│   ├── Traits/
│   │   ├── ApiResponseTrait.php
│   │   ├── DashboardResponseTrait.php
│   │   ├── ImageUploadTrait.php
│   │   ├── SlugTrait.php
│   │   └── ActivityLogTrait.php
│   └── Support/
│       ├── CacheManager.php
│       ├── ImageManager.php
│       └── StorageManager.php
├── resources/
│   ├── css/
│   │   └── stackway-theme.css
│   └── views/
│       ├── dashboard.blade.php
│       ├── layouts/
│       │   ├── dashboard.blade.php
│       │   └── auth.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   ├── register.blade.php
│       │   └── forgot-password.blade.php
│       ├── profile/
│       │   └── edit.blade.php
│       └── components/
└── stubs/
    └── module/
```

### 20.1 ملفات الجذر و `config/`
- **`composer.json`** — ملف تعريف الباكدج والاعتماديات التلقائية.
- **`README.md`** — التوثيق الرسمي للحزمة.
- **`config/stackway.php`** — ملف الإعدادات العام (الراوت، الثيم، مسارات الموديولات).

### 20.2 `src/` — الشيفرة المصدرية
- **`StackwayServiceProvider.php`** — مشغل الباكدج، الاكتشاف التلقائي، وربط الـ Repositories.
- **`Base/BaseController.php`** — كلاس أساسي للمتحكمات مع دوال الردود والتحقق.
- **`Base/BaseService.php`** — كلاس أساسي لطبقة الأعمال والمنطق (Business Logic).
- **`Base/BaseRepository.php`** — كلاس أساسي لعمليات قواعد البيانات والاستعلامات المتقدمة.
- **`Base/BaseRequest.php`** — كلاس أساسي للتحقق مع رسائل عربية موحدة.
- **`Commands/MakeModuleCommand.php`** — المولد الشامل للموديولات (`stackway:module`).
- **`Commands/InstallDashboardCommand.php`** — أمر التثبيت والتهيئة (`stackway:install`).
- **`Commands/SetupAuthCommand.php`** — أمر إعداد المصادقة عبر API (`stackway:api-auth`).
- **`Controllers/DashboardController.php`** — يجمع إحصائيات الموديولات والبيانات الحية.
- **`Support/CacheManager.php`** — إدارة الكاش الذكي للموديولات.
- **`Support/ImageManager.php`** — معالجة وتصغير وتحويل الصور.
- **`Support/StorageManager.php`** — إدارة التخزين والملفات.

### 20.3 `resources/` — الواجهات والتصميم
- **`css/stackway-theme.css`** — ملف نظام التصميم الكامل والثيم.
- **`views/dashboard.blade.php`** — الصفحة الرئيسية للوحة التحكم.
- **`layouts/dashboard.blade.php`** — القالب الرئيسي (Sidebar + Header + Content).
- **`layouts/auth.blade.php`** — قالب صفحات تسجيل الدخول.
- **`auth/login.blade.php`, `register.blade.php`, `forgot-password.blade.php`** — واجهات المصادقة.
- **`profile/edit.blade.php`** — واجهة الملف الشخصي وتغيير كلمة المرور.
- **`components/`** — 21 مكون Blade جاهز ببادئة `<x-sw-*>`.

### 20.4 `stubs/module/` — قوالب توليد الموديولات
- `model.stub`, `migration.stub`, `controller.stub`, `service.stub`
- `repository.stub`, `interface.stub`
- `request-store.stub`, `request-update.stub`
- `resource.stub`, `filter.stub`, `routes/api.stub`
- `views/` (`index`, `create`, `edit`, `show`)

---

## 21 | ماذا ينزل مع الباكدج عند تثبيتها في مشروع جديد؟

### 21.1 الاعتماديات الأساسية التلقائية (Batteries-Included):
- **`spatie/laravel-permission`** — لإدارة الأدوار والصلاحيات (Roles & Permissions).
- **`spatie/laravel-activitylog`** — لتسجيل وتتبع كل عمليات الإنشاء والتعديل والحذف.
- **`spatie/laravel-medialibrary`** — لإدارة ورفع الصور والملفات المتعددة.
- **`spatie/laravel-translatable`** — لدعم الموديولات متعددة اللغات.
- **`laravel/sanctum`** — لنظام التوكن والمصادقة للـ Mobile Apps وواجهات الـ API.
- **`laravel/socialite`** — لتسجيل الدخول عبر Google و Facebook.

### 21.2 عند تشغيل `php artisan stackway:install`:
- **نشر الإعدادات:** يتم إنشاء ملف `config/stackway.php` في مشروعك.
- **إنشاء مجلد الموديولات:** يتم إنشاء مجلد `app/Modules/` جاهزاً لاستقبال موديولاتك.
- **تفعيل نظام التصميم:** يتم دمج الـ Theme و Alpine.js تلقائياً ليعمل الداش بورد فوراً.

---

## 22 | دليل أوامر Artisan وخياراتها بالتفصيل الكامل

### 22.1 الأمر — `stackway:install`
```bash
php artisan stackway:install {--force}
```
- تهيئة الحزمة ونشر الملفات داخل المشروع.
- `--force` — إعادة كتابة واستبدال الملفات إذا كانت موجودة مسبقاً.

### 22.2 الأمر — `stackway:api-auth`
```bash
php artisan stackway:api-auth {--force}
```
تجهيز نظام كامل لتسجيل الدخول عبر الـ API باستخدام Sanctum:
- `app/Modules/Auth/Controllers/Api/AuthController.php` — تسجيل، دخول، خروج، واسترجاع بيانات المستخدم.
- كلاسات التحقق `LoginRequest.php` و `RegisterRequest.php`.
- مسارات الـ API في `app/Modules/Auth/Routes/api.php`.
- `--force` — استبدال الملفات القديمة.

### 22.3 الأمر الرئيسي — `stackway:module {Name}`
توليد موديول كامل يتبع معمارية Clean Architecture:

```bash
php artisan stackway:module Customer --all
```

#### جدول الخيارات المنفصلة بالتفصيل:
| الخيار | الوصف | ما يقوم بإنشائه |
| :--- | :--- | :--- |
| **`--all`** | إنشاء كل الطبقات المتاحة دفعة واحدة (12 طبقة) | يولد كامل هيكل الموديول |
| **`--service`** | إنشاء طبقة الخدمة لقواعد الأعمال | `Services/{Name}Service.php` |
| **`--repo`** | إنشاء المستودع والعقد البرمجي | `Repositories/` و `Contracts/` |
| **`--api`** | إنشاء كنترولر ومسارات وموارد الـ API | `Controllers/Api/`, `Resources/`, `Routes/api.php` |
| **`--filter`** | إنشاء كلاس فلترة وبحث متقدم | `Filters/{Name}Filter.php` |
| **`--cache`** | ربط الموديول بنظام التخزين المؤقت التلقائي | كاش ذكي داخل الـ Repository |
| **`--media`** | إضافة دعم رفع الصور والملفات المتعددة | تكامل Spatie MediaLibrary في الموديل |
| **`--translation`** | إضافة دعم ترجمة الحقول لأكثر من لغة | تكامل Spatie Translatable في الموديل |
| **`--interactive`** | تشغيل المعالج التفاعلي خطوة بخطوة | يطرح عليك أسئلة لكل طبقة لاختيارها |
| **`--force`** | إعادة كتابة واستبدال الملفات الموجودة | استبدال آمن للملفات السابقة |

---

## 23 | ماذا تفعل كل طبقة في الموديول المولد؟

عند تشغيل `php artisan stackway:module Article --all`، يتم إنشاء المعمارية التالية:

1. **`Models/Article.php`** — موديل Eloquent مجهز بالـ Soft Deletes، ومحددات الحقول، وتتبع الأنشطة.
2. **`Database/Migrations/xxxx_create_articles_table.php`** — جدول قاعدة البيانات مع أعمدة قياسية وفهارس.
3. **`Controllers/ArticleController.php`** — كنترولر نحيف وخفيف (Thin Controller) لا يحتوي على أي كود استعلام، بل يطلب العمليات من الـ Service مباشرة.
4. **`Services/ArticleService.php`** — يحتوي على قواعد الأعمال والمنطق، ويتعامل مع الـ Repository.
5. **`Contracts/ArticleRepositoryInterface.php`** — عقد الواجهة لضمان معايير الـ Dependency Inversion (SOLID).
6. **`Repositories/ArticleRepository.php`** — استعلامات قاعدة البيانات المتقدمة وإدارة السجلات (يتم ربطه تلقائياً بالـ Interface).
7. **`Requests/StoreArticleRequest.php` و `UpdateArticleRequest.php`** — التحقق من صحة المدخلات مع رسائل خطأ واضحة باللغة العربية.
8. **`Controllers/Api/ArticleController.php` و `Resources/ArticleResource.php`** — جاهزة لخدمة تطبيقات الموبايل أو الـ Frontend الخارجي (React / Vue / Flutter).
9. **`Views/`**:
   - `index.blade.php` — جدول البيانات الذكي مع أزرار الإضافة والتعديل والحذف والبحث.
   - `create.blade.php` — نموذج الإضافة بتصميم متناسق.
   - `edit.blade.php` — نموذج التعديل.
   - `show.blade.php` — صفحة تفاصيل السجل.

---

## 24 | ما الذي تضيفه أنت بعد التوليد؟

1. **الـ Migration:**
   تفتح ملف المايجريشن وتضيف الأعمدة الخاصة بجدولك (مثل: `price`, `content`, `image`... إلخ).
2. **الـ Routes:**
   تضيف مجموعة الراوت الخاصة بالموديول في ملف `routes/web.php`:
   ```php
   use App\Modules\Article\Controllers\ArticleController;

   Route::middleware(['web', 'auth'])->prefix('admin/article')->name('article.')->group(function () {
       Route::resource('/', ArticleController::class);
   });
   ```
3. **الـ Views:**
   تضع حقولك الإضافية في صفحتي `create.blade.php` و `edit.blade.php` باستخدام مكونات `<x-sw-input>` و `<x-sw-select>`.

> [!NOTE]
> بمجرد حفظ هذه الخطوات الثلاث، يكون لديك نظام SaaS كامل واحترافي يعمل بكفاءة وأمان!

---

## 25 | إعداد Tailwind CSS (اختياري)

إذا كنت تستخدم Tailwind CSS في مشروعك، أضف مسار موديولات Stackway في مصفوفة `content` داخل `tailwind.config.js` حتى يتم اكتشاف الـ Classes المستخدمة داخل ملفات الموديولات:

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

> [!WARNING]
> بدون إضافة هذا المسار، قد لا تظهر تنسيقات Tailwind المستخدمة داخل صفحات الموديولات (`app/Modules/**/*.blade.php`) بعد عملية الـ Build.

---

## 26 | تحديثات على أوامر install و module

### 26.1 خيار `--force` الجديد
يتوفر الآن خيار `--force` على كل من أمري التثبيت والتوليد:
```bash
# إعادة نشر ملفات التثبيت واستبدال القديم
php artisan stackway:install --force

# إنشاء موديول واستبدال الملفات القديمة
php artisan stackway:module Customer --all --force
```

### 26.2 أمثلة إضافية لدمج الخيارات
```bash
# الوضع التفاعلي خطوة بخطوة
php artisan stackway:module Customer --interactive

# إنشاء طبقات محددة فقط معاً
php artisan stackway:module Customer --service --repo --api
```

### 26.3 تفاصيل إضافية لما ينشره `stackway:install`:
- **نشر ملف الإعدادات:** `config/stackway.php`
- **نشر ملف الثيم المحدث:** `resources/css/stackway-theme.css` (ثيم Obsidian Teal)
- **إنشاء مجلد الموديولات:** `app/Modules/`
- **تهيئة ملفات الـ Assets:** `resources/css/app.css` و `resources/js/app.js` تلقائياً.

---

## 27 | مكونات ومسارات جديدة

### 27.1 مكون الشارات — Badge
```blade
<x-sw-badge type="success" :dot="true">نشط</x-sw-badge>
```
يعرض شارات حالة ملونة (`success`, `danger`, `warning`, `info`)، مع إمكانية إظهار نقطة (`dot`) بجانب النص للدلالة على الحالة.

### 27.2 جدول بديل خفيف — `sw-table`
بجانب مكوّن `<x-sw-data-table>` الذكي (بحث وفرز و Pagination)، تتوفر أيضاً Class جاهزة لجدول HTML عادي عالي التباين ومتوافق مع RTL/LTR:

```blade
<table class="sw-table">
    <thead>
        <tr>
            <th>#</th>
            <th>العنوان</th>
            <th>الحالة</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>مثال تجريبي</td>
            <td><x-sw-badge type="success">مفعل</x-sw-badge></td>
        </tr>
    </tbody>
</table>
```

### 27.3 هيكل الموديول الكامل (محدّث)
عند تشغيل `php artisan stackway:module Article --all` يتم إنشاء الهيكل كاملاً داخل `app/Modules/Article`:

```text
app/Modules/Article/
├── Models/
│   └── Article.php
├── Database/
│   └── Migrations/
├── Controllers/
│   ├── ArticleController.php
│   └── Api/
│       └── ArticleController.php
├── Services/
│   └── ArticleService.php
├── Repositories/
│   └── ArticleRepository.php
├── Contracts/
│   └── ArticleRepositoryInterface.php
├── Requests/
│   ├── StoreArticleRequest.php
│   └── UpdateArticleRequest.php
├── Resources/
│   └── ArticleResource.php
├── Filters/
│   └── ArticleFilter.php
├── Routes/
│   └── api.php
└── Views/
    ├── index.blade.php
    ├── create.blade.php
    ├── edit.blade.php
    └── show.blade.php
```

### 27.4 تسجيل المسارات — مع ملاحظة تحميل API التلقائي
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

> [!TIP]
> مسارات الـ API داخل الموديول `app/Modules/{Name}/Routes/api.php` يتم تحميلها **تلقائياً** بواسطة الحزمة تحت بادئة `/api` — لا حاجة لتسجيلها يدوياً.

### 27.5 الترخيص والمطور (محدّث)
- **الترخيص:** MIT License © 2026 Stackway
- **المطور:** ضياء أشرف (Diaa Ashraf)
- **المستودع:** [Diaa-Ashraf/Stackway-Laravel-Framework](https://github.com/Diaa-Ashraf/Stackway-Laravel-Framework)
