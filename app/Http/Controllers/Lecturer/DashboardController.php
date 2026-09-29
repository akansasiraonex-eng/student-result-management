<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the lecturer dashboard.
     */
    public function index(): View|RedirectResponse
    {
        $user = Auth::user();

        if (! $user->lecturer) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Your lecturer profile has not been configured.');
        }

        $lecturer = $user->lecturer;

        $assignedCourses = $lecturer->courseAssignments()
            ->where('is_active', true)
            ->count();

        $enrolledStudents = \App\Models\CourseEnrollment::whereHas(
            'course',
            function ($query) use ($lecturer) {
                $query->whereHas(
                    'courseAssignments',
                    function ($assignmentQuery) use ($lecturer) {
                        $assignmentQuery
                            ->where('lecturer_id', $lecturer->id)
                            ->where('is_active', true);
                    }
                );
            }
        )->distinct('student_id')->count('student_id');

        $draftResults = \App\Models\Result::where('entered_by', $user->id)
            ->where('status', 'draft')
            ->count();

        $submittedResults = \App\Models\Result::where('entered_by', $user->id)
            ->where('status', 'submitted')
            ->count();

        $statistics = [
            'assigned_courses' => $assignedCourses,
            'enrolled_students' => $enrolledStudents,
            'draft_results' => $draftResults,
            'submitted_results' => $submittedResults,
        ];

        return view('lecturer.dashboard', compact('lecturer', 'statistics'));
    }
}