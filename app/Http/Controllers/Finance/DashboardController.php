<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the finance dashboard.
     */
    public function index(): View
    {
        $statistics = [
            'students' => \App\Models\Student::count(),
            'active_students' => \App\Models\Student::where('status', 'active')->count(),
            'programs' => \App\Models\Program::count(),
            'academic_years' => \App\Models\AcademicYear::count(),
        ];

        return view('finance.dashboard', compact('statistics'));
    }
}