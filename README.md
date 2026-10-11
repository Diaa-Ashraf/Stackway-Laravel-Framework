# ⚡ Stackway Core — إطار عمل Laravel 12 & SaaS Starter Kit

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="280" alt="Laravel 12">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Architecture-Modular%20%26%20Clean-059669?style=for-the-badge" alt="Modular Architecture">
  <img src="https://img.shields.io/badge/License-MIT-0ea5e9?style=for-the-badge" alt="License: MIT">
</p>

---

## 📖 نظرة عامة (Overview)

**Stackway Core (`stackway/core`)** هو حزمة وإطار عمل متطور لتطبيقات **Laravel 12**، صُمم خصيصاً لبناء تطبيقات SaaS ولوحات التحكم المعقدة بسرعة وأعلى كفاءة معمارية.

يعتمد الإطار على مبادئ **Clean Architecture** و **Modular Domain-Driven Structure** مع نظام اكتشاف تلقائي للموديولات ومكتبة مكونات Blade مجهزة بأحدث معايير تجربة المستخدم وثيم بصري جذاب يدعم الوضع الليلي واللغة العربية بالكامل (RTL).

---

## 🌟 أبرز مميزات إطار العمل

| الميزة                                   | الوصف التقني                                                                                         |
| :--------------------------------------- | :--------------------------------------------------------------------------------------------------- |
| 🏗️ **المعمارية المعيارية (Modular)**     | عزل كامل للمنطق البرمجي داخل `app/Modules/{ModuleName}`. كل موديول يحتوي على مجلداته المستقلة.       |
| ⚡ **مولد الموديولات (Smart Generator)** | أمر Artisan فائق الذكاء يولد طبقات الموديول الـ 12 تلقائياً مع خيارات تفاعلية أو مخصصة.              |
| 🔄 **الربط التلقائي للـ Repositories**   | يتم ربط الـ Interfaces بالـ Repositories تلقائياً في حاوية الخدمات (IoC) دون الحاجة لتعريفها يدوياً. |
| 🚀 **Auto-Discovery للراوتات والفيوهات** | يتم اكتشاف الـ Views والمايجريشن ومسارات الـ API لأي موديول جديد وتضمينها ذاتياً لحظة إنشائه.        |
| 🧩 **21+ مكون Blade جاهز (`<x-sw-*>`)**  | مكونات واجهة مستخدم متقدمة، بطاقات، أزرار، حقول إدخال، جداول، ونوافذ منبثقة متناسقة 100%.            |
| 🌓 **ثيم Obsidian / InApp تفاعلي**       | دعم أصيل للوضع الداكن (Dark Mode) وتوافقية كاملة مع اتجاه النصوص العربية (RTL).                      |
| 🔐 **نظام API Auth جاهز**                | تثبيت كامل لمصادقة Sanctum للموبايل وSPA بضغطة زر.                                                   |
| 🧰 **مكتبة كلاسات و Traits مساعدة**      | توحيد ردود الـ API والداشبورد، إدارة الكاش، رفع الصور، والـ Slugs التلقائي.                          |

---

## 📋 المتطلبات (Requirements)

- **PHP:** `^8.2` أو أحدث
- **Laravel Framework:** `^11.0` أو `^12.0`
- **Composer:** `^2.0`

---

## 📦 خطوات التثبيت في أي مشروع جديد (Installation)

### 1. إضافة المستودع إلى `composer.json`

في ملف `composer.json` الخاص بمشروع لارافيل، أضف رابط مستودع الـ VCS داخل قسم `repositories`:

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

### 3. تشغيل أمر التهيئة والتثبيت الأساسي

```bash
php artisan stackway:install
```

> **ملاحظة:** إذا كنت قد قمت بتثبيت الحزمة مسبقاً وتريد استبدال الملفات المنشورة وتحديثها، أضف الفلاج `--force`:
>
> ```bash
> php artisan stackway:install --force
> ```

### 4. تشغيل المايجريشن

```bash
php artisan migrate
```

---

## 🛠️ دليل أوامر Artisan بالتفصيل (CLI Commands)

توفر الحزمة 3 أوامر رئيسية تغطي دورة حياة المشروع بالكامل:

```
php artisan stackway:install    # تثبيت وتهيئة ونشر موارد الباكيدج
php artisan stackway:module     # توليد موديول جديد بمعمارية Clean Architecture
php artisan stackway:api-auth   # إعداد وتوليد نظام مصادقة API عبر Sanctum
```

---

### 1️⃣ أمر التثبيت والتهيئة: `stackway:install`

يقوم هذا الأمر بإعداد بيئة العمل بالكامل وتشغيل المهام التالية تلقائياً:

