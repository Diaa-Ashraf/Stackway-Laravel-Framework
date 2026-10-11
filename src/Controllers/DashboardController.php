<?php

namespace Stackway\Core\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Stackway\Core\Base\BaseController;
use Stackway\Core\Services\DashboardService;

class DashboardController extends BaseController
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    /**
     * Display the built-in dynamic Stackway Dashboard.
     */
    public function index(Request $request): View
    {
        $data = $this->dashboardService->getDashboardData();

        return view('stackway::dashboard', $data);
    }
}
