<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the administrator dashboard.
     */
    public function index(): View
{
    $statistics = [
        'students' => \App\Models\Student::count(),
        'lecturers' => \App\Models\Lecturer::count(),
        'courses' => \App\Models\Course::count(),
        'departments' => \App\Models\Department::count(),
        'programs' => \App\Models\Program::count(),
        'academic_years' => \App\Models\AcademicYear::count(),
        'semesters' => \App\Models\Semester::count(),
        'results' => \App\Models\Result::count(),
    ];

    return view('admin.dashboard', compact('statistics'));
}
}