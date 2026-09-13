<?php

namespace Stackway\Core\Support\SocialAuth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class SocialAuthManager
{
    /**
     * Redirect to OAuth provider.
     */
    public static function redirect(string $provider): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        static::validateProvider($provider);

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle the callback from OAuth provider.
     * Returns the authenticated user.
     */
    public static function handleCallback(string $provider): User
    {
        static::validateProvider($provider);

        $socialUser = Socialite::driver($provider)->user();

        return static::findOrCreateUser($socialUser, $provider);
    }

    /**
     * Find existing user or create a new one from social login.
     */
    protected static function findOrCreateUser(SocialiteUser $socialUser, string $provider): User
    {
        // Try to find user by email first
        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            // Update social provider info
            $user->update([
                "{$provider}_id" => $socialUser->getId(),
                'avatar'         => $socialUser->getAvatar() ?? $user->avatar,
            ]);
        } elseif (config('stackway.social_auth.auto_register', true)) {
            // Create new user
            $user = User::create([
                'name'           => $socialUser->getName(),
                'email'          => $socialUser->getEmail(),
                'password'       => Hash::make(Str::random(24)),
                "{$provider}_id" => $socialUser->getId(),
                'avatar'         => $socialUser->getAvatar(),
                'email_verified_at' => now(),
            ]);
        }

        // Login the user
        Auth::login($user, true);

        return $user;
    }

    /**
     * Validate that the provider is enabled.
     *
     * @throws \InvalidArgumentException
     */
    protected static function validateProvider(string $provider): void
    {
        $enabled = config('stackway.social_auth.enabled_providers', []);

        if (!in_array($provider, $enabled)) {
            throw new \InvalidArgumentException("Social provider [{$provider}] is not enabled.");
        }
    }

    /**
     * Get all enabled providers.
     *
     * @return array<string>
     */
    public static function enabledProviders(): array
    {
        return config('stackway.social_auth.enabled_providers', []);
    }

    /**
     * Get the redirect URL after social auth.
     */
    public static function redirectUrl(): string
    {
        return config('stackway.social_auth.redirect_after', '/dashboard');
    }
}
