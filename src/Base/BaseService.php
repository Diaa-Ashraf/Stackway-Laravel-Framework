<?php

namespace Stackway\Core\Base;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class BaseService
{
    /**
     * Execute a callback within a database transaction.
     *
     * @template T
     * @param callable(): T $callback
     * @return T
     * @throws \Throwable
     */
    protected function transaction(callable $callback): mixed
    {
        return DB::transaction($callback);
    }

    /**
     * Log an info message with module context.
     */
    protected function logInfo(string $message, array $context = []): void
    {
        Log::info("[" . class_basename(static::class) . "] {$message}", $context);
    }

    /**
     * Log an error message with module context.
     */
    protected function logError(string $message, array $context = []): void
    {
        Log::error("[" . class_basename(static::class) . "] {$message}", $context);
    }
}
