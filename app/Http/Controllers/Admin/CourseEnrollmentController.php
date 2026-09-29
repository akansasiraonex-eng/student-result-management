<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseAssignment;
use App\Models\CourseEnrollment;
use App\Models\Result;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseEnrollmentController extends Controller
{
    /**
     * Display all course enrollments.
     */
    public function index(): View
    {
        $enrollments = CourseEnrollment::with([
            'student.program',
            'course.department',
            'semester.academicYear',
        ])
            ->orderByDesc('enrolled_at')
            ->orderByDesc('id')
            ->paginate(10);

        return view(
            'admin.course-enrollments.index',
            compact('enrollments')
        );
    }

    /**
     * Show the form for creating a new enrollment.
     */
    public function create(): View
    {
        $students = Student::where('status', 'active')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $courses = Course::where('is_active', true)
            ->orderBy('code')
            ->get();

        $semesters = Semester::with('academicYear')
            ->where('is_active', true)
            ->orderByDesc('academic_year_id')
            ->orderBy('semester_number')
            ->get();

        return view(
            'admin.course-enrollments.create',
            compact('students', 'courses', 'semesters')
        );
    }

    /**
     * Store a newly created enrollment.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'semester_id' => ['required', 'exists:semesters,id'],
            'status' => [
                'required',
                'in:enrolled,completed,dropped,withdrawn,deferred',
            ],
            'enrolled_at' => ['nullable', 'date'],
        ]);

        $student = Student::findOrFail($validated['student_id']);
        $course = Course::findOrFail($validated['course_id']);
        $semester = Semester::findOrFail($validated['semester_id']);

        if ($student->status !== 'active') {
            return back()
                ->withInput()
                ->withErrors([
                    'student_id' =>
                        'Only active students can be enrolled in courses.',
                ]);
        }

        if (! $course->is_active) {
            return back()
                ->withInput()
                ->withErrors([
                    'course_id' =>
                        'The selected course is not active.',
                ]);
        }

        if (! $semester->is_active) {
            return back()
                ->withInput()
                ->withErrors([
                    'semester_id' =>
                        'The selected semester is not active.',
                ]);
        }

        $assignmentExists = CourseAssignment::where(
            'course_id',
            $course->id
        )
            ->where('semester_id', $semester->id)
            ->where('is_active', true)
            ->exists();

        if (! $assignmentExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'course_id' =>
                        'This course has not been assigned to an active lecturer for the selected semester.',
                ]);
        }

        $duplicate = CourseEnrollment::where(
            'student_id',
            $student->id
        )
            ->where('course_id', $course->id)
            ->where('semester_id', $semester->id)
            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->withErrors([
                    'student_id' =>
                        'This student is already enrolled in this course for the selected semester.',
                ]);
        }

        $validated['enrolled_at'] =
            $validated['enrolled_at'] ?? now();

        CourseEnrollment::create($validated);

        return redirect()
            ->route('admin.course-enrollments.index')
            ->with(
                'success',
                'Student enrolled in the course successfully.'
            );
    }

    /**
     * Display the specified enrollment.
     */
    public function show(CourseEnrollment $courseEnrollment): View
    {
        $courseEnrollment->load([
            'student.program.department',
            'student.admissionAcademicYear',
            'course.department',
            'semester.academicYear',
        ]);

        return view(
            'admin.course-enrollments.show',
            compact('courseEnrollment')
        );
    }

    /**
     * Show the form for editing the specified enrollment.
     */
    public function edit(CourseEnrollment $courseEnrollment): View
    {
        $students = Student::where('status', 'active')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        if (
            $courseEnrollment->student &&
            ! $students->contains('id', $courseEnrollment->student_id)
        ) {
            $students->push($courseEnrollment->student);
        }

        $courses = Course::where('is_active', true)
            ->orderBy('code')
            ->get();

        if (
            $courseEnrollment->course &&
            ! $courses->contains('id', $courseEnrollment->course_id)
        ) {
            $courses->push($courseEnrollment->course);
        }

        $semesters = Semester::with('academicYear')
            ->where('is_active', true)
            ->orderByDesc('academic_year_id')
            ->orderBy('semester_number')
            ->get();

        if (
            $courseEnrollment->semester &&
            ! $semesters->contains('id', $courseEnrollment->semester_id)
        ) {
            $semesters->push($courseEnrollment->semester);
        }

        return view(
            'admin.course-enrollments.edit',
            compact(
                'courseEnrollment',
                'students',
                'courses',
                'semesters'
            )
        );
    }

    /**
     * Update the specified enrollment.
     */
    public function update(
        Request $request,
        CourseEnrollment $courseEnrollment
    ): RedirectResponse {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'semester_id' => ['required', 'exists:semesters,id'],
            'status' => [
                'required',
                'in:enrolled,completed,dropped,withdrawn,deferred',
            ],
            'enrolled_at' => ['nullable', 'date'],
        ]);

        $student = Student::findOrFail($validated['student_id']);
        $course = Course::findOrFail($validated['course_id']);
        $semester = Semester::findOrFail($validated['semester_id']);

        if ($student->status !== 'active') {
            return back()
                ->withInput()
                ->withErrors([
                    'student_id' =>
                        'Only active students can be enrolled in courses.',
                ]);
        }

        if (! $course->is_active) {
            return back()
                ->withInput()
                ->withErrors([
                    'course_id' =>
                        'The selected course is not active.',
                ]);
        }

        if (! $semester->is_active) {
            return back()
                ->withInput()
                ->withErrors([
                    'semester_id' =>
                        'The selected semester is not active.',
                ]);
        }

        $assignmentExists = CourseAssignment::where(
            'course_id',
            $course->id
        )
            ->where('semester_id', $semester->id)
            ->where('is_active', true)
            ->exists();

        if (! $assignmentExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'course_id' =>
                        'This course has not been assigned to an active lecturer for the selected semester.',
                ]);
        }

        $duplicate = CourseEnrollment::where(
            'student_id',
            $student->id
        )
            ->where('course_id', $course->id)
            ->where('semester_id', $semester->id)
            ->where('id', '!=', $courseEnrollment->id)
            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->withErrors([
                    'student_id' =>
                        'This student is already enrolled in this course for the selected semester.',
                ]);
        }

        /*
         * Do not allow the academic identity of an enrollment
         * to change after a result has been recorded.
         */
        $hasResult = Result::where(
            'course_enrollment_id',
            $courseEnrollment->id
        )->exists();

        if (
            $hasResult &&
            (
                $courseEnrollment->student_id != $student->id ||
                $courseEnrollment->course_id != $course->id ||
                $courseEnrollment->semester_id != $semester->id
            )
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'course_id' =>
                        'This enrollment already has a result recorded. The student, course, or semester cannot be changed.',
                ]);
        }

        if (empty($validated['enrolled_at'])) {
            $validated['enrolled_at'] =
                $courseEnrollment->enrolled_at ?? now();
        }

        $courseEnrollment->update($validated);

        return redirect()
            ->route(
                'admin.course-enrollments.show',
                $courseEnrollment
            )
            ->with(
                'success',
                'Course enrollment updated successfully.'
            );
    }

    /**
     * Remove the specified enrollment.
     */
    public function destroy(
        CourseEnrollment $courseEnrollment
    ): RedirectResponse {
        /*
         * Never delete an enrollment that already has
         * an academic result attached to it.
         */
        $hasResult = Result::where(
            'course_enrollment_id',
            $courseEnrollment->id
        )->exists();

        if ($hasResult) {
            return redirect()
                ->route('admin.course-enrollments.index')
                ->with(
                    'error',
                    'This enrollment cannot be deleted because a result has already been recorded for it.'
                );
        }

        $courseEnrollment->delete();

        return redirect()
            ->route('admin.course-enrollments.index')
            ->with(
                'success',
                'Course enrollment deleted successfully.'
            );
    }
}