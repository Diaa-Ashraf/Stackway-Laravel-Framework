<?php

namespace Stackway\Core\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ImageUploadTrait
{
    /**
     * Upload an image to the specified folder.
     * Deletes the old image if provided.
     *
     * @param UploadedFile $file The uploaded file
     * @param string $folder The storage folder (e.g., 'products', 'users')
     * @param string|null $oldPath Previous file path to delete
     * @param string $disk Storage disk name
     * @return string The stored file path
     */
    protected function uploadImage(UploadedFile $file, string $folder, ?string $oldPath = null, string $disk = 'public'): string
    {
        // Delete old image if exists
        if ($oldPath) {
            $this->deleteImage($oldPath, $disk);
        }

        // Generate unique filename
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

        // Store the file
        return $file->storeAs($folder, $fileName, $disk);
    }

    /**
     * Upload multiple images.
     *
     * @param array<UploadedFile> $files
     * @param string $folder
     * @param string $disk
     * @return array<string> Array of stored file paths
     */
    protected function uploadMultiple(array $files, string $folder, string $disk = 'public'): array
    {
        $paths = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $paths[] = $this->uploadImage($file, $folder, null, $disk);
            }
        }

        return $paths;
    }

    /**
     * Delete an image from storage.
     */
    protected function deleteImage(?string $path, string $disk = 'public'): bool
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    /**
     * Get the full URL for a stored image.
     */
    protected function getImageUrl(?string $path, string $disk = 'public'): ?string
    {
        if (!$path) {
            return null;
        }

        return Storage::disk($disk)->url($path);
    }

    /**
     * Delete multiple images.
     *
     * @param array<string> $paths
     */
    protected function deleteMultipleImages(array $paths, string $disk = 'public'): void
    {
        foreach ($paths as $path) {
            $this->deleteImage($path, $disk);
        }
    }
}
