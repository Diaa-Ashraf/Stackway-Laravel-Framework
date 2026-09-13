<?php

namespace Stackway\Core\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StorageManager
{
    /**
     * Upload a file to the specified folder.
     */
    public static function upload(UploadedFile $file, string $folder, ?string $disk = null): string
    {
        $disk = $disk ?? config('stackway.media.disk', 'public');
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

        return $file->storeAs($folder, $fileName, $disk);
    }

    /**
     * Upload and replace old file.
     */
    public static function uploadAndReplace(UploadedFile $file, string $folder, ?string $oldPath = null, ?string $disk = null): string
    {
        $disk = $disk ?? config('stackway.media.disk', 'public');

        if ($oldPath) {
            static::delete($oldPath, $disk);
        }

        return static::upload($file, $folder, $disk);
    }

    /**
     * Delete a file from storage.
     */
    public static function delete(?string $path, ?string $disk = null): bool
    {
        $disk = $disk ?? config('stackway.media.disk', 'public');

        if ($path && Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    /**
     * Get the public URL for a file.
     */
    public static function url(?string $path, ?string $disk = null): ?string
    {
        if (!$path) {
            return null;
        }

        $disk = $disk ?? config('stackway.media.disk', 'public');
        return Storage::disk($disk)->url($path);
    }

    /**
     * Check if a file exists.
     */
    public static function exists(string $path, ?string $disk = null): bool
    {
        $disk = $disk ?? config('stackway.media.disk', 'public');
        return Storage::disk($disk)->exists($path);
    }

    /**
     * Get file size in bytes.
     */
    public static function size(string $path, ?string $disk = null): int
    {
        $disk = $disk ?? config('stackway.media.disk', 'public');
        return Storage::disk($disk)->size($path);
    }

    /**
     * Upload multiple files.
     *
     * @param array<UploadedFile> $files
     * @return array<string>
     */
    public static function uploadMultiple(array $files, string $folder, ?string $disk = null): array
    {
        return array_map(fn(UploadedFile $file) => static::upload($file, $folder, $disk), $files);
    }

    /**
     * Delete multiple files.
     *
     * @param array<string> $paths
     */
    public static function deleteMultiple(array $paths, ?string $disk = null): void
    {
        foreach ($paths as $path) {
            static::delete($path, $disk);
        }
    }
}