```bash
php artisan stackway:install {--force}
```

#### ما يقوم به الأمر خلف الكواليس:

1. **نشر ملف الإعدادات:** ينسخ `config/stackway.php` إلى مجلد `config/` بمشروعك.
2. **نشر ثيم التصميم:** ينسخ `resources/css/stackway-theme.css`.
3. **نشر الأصول الثابتة (Assets):** ينقل الصور والأيقونات إلى مجلد `public/assets`.
4. **إنشاء مجلد الموديولات:** يُنشئ مجلد `app/Modules/` مع ملف `.gitkeep`.
5. **تهيئة ملفات الـ Assets:**
   - يضيف تلقائياً `@import './stackway-theme.css';` في ملف `resources/css/app.css`.
   - يقوم بتهيئة وتشغيل **Alpine.js** داخل `resources/js/app.js` إذا لم يكن مفعلاً.
6. **تهيئة الحزم التابعة:**
   - ينشر إعدادات **Laravel Sanctum**.
   - ينشر إعدادات ومايجريشن **Spatie Permission**.
   - ينشر مايجريشن **Spatie Activitylog**.
   - ينشر مايجريشن **Spatie MediaLibrary**.

---

### 2️⃣ أمر توليد الموديولات الذكي: `stackway:module`

الأمر الأقوى في الفريم ورك؛ يتيح لك إنشاء موديول متكامل بكل طبقاته خلال ثانية واحدة:

```bash
php artisan stackway:module {name} [خيارات]
```

#### أمثلة الاستخدام:

```bash
# إنشاء موديول كامل بكل الطبقات (12 طبقة)
php artisan stackway:module Product --all

# إنشاء موديول واستبدال أي ملفات قديمة (Force Overwrite)
php artisan stackway:module Product --all --force

# تشغيل المعالج التفاعلي خطوة بخطوة للاختيار
php artisan stackway:module Order --interactive

# إنشاء طبقات محددة فقط (مثل Service و Repository والـ API)
php artisan stackway:module Customer --service --repo --api
```

#### جدول جميع خيارات (Flags) أمر `stackway:module`:

| الخيار (Flag)   | الوصف                                                               | الطبقة المولدة                                     |
| :-------------- | :------------------------------------------------------------------ | :------------------------------------------------- |
| `name`          | **(إجباري)** اسم الموديول بصيغة مفردة (مثل: `Product`, `Invoice`).  | المجلد الرئيسي للموديول                            |
| `--all`         | توليد كافة الطبقات الـ 12 المتوفرة بضغطة واحدة.                     | كافة الطبقات أدناه                                 |
| `--interactive` | فتح معالج تفاعلي يسألك عبر الـ Terminal عن تفعيل كل خيار.           | مخصص حسب اختيارك                                   |
| `--force`       | إعادة توليد وكتابة الملفات حتى لو كانت موجودة مسبقاً.               | استبدال آمن                                        |
| `--service`     | توليد طبقة الـ Service لاحتواء قواعد ومنطق الأعمال.                 | `Services/{Name}Service.php`                       |
| `--repo`        | توليد نمط المستودع (Repository Pattern) مع واجهة العقد (Interface). | `Repositories/` & `Contracts/`                     |
| `--api`         | توليد API Controller ومسارات API و API Resource.                    | `Controllers/Api/`, `Resources/`, `Routes/api.php` |
| `--filter`      | توليد كلاس فلترة وبحث متقدم عبر Pipeline.                           | `Filters/{Name}Filter.php`                         |
| `--cache`       | تفعيل التخزين المؤقت الذكي في الـ Repository تلقائياً.              | كاش مدمج في الـ Repository                         |
| `--media`       | تفعيل دعم رفع ومعالجة الصور عبر Spatie MediaLibrary.                | تكامل مع الموديل                                   |
| `--translation` | تفعيل دعم الحقول متعددة اللغات عبر Spatie Translatable.             | تكامل مع الموديل                                   |

---

### 3️⃣ أمر إعداد مصادقة الـ API: `stackway:api-auth`

ينشئ نظام مصادقة API قياسي وآمن مبني على **Laravel Sanctum**:

```bash
php artisan stackway:api-auth {--force}
```

#### ما يتم توليده داخل `app/Modules/Auth/`:

- `Controllers/Api/AuthController.php` (دوال `register`, `login`, `logout`, `profile`).
- `Requests/LoginRequest.php` (التحقق من صحة البريد وكلمة المرور برسائل عربية).
- `Requests/RegisterRequest.php` (التحقق من بيانات التسجيل الجديد).
- `Routes/api.php` (مسارات الـ API المسجلة تلقائياً).

