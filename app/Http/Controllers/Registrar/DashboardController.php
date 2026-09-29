<?php

namespace App\Http\Controllers\Registrar;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the registrar dashboard.
     */
    public function index(): View
    {
        $statistics = [
            'students' => \App\Models\Student::count(),
            'programs' => \App\Models\Program::count(),
            'courses' => \App\Models\Course::count(),
            'departments' => \App\Models\Department::count(),
            'pending_results' => \App\Models\Result::where('status', 'submitted')->count(),
            'approved_results' => \App\Models\Result::where('status', 'approved')->count(),
            'published_results' => \App\Models\Result::where('status', 'published')->count(),
            'academic_years' => \App\Models\AcademicYear::count(),
        ];

        return view('registrar.dashboard', compact('statistics'));
    }
}