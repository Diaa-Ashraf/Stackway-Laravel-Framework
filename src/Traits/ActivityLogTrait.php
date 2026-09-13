<?php

namespace Stackway\Core\Traits;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

trait ActivityLogTrait
{
    use LogsActivity;

    /**
     * Get the activity log options.
     * Override in your model for custom behavior.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => match ($eventName) {
                'created' => 'تم إنشاء ' . class_basename(static::class),
                'updated' => 'تم تحديث ' . class_basename(static::class),
                'deleted' => 'تم حذف ' . class_basename(static::class),
                default   => "تم {$eventName} " . class_basename(static::class),
            })
            ->useLogName(config('stackway.audit.log_name', 'stackway'));
    }
}