#### مسارات الـ Endpoints الناتجة:

| Method | Endpoint             | الحماية (Middleware) | الوظيفة                              |
| :----- | :------------------- | :------------------- | :----------------------------------- |
| `POST` | `/api/auth/register` | Public               | تسجيل مستخدم جديد وإرجاع Token       |
| `POST` | `/api/auth/login`    | Public               | تسجيل الدخول وإصدار Bearer Token     |
| `POST` | `/api/auth/logout`   | `auth:sanctum`       | تسجيل الخروج وإلغاء الـ Token الحالي |
| `GET`  | `/api/auth/profile`  | `auth:sanctum`       | إرجاع بيانات المستخدم المسجل         |

---

## 🏛️ معمارية الموديول (Module Architecture)

عند توليد موديول جديد باستخدام خيار `--all`، يتم تنظيمه داخل `app/Modules/{Name}` بالشكل المعماري التالي:

```text
app/Modules/Product/
├── Models/
│   └── Product.php                     # Eloquent Model مزود بـ SoftDeletes ومسار الأنشطة
├── Database/
│   └── Migrations/
│       └── 2026_10_11_create_products_table.php  # مايجريشن الجدول
├── Controllers/
│   ├── ProductController.php           # Thin Controller للويب والداشبورد
│   └── Api/
│       └── ProductController.php       # API Controller لخدمات الفرونت والموبايل
├── Services/
│   └── ProductService.php              # Business Logic والمعاملات المالية والمعقدة
├── Repositories/
│   └── ProductRepository.php           # استعلامات قاعدة البيانات والتخزين المؤقت
├── Contracts/
│   └── ProductRepositoryInterface.php  # واجهة العقد البرمجي لتحقيق مبادئ SOLID
├── Requests/
│   ├── StoreProductRequest.php         # التحقق من بيانات الإنشاء (مع رسائل عربية)
│   └── UpdateProductRequest.php        # التحقق من بيانات التعديل (مع رسائل عربية)
├── Resources/
│   └── ProductResource.php             # تحويل وتنسيق مخرجات JSON في الـ API
├── Filters/
│   └── ProductFilter.php               # محرك البحث والفلترة المتقدم عبر Pipelines
├── Routes/
│   └── api.php                         # مسارات الـ API الخاصة بالموديول (تحمل تلقائياً)
└── Views/
    ├── index.blade.php                 # جدول عرض السجلات، الفلترة، والترقيم
    ├── create.blade.php                # فورم إضافة سجل جديد
    ├── edit.blade.php                  # فورم تعديل السجل
    └── show.blade.php                  # صفحة تفاصيل السجل
```

---

## 🔄 كيف يعمل الاكتشاف التلقائي (Auto-Discovery)؟

يقوم `StackwayServiceProvider` بإدارة الموديولات المنشأة داخل `app/Modules` بصورة ذاتية تماماً وبدون أي تدخل يدوي:

1. **الربط التلقائي للـ Contracts (IoC Auto-Binding):**  
   يبحث الإطار عن كل مجلد موديول؛ إذا وجد `Contracts/{Name}RepositoryInterface` و `Repositories/{Name}Repository`، يقوم بربطهما تلقائياً:
   ```php
   $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
   ```
2. **تحميل الـ Views تلقائياً:**  
   تصبح فيوهات الموديول متاحة فوراً باستخدام الـ Namespace:
   ```php
   view('product::index')
   ```
3. **تحميل الـ Migrations تلقائياً:**  
   أي ملف migration داخل `app/Modules/{Name}/Database/Migrations` يكتشفه أمر `php artisan migrate` مباشرة.
4. **تحميل مسارات الـ API تلقائياً:**  
   أي ملف `api.php` داخل `Routes/` يُحمّل تلقائياً تحت بادئة `/api` مع ميدلوير `['api']`.

---

## 🧩 مكتبة مكونات Blade الجاهزة (`<x-sw-*>`)

توفر الحزمة **21 مكون Blade متطور** بتصميم احترافي موحد يدعم الوضع الليلي والنهاري:

### 1. المكونات الهيكلية للوحة التحكم (Layout)

