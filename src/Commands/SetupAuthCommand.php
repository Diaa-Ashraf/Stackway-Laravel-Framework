<?php

namespace Stackway\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SetupAuthCommand extends Command
{
    protected $signature = 'stackway:api-auth {--force : Overwrite existing files}';

    protected $description = 'Setup API Authentication using Sanctum (AuthController, Requests, Routes)';

    public function handle(): int
    {
        $this->info('');
        $this->info('⚡ Setting up API Authentication (Sanctum)...');
        $this->info('');

        $modulePath = base_path(config('stackway.module.base_path', 'app/Modules') . '/Auth');
        $namespace = config('stackway.module.namespace', 'App\\Modules') . '\\Auth';

        // Create Auth API Controller
        $this->createFromStub(
            $modulePath . '/Controllers/Api/AuthController.php',
            $this->getAuthControllerStub($namespace)
        );
        $this->line('  <fg=green>✓</> Auth API Controller');

        // Create Login Request
        $this->createFromStub(
            $modulePath . '/Requests/LoginRequest.php',
            $this->getLoginRequestStub($namespace)
        );
        $this->line('  <fg=green>✓</> Login Request');

        // Create Register Request
        $this->createFromStub(
            $modulePath . '/Requests/RegisterRequest.php',
            $this->getRegisterRequestStub($namespace)
        );
        $this->line('  <fg=green>✓</> Register Request');

        // Create API Routes
        $this->createFromStub(
            $modulePath . '/Routes/api.php',
            $this->getApiRoutesStub($namespace)
        );
        $this->line('  <fg=green>✓</> API Auth Routes');

        $this->info('');
        $this->info('✅ API Authentication setup complete!');
        $this->info('');
        $this->info('API Endpoints:');
        $this->line('  POST   /api/auth/register');
        $this->line('  POST   /api/auth/login');
        $this->line('  POST   /api/auth/logout      (auth:sanctum)');
        $this->line('  GET    /api/auth/profile      (auth:sanctum)');
        $this->info('');

        return self::SUCCESS;
    }

    protected function createFromStub(string $path, string $content): void
    {
        if (File::exists($path) && !$this->option('force')) {
            $this->warn("  ⚠ Already exists: " . basename($path));
            return;
        }

        File::ensureDirectoryExists(dirname($path));
        File::put($path, $content);
    }

    protected function getAuthControllerStub(string $namespace): string
    {
        return <<<PHP
<?php

namespace {$namespace}\\Controllers\\Api;

use App\\Models\\User;
use Illuminate\\Http\\JsonResponse;
use Illuminate\\Http\\Request;
use Illuminate\\Support\\Facades\\Auth;
use Illuminate\\Support\\Facades\\Hash;
use Stackway\\Core\\Base\\BaseController;
use Stackway\\Core\\Traits\\ApiResponseTrait;
use {$namespace}\\Requests\\LoginRequest;
use {$namespace}\\Requests\\RegisterRequest;

class AuthController extends BaseController
{
    use ApiResponseTrait;

    /**
     * Register a new user.
     */
    public function register(RegisterRequest \$request): JsonResponse
    {
        \$user = User::create([
            'name'     => \$request->validated('name'),
            'email'    => \$request->validated('email'),
            'password' => Hash::make(\$request->validated('password')),
        ]);

        \$token = \$user->createToken('auth_token')->plainTextToken;

        return \$this->success([
            'user'  => \$user,
            'token' => \$token,
        ], 'تم التسجيل بنجاح', 201);
    }

    /**
     * Login and issue token.
     */
    public function login(LoginRequest \$request): JsonResponse
    {
        if (!Auth::attempt(\$request->only('email', 'password'))) {
            return \$this->error('بيانات الدخول غير صحيحة', 401);
        }

        \$user = Auth::user();
        \$token = \$user->createToken('auth_token')->plainTextToken;

        return \$this->success([
            'user'  => \$user,
            'token' => \$token,
        ], 'تم تسجيل الدخول بنجاح');
    }

    /**
     * Logout (revoke current token).
     */
    public function logout(Request \$request): JsonResponse
    {
        \$request->user()->currentAccessToken()->delete();

        return \$this->success(null, 'تم تسجيل الخروج بنجاح');
    }

    /**
     * Get authenticated user profile.
     */
    public function profile(Request \$request): JsonResponse
    {
        return \$this->success(\$request->user());
    }
}
PHP;
    }

    protected function getLoginRequestStub(string $namespace): string
    {
        return <<<PHP
<?php

namespace {$namespace}\\Requests;

use Stackway\\Core\\Base\\BaseRequest;

class LoginRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'البريد الإلكتروني مطلوب',
            'email.email'       => 'البريد الإلكتروني غير صالح',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min'      => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
        ];
    }
}
PHP;
    }

    protected function getRegisterRequestStub(string $namespace): string
    {
        return <<<PHP
<?php

namespace {$namespace}\\Requests;

use Stackway\\Core\\Base\\BaseRequest;

class RegisterRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'الاسم مطلوب',
            'email.required'     => 'البريد الإلكتروني مطلوب',
            'email.email'        => 'البريد الإلكتروني غير صالح',
            'email.unique'       => 'البريد الإلكتروني مستخدم بالفعل',
            'password.required'  => 'كلمة المرور مطلوبة',
            'password.min'       => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق',
        ];
    }
}
PHP;
    }

    protected function getApiRoutesStub(string $namespace): string
    {
        return <<<PHP
<?php

use Illuminate\\Support\\Facades\\Route;
use {$namespace}\\Controllers\\Api\\AuthController;

/*
|--------------------------------------------------------------------------
| Auth API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by StackwayServiceProvider automatically.
| Prefix: /api | Middleware: api
|
*/

Route::prefix('auth')->group(function () {
    // Public routes
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'profile']);
    });
});
PHP;
    }
}
