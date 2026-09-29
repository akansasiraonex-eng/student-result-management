<?php
namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\CourseAssignment;
use App\Models\CourseEnrollment;
use App\Models\Result;
use App\Models\ResultApproval;
use App\Services\GradingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResultController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected GradingService $gradingService
    ) {
    }

    /**
     * Display results for courses assigned to the logged-in lecturer.
     */
    public function index(): View
    {
        $lecturer = auth()->user()->lecturer;

        if (! $lecturer) {
            abort(403, 'Lecturer profile not found.');
        }

        $results = Result::with([
            'courseEnrollment.student',
            'courseEnrollment.course',
            'courseEnrollment.semester.academicYear',
        ])
            ->whereHas(
                'courseEnrollment.course.courseAssignments',
                function ($query) use ($lecturer) {
                    $query->where('lecturer_id', $lecturer->id)
                        ->where('is_active', true);
                }
            )
            ->orderByDesc('id')
            ->paginate(10);

        return view(
            'lecturer.results.index',
            compact('results')
        );
    }

    /**
     * Show the result entry form.
     */
    public function create(): View
    {
        $lecturer = auth()->user()->lecturer;

        if (! $lecturer) {
            abort(403, 'Lecturer profile not found.');
        }

        $enrollments = CourseEnrollment::with([
            'student',
            'course',
            'semester.academicYear',
        ])
            ->whereHas(
                'course.courseAssignments',
                function ($query) use ($lecturer) {
                    $query->where('lecturer_id', $lecturer->id)
                        ->where('is_active', true);
                }
            )
            ->whereDoesntHave('result')
            ->where('status', 'enrolled')
            ->orderByDesc('id')
            ->get();

        return view(
            'lecturer.results.create',
            compact('enrollments')
        );
    }

    /**
     * Store a newly entered result.
     */
    public function store(Request $request): RedirectResponse
    {
        $lecturer = auth()->user()->lecturer;

        if (! $lecturer) {
            abort(403, 'Lecturer profile not found.');
        }

        $validated = $request->validate([
            'course_enrollment_id' => [
                'required',
                'exists:course_enrollments,id',
            ],
            'coursework_mark' => [
                'required',
                'numeric',
                'min:0',
                'max:40',
            ],
            'final_exam_mark' => [
                'required',
                'numeric',
                'min:0',
                'max:60',
            ],
            'remarks' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $enrollment = CourseEnrollment::with([
            'course',
            'semester',
        ])->findOrFail(
            $validated['course_enrollment_id']
        );

        /*
         * Confirm that this lecturer is assigned
         * to the selected course for the selected semester.
         */
        $assignmentExists = CourseAssignment::where(
            'course_id',
            $enrollment->course_id
        )
            ->where(
                'semester_id',
                $enrollment->semester_id
            )
            ->where(
                'lecturer_id',
                $lecturer->id
            )
            ->where('is_active', true)
            ->exists();

        if (! $assignmentExists) {
            abort(
                403,
                'You are not assigned to teach this course for the selected semester.'
            );
        }

        /*
         * Only actively enrolled students can receive
         * a new result.
         */
        if ($enrollment->status !== 'enrolled') {
            return back()
                ->withInput()
                ->withErrors([
                    'course_enrollment_id' =>
                        'Results can only be entered for an enrolled student.',
                ]);
        }

        /*
         * Prevent duplicate results.
         */
        if ($enrollment->result()->exists()) {
            return back()
                ->withInput()
                ->withErrors([
                    'course_enrollment_id' =>
                        'A result already exists for this enrollment.',
                ]);
        }

        /*
         * Calculate the total mark.
         */
        $totalMark = round(
            (float) $validated['coursework_mark']
            + (float) $validated['final_exam_mark'],
            2
        );

        /*
         * Automatically determine the grade and
         * grade point using the central grading service.
         */
        $grading = $this->gradingService->calculate($totalMark);

        Result::create([
            'course_enrollment_id' => $enrollment->id,
            'coursework_mark' => $validated['coursework_mark'],
            'final_exam_mark' => $validated['final_exam_mark'],
            'total_mark' => $totalMark,
            'grade' => $grading['grade'],
            'grade_point' => $grading['grade_point'],
            'credit_units' => $enrollment->course->credit_units,
            'status' => 'draft',
            'remarks' => $validated['remarks'] ?? null,
            'entered_by' => auth()->id(),
        ]);

        return redirect()
            ->route('lecturer.results.index')
            ->with(
                'success',
                'Result entered successfully. Grade and grade point were calculated automatically.'
            );
    }

    /**
     * Display a single result.
     */
    public function show(Result $result): View
    {
        $lecturer = auth()->user()->lecturer;

        if (! $lecturer) {
            abort(403, 'Lecturer profile not found.');
        }

        $result->load([
            'courseEnrollment.student',
            'courseEnrollment.course',
            'courseEnrollment.semester.academicYear',
            'enteredBy',
            'approvals.approvedBy',
        ]);

        $assignmentExists = CourseAssignment::where(
            'course_id',
            $result->courseEnrollment->course_id
        )
            ->where(
                'semester_id',
                $result->courseEnrollment->semester_id
            )
            ->where(
                'lecturer_id',
                $lecturer->id
            )
            ->where('is_active', true)
            ->exists();

        if (! $assignmentExists) {
            abort(
                403,
                'You are not authorized to view this result.'
            );
        }

        return view(
            'lecturer.results.show',
            compact('result')
        );
    }

    /**
     * Show the result edit form.
     */
    public function edit(Result $result): View
    {
        $lecturer = auth()->user()->lecturer;

        if (! $lecturer) {
            abort(403, 'Lecturer profile not found.');
        }

        $result->load([
            'courseEnrollment.student',
            'courseEnrollment.course',
            'courseEnrollment.semester.academicYear',
        ]);

        $assignmentExists = CourseAssignment::where(
            'course_id',
            $result->courseEnrollment->course_id
        )
            ->where(
                'semester_id',
                $result->courseEnrollment->semester_id
            )
            ->where(
                'lecturer_id',
                $lecturer->id
            )
            ->where('is_active', true)
            ->exists();

        if (! $assignmentExists) {
            abort(
                403,
                'You are not authorized to edit this result.'
            );
        }

        /*
         * Approved and published results are permanently
         * locked against lecturer editing.
         */
        if (
            in_array(
                $result->status,
                ['approved', 'published'],
                true
            )
        ) {
            abort(
                403,
                'Approved or published results cannot be edited.'
            );
        }

        return view(
            'lecturer.results.edit',
            compact('result')
        );
    }

    /**
     * Update an existing result.
     */
    public function update(
        Request $request,
        Result $result
    ): RedirectResponse {
        $lecturer = auth()->user()->lecturer;

        if (! $lecturer) {
            abort(403, 'Lecturer profile not found.');
        }

        $result->load('courseEnrollment.course');

        $assignmentExists = CourseAssignment::where(
            'course_id',
            $result->courseEnrollment->course_id
        )
            ->where(
                'semester_id',
                $result->courseEnrollment->semester_id
            )
            ->where(
                'lecturer_id',
                $lecturer->id
            )
            ->where('is_active', true)
            ->exists();

        if (! $assignmentExists) {
            abort(
                403,
                'You are not authorized to update this result.'
            );
        }

        /*
         * Approved and published results cannot be changed
         * by lecturers.
         */
        if (
            in_array(
                $result->status,
                ['approved', 'published'],
                true
            )
        ) {
            abort(
                403,
                'Approved or published results cannot be edited.'
            );
        }

        $validated = $request->validate([
            'coursework_mark' => [
                'required',
                'numeric',
                'min:0',
                'max:40',
            ],
            'final_exam_mark' => [
                'required',
                'numeric',
                'min:0',
                'max:60',
            ],
            'remarks' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        /*
         * Recalculate the total mark.
         */
        $totalMark = round(
            (float) $validated['coursework_mark']
            + (float) $validated['final_exam_mark'],
            2
        );

        /*
         * Recalculate the grade and grade point.
         */
        $grading = $this->gradingService->calculate($totalMark);

        $updateData = [
            'coursework_mark' => $validated['coursework_mark'],
            'final_exam_mark' => $validated['final_exam_mark'],
            'total_mark' => $totalMark,
            'grade' => $grading['grade'],
            'grade_point' => $grading['grade_point'],
            'remarks' => $validated['remarks'] ?? null,
        ];

        /*
         * If a rejected result is corrected, return it to draft
         * so that the lecturer can submit it again for approval.
         */
        if ($result->status === 'rejected') {
            $updateData['status'] = 'draft';
            $updateData['submitted_at'] = null;
            $updateData['approved_at'] = null;
            $updateData['published_at'] = null;
        }

        $result->update($updateData);

        return redirect()
            ->route(
                'lecturer.results.show',
                $result
            )
            ->with(
                'success',
                'Result updated successfully. Grade and grade point were recalculated automatically.'
            );
    }

    /**
     * Delete a draft result.
     */
    public function destroy(Result $result): RedirectResponse
    {
        $lecturer = auth()->user()->lecturer;

        if (! $lecturer) {
            abort(403, 'Lecturer profile not found.');
        }

        $result->load('courseEnrollment');

        $assignmentExists = CourseAssignment::where(
            'course_id',
            $result->courseEnrollment->course_id
        )
            ->where(
                'semester_id',
                $result->courseEnrollment->semester_id
            )
            ->where(
                'lecturer_id',
                $lecturer->id
            )
            ->where('is_active', true)
            ->exists();

        if (! $assignmentExists) {
            abort(
                403,
                'You are not authorized to delete this result.'
            );
        }

        /*
         * Only draft results may be deleted.
         */
        if ($result->status !== 'draft') {
            return redirect()
                ->route('lecturer.results.index')
                ->with(
                    'error',
                    'Only draft results can be deleted.'
                );
        }

        $result->delete();

        return redirect()
            ->route('lecturer.results.index')
            ->with(
                'success',
                'Draft result deleted successfully.'
            );
    }

    /**
     * Submit a draft result for approval.
     */
    public function submit(Result $result): RedirectResponse
    {
        $lecturer = auth()->user()->lecturer;

        if (! $lecturer) {
            abort(403, 'Lecturer profile not found.');
        }

        $result->load('courseEnrollment');

        /*
         * Confirm that the logged-in lecturer is actively
         * assigned to the course for the result's semester.
         */
        $assignmentExists = CourseAssignment::where(
            'course_id',
            $result->courseEnrollment->course_id
        )
            ->where(
                'semester_id',
                $result->courseEnrollment->semester_id
            )
            ->where(
                'lecturer_id',
                $lecturer->id
            )
            ->where('is_active', true)
            ->exists();

        if (! $assignmentExists) {
            abort(
                403,
                'You are not authorized to submit this result.'
            );
        }

        /*
         * Only draft results can be submitted.
         */
        if ($result->status !== 'draft') {
            return redirect()
                ->route(
                    'lecturer.results.show',
                    $result
                )
                ->with(
                    'error',
                    'Only draft results can be submitted for approval.'
                );
        }

        /*
         * Make sure the grade exists before submission.
         *
         * This protects older records that may have been
         * created before automatic grading was implemented.
         */
        if (
            $result->grade === null ||
            $result->grade_point === null
        ) {
            $grading = $this->gradingService->calculate(
                (float) $result->total_mark
            );

            $result->update([
                'grade' => $grading['grade'],
                'grade_point' => $grading['grade_point'],
            ]);
        }

        /*
         * Update the result status first.
         */
        $result->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        /*
         * Record the submission in the approval history.
         *
         * The lecturer is the actor at this stage, therefore
         * their user ID is stored in approved_by according to
         * the current result_approvals table design.
         */
        ResultApproval::create([
            'result_id' => $result->id,
            'approved_by' => auth()->id(),
            'action' => 'submitted',
        ]);

        return redirect()
            ->route(
                'lecturer.results.show',
                $result
            )
            ->with(
                'success',
                'Result submitted successfully for approval.'
            );
    }
}