| المكون             | التاج (Tag)                           | الاستخدام والوصف                                                                  |
| :----------------- | :------------------------------------ | :-------------------------------------------------------------------------------- |
| **الشريط الجانبي** | `<x-sw-sidebar />`                    | شريط تنقل جانبي تفاعلي، يدعم الفتح والطي، واكتشاف المسار النشط والشارات.          |
| **الهيدر العلوي**  | `<x-sw-header />`                     | شريط علوي يحوي شريط البحث، مبدل الوضع الليلي/النهاري، الإشعارات، وقائمة المستخدم. |
| **الفوتر**         | `<x-sw-footer />`                     | شريط تذييل بسيط ونظيف للداشبورد.                                                  |
| **شريط التنقل**    | `<x-sw-breadcrumb :items="$items" />` | يعرض مسار الصفحة الحالية (`[['label' => 'الرئيسية', 'url' => '/admin']]`).        |

---

### 2. بطاقات الإحصائيات وعرض البيانات (Data & Display)

| المكون              | مثال الاستخدام                                                                                             | الوصف                                                         |
| :------------------ | :--------------------------------------------------------------------------------------------------------- | :------------------------------------------------------------ |
| **بطاقة Stat Card** | `<x-sw-stat-card title="إجمالي المبيعات" value="12,500 ر.س" change="+14%" icon="chart" color="primary" />` | بطاقة مؤشرات أداء رئيسية (KPI) مزودة بنسبة التغير والأيقونات. |
| **البطاقة العامة**  | `<x-sw-card title="عنوان البطاقة" subtitle="وصف فرعي">المحتوى</x-sw-card>`                                 | بطاقة بتصميم Soft Shadow مع دعم أزرار الـ Actions.            |
| **جدول البيانات**   | `<x-sw-data-table>...</x-sw-data-table>`                                                                   | جدول بيانات متناسق مع دعم التمرير الأفقي والـ Hover.          |
| **الشارات (Badge)** | `<x-sw-badge type="success" :dot="true">مكتمل</x-sw-badge>`                                                | شارة حالة ملونة (`success`, `danger`, `warning`, `info`).     |
| **الصورة الرمزية**  | `<x-sw-avatar src="/path.jpg" name="أحمد علي" size="md" />`                                                | صورة بروفايل أو أحرف الاسم الأولى تلقائياً.                   |
| **الحالة الفارغة**  | `<x-sw-empty-state title="لا توجد بيانات" description="ابدأ بإضافة أول عنصر الآن" icon="inbox" />`         | واجهة توضيحية احترافية عند خلو الجداول.                       |

---

### 3. عناصر النماذج والإدخال (Form Inputs)

| المكون               | مثال الاستخدام                                                                         | الخصائص البارزة                                              |
| :------------------- | :------------------------------------------------------------------------------------- | :----------------------------------------------------------- |
| **حقل الإدخال**      | `<x-sw-input name="title" label="عنوان المنتج" placeholder="أدخل العنوان" required />` | إظهار أخطاء التحقق `$errors` تلقائياً، دعم الأيقونات.        |
| **القائمة المنسدلة** | `<x-sw-select name="category_id" label="القسم" :options="$categories" required />`     | دعم تحديد الخيار المختار والـ Placeholder.                   |
| **حقل النص الطويل**  | `<x-sw-textarea name="description" label="الوصف" rows="4" />`                          | منطقة كتابة مرنة ومتوافقة مع الـ Dark Mode.                  |
| **مربع الاختيار**    | `<x-sw-checkbox name="is_active" label="تفعيل الحساب" :checked="true" />`              | زر اختيار حديث ومرن.                                         |
| **رفع الملفات**      | `<x-sw-file-upload name="image" label="صورة الغلاف" accept="image/*" preview />`       | منطقة سحب وإفلات (Drag & Drop) مع معاينة فورية للصورة.       |
| **منتقي التاريخ**    | `<x-sw-date-picker name="published_at" label="تاريخ النشر" />`                         | إدخال تاريخ متوافق مع كافة المتصفحات.                        |
| **الأزرار**          | `<x-sw-button variant="primary" size="md">حفظ التغييرات</x-sw-button>`                 | أنواع: `primary`, `secondary`, `danger`, `ghost`, `outline`. |

---

### 4. التنبيهات والنوافذ التفاعلية (Feedback & Overlays)

| المكون               | مثال الاستخدام                                                                   | الوظيفة                                                     |
| :------------------- | :------------------------------------------------------------------------------- | :---------------------------------------------------------- |
| **التنبيهات**        | `<x-sw-alert type="success" message="تم حفظ البيانات بنجاح" dismissible />`      | رسائل تنبيهية ملونة قابلة للإغلاق.                          |
| **النافذة المنبثقة** | `<x-sw-modal id="createModal" title="إضافة صنف جديد" size="lg">...</x-sw-modal>` | نافذة Modal مدعومة بـ Alpine.js تدعم الفتح والإغلاق بسلاسة. |
| **رسائل Toast**      | `<x-sw-toast />`                                                                 | إشعارات عائمة تختفي تلقائياً.                               |
| **مؤشر التحميل**     | `<x-sw-loading size="md" />`                                                     | سبينر تحميل خفيف ودائري.                                    |

