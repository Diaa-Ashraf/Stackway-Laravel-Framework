<?php

namespace Stackway\Core\Traits;

use Illuminate\Support\Str;

trait SlugTrait
{
    /**
     * Boot the trait: auto-generate slug on creating.
     */
    protected static function bootSlugTrait(): void
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getSlugColumn()})) {
                $model->{$model->getSlugColumn()} = $model->generateUniqueSlug(
                    $model->{$model->getSlugSourceColumn()}
                );
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty($model->getSlugSourceColumn())) {
                $model->{$model->getSlugColumn()} = $model->generateUniqueSlug(
                    $model->{$model->getSlugSourceColumn()}
                );
            }
        });
    }

    /**
     * Generate a unique slug.
     */
    protected function generateUniqueSlug(string $value): string
    {
        $slug = Str::slug($value, '-', app()->getLocale());

        // Fallback for Arabic text
        if (empty($slug)) {
            $slug = preg_replace('/\s+/', '-', trim($value));
            $slug = preg_replace('/[^\p{Arabic}\p{L}\p{N}\-]/u', '', $slug);
            $slug = strtolower($slug);
        }

        $originalSlug = $slug;
        $count = 1;

        while (static::where($this->getSlugColumn(), $slug)
            ->where('id', '!=', $this->id ?? 0)
            ->exists()
        ) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    /**
     * Get the column name for the slug.
     */
    protected function getSlugColumn(): string
    {
        return property_exists($this, 'slugColumn') ? $this->slugColumn : 'slug';
    }

    /**
     * Get the source column for slug generation.
     */
    protected function getSlugSourceColumn(): string
    {
        return property_exists($this, 'slugSourceColumn') ? $this->slugSourceColumn : 'name';
    }
}
