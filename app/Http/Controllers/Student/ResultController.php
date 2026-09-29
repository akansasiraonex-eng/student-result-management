<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CourseEnrollment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResultController extends Controller
{
    /**
     * Display the authenticated student's published results.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        /*
         * Find the student profile belonging to
         * the authenticated user.
         */
        $student = $user->student;

        abort_unless($student, 404, 'Student profile not found.');

        /*
         * Get the selected semester from the URL.
         *
         * Example:
         * /student/results?semester_id=5
         */
        $selectedSemesterId = $request->integer('semester_id');

        /*
         * Retrieve only published results belonging
         * to the authenticated student.
         */
        $enrollmentsQuery = CourseEnrollment::query()
            ->with([
                'course.department',
                'semester.academicYear',
                'result',
            ])
            ->where('student_id', $student->id)
            ->whereHas('result', function ($query) {
                $query->where('status', 'published');
            });

        /*
         * Apply semester filtering when a valid
         * semester has been selected.
         */
        if ($selectedSemesterId > 0) {
            $enrollmentsQuery->where(
                'semester_id',
                $selectedSemesterId
            );
        }

        $enrollments = $enrollmentsQuery
            ->orderByDesc('semester_id')
            ->orderBy('course_id')
            ->get();

        /*
         * Extract published results.
         */
        $results = $enrollments
            ->pluck('result')
            ->filter();

        /*
         * Calculate the displayed credit units and
         * quality points.
         *
         * When a semester is selected, these values
         * represent that semester.
         *
         * When no semester is selected, they represent
         * the student's complete published record.
         */
        $totalCredits = $results->sum(
            fn ($result) => (float) $result->credit_units
        );

        $totalGradePoints = $results->sum(function ($result) {
            return (float) $result->grade_point *
                (float) $result->credit_units;
        });

        /*
         * Calculate the GPA for the currently
         * displayed results.
         */
        $gpa = $totalCredits > 0
            ? round($totalGradePoints / $totalCredits, 2)
            : null;

        /*
         * Retrieve all semesters in which this student
         * has published results.
         *
         * This list remains available even when a
         * particular semester is selected.
         */
        $availableSemesters = CourseEnrollment::query()
            ->with('semester.academicYear')
            ->where('student_id', $student->id)
            ->whereHas('result', function ($query) {
                $query->where('status', 'published');
            })
            ->get()
            ->pluck('semester')
            ->filter()
            ->unique('id')
            ->sortByDesc(function ($semester) {
                return $semester->id;
            })
            ->values();

        /*
         * Group the currently displayed results
         * by semester.
         */
        $semesterResults = $enrollments->groupBy('semester_id');

        /*
         * Calculate GPA for every displayed semester.
         */
        $semesterGpas = $semesterResults->map(function ($semesterEnrollments) {
            $semesterResults = $semesterEnrollments
                ->pluck('result')
                ->filter();

            $credits = $semesterResults->sum(
                fn ($result) => (float) $result->credit_units
            );

            $qualityPoints = $semesterResults->sum(function ($result) {
                return (float) $result->grade_point *
                    (float) $result->credit_units;
            });

            return [
                'credits' => $credits,
                'quality_points' => $qualityPoints,
                'gpa' => $credits > 0
                    ? round($qualityPoints / $credits, 2)
                    : null,
            ];
        });

        return view(
            'student.results.index',
            compact(
                'student',
                'enrollments',
                'results',
                'totalCredits',
                'gpa',
                'semesterResults',
                'semesterGpas',
                'availableSemesters',
                'selectedSemesterId'
            )
        );
    }

    /**
     * Display a single published result.
     */
    public function show(
        CourseEnrollment $courseEnrollment
    ): View {
        $student = auth()->user()->student;

        if (!$student) {
            abort(403, 'Student profile not found.');
        }

        /*
         * Make sure the enrollment belongs to
         * the authenticated student.
         */
        if ($courseEnrollment->student_id !== $student->id) {
            abort(
                403,
                'You are not authorized to view this result.'
            );
        }

        /*
         * Retrieve the result associated with
         * this enrollment.
         */
        $result = $courseEnrollment->result;

        /*
         * Students must never see draft, submitted,
         * approved, or rejected results.
         */
        if (!$result || $result->status !== 'published') {
            abort(404, 'Published result not found.');
        }

        $courseEnrollment->load([
            'course.department',
            'semester.academicYear',
        ]);

        return view(
            'student.results.show',
            [
                'student' => $student,
                'courseEnrollment' => $courseEnrollment,
                'result' => $result,
            ]
        );
    }

    /**
 * Display the authenticated student's academic transcript.
 */
public function transcript(Request $request): View
{
    $user = $request->user();

    /*
     * Find the student profile belonging to
     * the authenticated user.
     */
    $student = $user->student;

    abort_unless($student, 404, 'Student profile not found.');

    /*
     * Retrieve only published results belonging
     * to the authenticated student.
     */
    $enrollments = CourseEnrollment::query()
        ->with([
            'course.department',
            'semester.academicYear',
            'result',
        ])
        ->where('student_id', $student->id)
        ->whereHas('result', function ($query) {
            $query->where('status', 'published');
        })
        ->orderBy('semester_id')
        ->orderBy('course_id')
        ->get();

    /*
     * Group results by semester.
     */
    $semesterResults = $enrollments->groupBy('semester_id');

    /*
     * Calculate semester summaries.
     */
    $semesterSummaries = $semesterResults->map(
        function ($semesterEnrollments) {
            $results = $semesterEnrollments
                ->pluck('result')
                ->filter();

            $credits = $results->sum(
                fn ($result) => (float) $result->credit_units
            );

            $qualityPoints = $results->sum(
                function ($result) {
                    return (float) $result->grade_point *
                        (float) $result->credit_units;
                }
            );

            $gpa = $credits > 0
                ? round($qualityPoints / $credits, 2)
                : null;

            return [
                'credits' => $credits,
                'quality_points' => $qualityPoints,
                'gpa' => $gpa,
            ];
        }
    );

    /*
     * Calculate overall transcript totals.
     */
    $totalCredits = $enrollments
        ->pluck('result')
        ->filter()
        ->sum(
            fn ($result) => (float) $result->credit_units
        );

    $totalQualityPoints = $enrollments
        ->pluck('result')
        ->filter()
        ->sum(
            function ($result) {
                return (float) $result->grade_point *
                    (float) $result->credit_units;
            }
        );

    /*
     * Calculate overall cgpa.
     */
    $cgpa= $totalCredits > 0
        ? round($totalQualityPoints / $totalCredits, 2)
        : null;

    return view(
        'student.results.transcript',
        compact(
            'student',
            'enrollments',
            'semesterResults',
            'semesterSummaries',
            'totalCredits',
            'totalQualityPoints',
            'cgpa'
        )
    );
}
}
