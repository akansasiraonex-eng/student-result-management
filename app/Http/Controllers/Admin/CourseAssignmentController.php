<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseAssignment;
use App\Models\Lecturer;
use App\Models\Semester;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseAssignmentController extends Controller
{
    public function index(): View
    {
        $assignments = CourseAssignment::with([
            'course',
            'lecturer',
            'semester.academicYear',
        ])
            ->orderByDesc('semester_id')
            ->paginate(10);

        return view('admin.course-assignments.index', compact('assignments'));
    }

    public function create(): View
    {
        $courses = Course::where('is_active', true)
            ->orderBy('code')
            ->get();

        $lecturers = Lecturer::where('status', 'active')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $semesters = Semester::with('academicYear')
            ->where('is_active', true)
            ->orderByDesc('academic_year_id')
            ->orderBy('semester_number')
            ->get();

        return view(
            'admin.course-assignments.create',
            compact('courses', 'lecturers', 'semesters')
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => [
                'required',
                'exists:courses,id',
            ],
            'lecturer_id' => [
                'required',
                'exists:lecturers,id',
            ],
            'semester_id' => [
                'required',
                'exists:semesters,id',
            ],
            'is_primary' => [
                'nullable',
                'boolean',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $validated['is_primary'] = $request->boolean('is_primary');
        $validated['is_active'] = $request->boolean('is_active');

        $duplicate = CourseAssignment::where('course_id', $validated['course_id'])
            ->where('lecturer_id', $validated['lecturer_id'])
            ->where('semester_id', $validated['semester_id'])
            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->withErrors([
                    'lecturer_id' =>
                        'This lecturer is already assigned to this course for the selected semester.',
                ]);
        }

        if ($validated['is_primary']) {
            CourseAssignment::where('course_id', $validated['course_id'])
                ->where('semester_id', $validated['semester_id'])
                ->update(['is_primary' => false]);
        }

        CourseAssignment::create($validated);

        return redirect()
            ->route('admin.course-assignments.index')
            ->with('success', 'Course assignment created successfully.');
    }

    public function show(CourseAssignment $courseAssignment): View
    {
        $courseAssignment->load([
            'course.department',
            'lecturer.department',
            'semester.academicYear',
        ]);

        return view(
            'admin.course-assignments.show',
            compact('courseAssignment')
        );
    }

    public function edit(CourseAssignment $courseAssignment): View
    {
        $courses = Course::where('is_active', true)
            ->orderBy('code')
            ->get();

        $lecturers = Lecturer::where('status', 'active')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $semesters = Semester::with('academicYear')
            ->where('is_active', true)
            ->orderByDesc('academic_year_id')
            ->orderBy('semester_number')
            ->get();

        return view(
            'admin.course-assignments.edit',
            compact(
                'courseAssignment',
                'courses',
                'lecturers',
                'semesters'
            )
        );
    }

    public function update(
        Request $request,
        CourseAssignment $courseAssignment
    ): RedirectResponse {
        $validated = $request->validate([
            'course_id' => [
                'required',
                'exists:courses,id',
            ],
            'lecturer_id' => [
                'required',
                'exists:lecturers,id',
            ],
            'semester_id' => [
                'required',
                'exists:semesters,id',
            ],
            'is_primary' => [
                'nullable',
                'boolean',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $validated['is_primary'] = $request->boolean('is_primary');
        $validated['is_active'] = $request->boolean('is_active');

        $duplicate = CourseAssignment::where('course_id', $validated['course_id'])
            ->where('lecturer_id', $validated['lecturer_id'])
            ->where('semester_id', $validated['semester_id'])
            ->where('id', '!=', $courseAssignment->id)
            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->withErrors([
                    'lecturer_id' =>
                        'This lecturer is already assigned to this course for the selected semester.',
                ]);
        }

        if ($validated['is_primary']) {
            CourseAssignment::where('course_id', $validated['course_id'])
                ->where('semester_id', $validated['semester_id'])
                ->where('id', '!=', $courseAssignment->id)
                ->update(['is_primary' => false]);
        }

        $courseAssignment->update($validated);

        return redirect()
            ->route('admin.course-assignments.index')
            ->with('success', 'Course assignment updated successfully.');
    }

    public function destroy(
        CourseAssignment $courseAssignment
    ): RedirectResponse {
       if (
    \App\Models\CourseEnrollment::where('course_id', $courseAssignment->course_id)
        ->where('semester_id', $courseAssignment->semester_id)
        ->exists()
) {
            return redirect()
                ->route('admin.course-assignments.index')
                ->with(
                    'error',
                    'This assignment cannot be deleted because student enrollments depend on it.'
                );
        }

        $courseAssignment->delete();

        return redirect()
            ->route('admin.course-assignments.index')
            ->with('success', 'Course assignment deleted successfully.');
    }
}