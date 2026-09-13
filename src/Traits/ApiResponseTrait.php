<?php

namespace Stackway\Core\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Return a success response.
     */
    protected function success(mixed $data = null, string $message = 'تمت العملية بنجاح', int $code = 200): JsonResponse
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    /**
     * Return a created response (201).
     */
    protected function created(mixed $data = null, string $message = 'تم الإنشاء بنجاح'): JsonResponse
    {
        return $this->success($data, $message, 201);
    }

    /**
     * Return an error response.
     */
    protected function error(string $message = 'حدث خطأ', int $code = 400, mixed $data = null): JsonResponse
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    /**
     * Return a not found response (404).
     */
    protected function notFound(string $message = 'غير موجود'): JsonResponse
    {
        return $this->error($message, 404);
    }

    /**
     * Return an unauthorized response (401).
     */
    protected function unauthorized(string $message = 'غير مصرح بالوصول'): JsonResponse
    {
        return $this->error($message, 401);
    }

    /**
     * Return a forbidden response (403).
     */
    protected function forbidden(string $message = 'ليس لديك صلاحية'): JsonResponse
    {
        return $this->error($message, 403);
    }

    /**
     * Return a validation error response (422).
     */
    protected function validationError(mixed $errors, string $message = 'بيانات غير صالحة'): JsonResponse
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
            'errors'  => $errors,
        ], 422);
    }

    /**
     * Return a paginated response.
     */
    protected function paginated(mixed $data, string $message = ''): JsonResponse
    {
        $response = [
            'status'  => true,
            'message' => $message,
            'data'    => $data->items(),
            'meta'    => [
                'current_page' => $data->currentPage(),
                'last_page'    => $data->lastPage(),
                'per_page'     => $data->perPage(),
                'total'        => $data->total(),
                'from'         => $data->firstItem(),
                'to'           => $data->lastItem(),
            ],
        ];

        if ($data->hasPages()) {
            $response['links'] = [
                'first' => $data->url(1),
                'last'  => $data->url($data->lastPage()),
                'prev'  => $data->previousPageUrl(),
                'next'  => $data->nextPageUrl(),
            ];
        }

        return response()->json($response);
    }

    /**
     * Return a server error response (500).
     */
    protected function serverError(string $message = 'حدث خطأ في الخادم'): JsonResponse
    {
        return $this->error($message, 500);
    }
}