---

## 🧰 الـ Traits والكلاسات المساعدة (Built-in Traits & Helpers)

يوفر إطار العمل حزمة أدوات جاهزة لتجنب تكرار الكود:

### 1. `ApiResponseTrait` — توحيد مخرجات الـ API

```php
use Stackway\Core\Traits\ApiResponseTrait;

class ProductApiController extends BaseController
{
    use ApiResponseTrait;

    public function index()
    {
        return $this->successResponse($data, 'تم جلب المنتجات بنجاح');
    }

    public function error()
    {
        return $this->errorResponse('حدث خطأ أثناء المعالجة', 422);
    }
}
```

### 2. `DashboardResponseTrait` — رسائل التوجيه السريعة للويب

```php
use Stackway\Core\Traits\DashboardResponseTrait;

return $this->redirectWithSuccess('products.index', 'تم إنشاء المنتج بنجاح');
```

### 3. `SlugTrait` — توليد الـ Slug الفريد تلقائياً في الموديل

```php
use Stackway\Core\Traits\SlugTrait;

class Product extends Model
{
    use SlugTrait;

    protected string $slugSourceColumn = 'name'; // يولد slug تلقائياً من حقل name
}
```

### 4. `ImageUploadTrait` — رفع الصور وضغطها

```php
use Stackway\Core\Traits\ImageUploadTrait;

$path = $this->uploadImage($request->file('avatar'), 'avatars', 400, 400);
```

### 5. `CacheManager` — إدارة الكاش بنظام البادئات

```php
use Stackway\Core\Support\CacheManager;

// تذكر مع مدة زمنية
$products = CacheManager::remember('products.all', 3600, fn() => Product::all());

// حذف كاش بناءً على البادئة (Prefix Invalidation)
CacheManager::forgetByPrefix('products.');
```

---

## ⚙️ التخصيص وإعدادات الثيم (`config/stackway.php`)

بعد تشغيل `stackway:install`، ستجد ملف الإعدادات في `config/stackway.php`. يمكنك من خلاله تخصيص:

```php
return [
    // 1. مظهر وألوان لوحة التحكم
    'theme' => [
        'mode' => env('STACKWAY_THEME_MODE', 'light'), // 'light', 'dark', 'system'
        'colors' => [
            'primary'   => '#C85A32', // اللون الرئيسي
            'secondary' => '#5C554E',
            'accent'    => '#3A5A40',
            'success'   => '#3A5A40',
            'danger'    => '#C0392B',
            'warning'   => '#D48B28',
            'info'      => '#4A7C59',
        ],
        'sidebar' => [
            'style'    => 'collapsible', // 'fixed' أو 'collapsible'
            'position' => 'left',
            'width'    => '240px',
        ],
    ],

    // 2. مسار بادئة الداشبورد
    'dashboard' => [
        'prefix'     => 'admin', // الرابط: /admin
        'middleware' => ['web', 'auth'],
    ],

    // 3. مسار ومساحة أسماء الموديولات
    'module' => [
        'base_path' => 'app/Modules',
        'namespace' => 'App\\Modules',
    ],
];
```

---

## 🚀 سيناريو عملي متكامل (Quick Start Workflow)

لإنشاء قسم جديد كامل (مثلاً: إدارة المقالات `Article`):

1. **أنشئ الموديول بكل طبقاته:**
   ```bash
   php artisan stackway:module Article --all
   ```
2. **شغّل المايجريشن لإنشاء جدول `articles`:**
   ```bash
   php artisan migrate
   ```
3. **أضف راوت الويب داخل `routes/web.php`:**

   ```php
   use App\Modules\Article\Controllers\ArticleController;

   Route::middleware(['web', 'auth'])->prefix('admin/article')->name('article.')->group(function () {
       Route::resource('/', ArticleController::class);
   });
   ```

4. **مبروك!**
   - واجهة الويب جاهزة في: `/admin/article`
   - واجهات الـ API جاهزة وتعمل تلقائياً تحت: `/api/article`

---

## 👨‍💻 المطور والدعم (Author & License)

- **المطور:** ضياء أشرف (Diaa Ashraf)
- **المستودع الرسمي:** [Stackway-Laravel-Framework on GitHub](https://github.com/Diaa-Ashraf/Stackway-Laravel-Framework)
- **الترخيص:** مرخص بموجب رخصة [MIT License](LICENSE).
