<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'services_total' => Service::query()->count(),
            'services_active' => Service::query()->where('status', true)->count(),
            'portfolios_total' => Portfolio::query()->count(),
            'portfolios_published' => Portfolio::query()->where('is_published', true)->count(),
            'testimonials_total' => Testimonial::query()->count(),
            'testimonials_published' => Testimonial::query()->where('is_published', true)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
