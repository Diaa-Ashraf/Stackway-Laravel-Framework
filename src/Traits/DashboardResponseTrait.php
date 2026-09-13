<?php

namespace Stackway\Core\Traits;

use Illuminate\Http\RedirectResponse;

trait DashboardResponseTrait
{
    /**
     * Flash a success message and redirect.
     */
    protected function flashSuccess(string $message = 'تمت العملية بنجاح'): RedirectResponse
    {
        return redirect()->back()->with('success', $message);
    }

    /**
     * Flash an error message and redirect.
     */
    protected function flashError(string $message = 'حدث خطأ'): RedirectResponse
    {
        return redirect()->back()->with('error', $message);
    }

    /**
     * Flash a warning message and redirect.
     */
    protected function flashWarning(string $message): RedirectResponse
    {
        return redirect()->back()->with('warning', $message);
    }

    /**
     * Flash success and redirect to module index.
     */
    protected function redirectToIndex(string $routeName, string $message = 'تمت العملية بنجاح'): RedirectResponse
    {
        return redirect()->route($routeName)->with('success', $message);
    }

    /**
     * Flash success with creation message.
     */
    protected function flashCreated(string $route = '', string $label = 'العنصر'): RedirectResponse
    {
        $message = "تم إنشاء {$label} بنجاح";
        if (!empty($route) && \Illuminate\Support\Facades\Route::has($route)) {
            return redirect()->route($route)->with('success', $message);
        }
        return $this->flashSuccess($message);
    }

    /**
     * Flash success with update message.
     */
    protected function flashUpdated(string $route = '', string $label = 'العنصر'): RedirectResponse
    {
        $message = "تم تحديث {$label} بنجاح";
        if (!empty($route) && \Illuminate\Support\Facades\Route::has($route)) {
            return redirect()->route($route)->with('success', $message);
        }
        return $this->flashSuccess($message);
    }

    /**
     * Flash success with deletion message.
     */
    protected function flashDeleted(string $route = '', string $label = 'العنصر'): RedirectResponse
    {
        $message = "تم حذف {$label} بنجاح";
        if (!empty($route) && \Illuminate\Support\Facades\Route::has($route)) {
            return redirect()->route($route)->with('success', $message);
        }
        return $this->flashSuccess($message);
    }
}
