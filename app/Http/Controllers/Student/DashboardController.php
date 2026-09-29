<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the student dashboard.
     */
    public function index(): View|RedirectResponse
    {
        $user = Auth::user();

        if (! $user->student) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Your student profile has not been configured.');
        }

        $student = $user->student;

        $totalCourses = $student->courseEnrollments()->count();

        $completedCourses = $student->courseEnrollments()
            ->where('status', 'completed')
            ->count();

        $publishedResults = \App\Models\Result::whereHas(
            'courseEnrollment',
            function ($query) use ($student) {
                $query->where('student_id', $student->id);
            }
        )
            ->where('status', 'published')
            ->count();

        $statistics = [
            'total_courses' => $totalCourses,
            'completed_courses' => $completedCourses,
            'published_results' => $publishedResults,
        ];

        return view('student.dashboard', compact('student', 'statistics'));
    }
}