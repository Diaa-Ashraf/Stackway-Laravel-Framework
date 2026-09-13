<?php

namespace Stackway\Core\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageManager
{
    /**
     * Upload an image with optional resizing.
     */
    public static function upload(UploadedFile $file, string $folder, ?string $oldPath = null): string
    {
        if ($oldPath) {
            StorageManager::delete($oldPath);
        }

        return StorageManager::upload($file, $folder);
    }

    /**
     * Get the URL for an image, with fallback.
     */
    public static function url(?string $path, string $fallback = ''): string
    {
        if (!$path) {
            return $fallback;
        }

        return StorageManager::url($path) ?? $fallback;
    }

    /**
     * Get validation rules for image upload.
     */
    public static function validationRules(bool $required = false, int $maxSizeKb = 0): array
    {
        $maxSize = $maxSizeKb ?: config('stackway.media.max_file_size', 10240);
        $allowedTypes = implode(',', config('stackway.media.allowed_types', ['jpg', 'jpeg', 'png', 'gif', 'webp']));

        $rules = ['image', "mimes:{$allowedTypes}", "max:{$maxSize}"];

        if ($required) {
            array_unshift($rules, 'required');
        } else {
            array_unshift($rules, 'nullable');
        }

        return $rules;
    }

    /**
     * Get user avatar URL or generate placeholder.
     */
    public static function avatar(?string $path, string $name = '', int $size = 40): string
    {
        if ($path) {
            return StorageManager::url($path) ?? '';
        }

        // Generate placeholder with initials
        $initials = collect(explode(' ', $name))
            ->take(2)
            ->map(fn($word) => mb_substr($word, 0, 1))
            ->implode('');

        return "https://ui-avatars.com/api/?name=" . urlencode($initials) . "&size={$size}&background=6D28D9&color=fff&bold=true";
    }
}
