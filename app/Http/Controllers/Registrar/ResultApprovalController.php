<?php

namespace App\Http\Controllers\Registrar;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\ResultApproval;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResultApprovalController extends Controller
{
    /**
     * Display submitted results awaiting review.
     */
    public function index(): View
    {
        $results = Result::with([
            'courseEnrollment.student',
            'courseEnrollment.course',
            'courseEnrollment.semester.academicYear',
            'enteredBy',
        ])
            ->where('status', 'submitted')
            ->orderByDesc('submitted_at')
            ->orderByDesc('id')
            ->paginate(10);

        return view(
            'registrar.result-approvals.index',
            compact('results')
        );
    }

    /**
     * Display a single result for review.
     */
    public function show(Result $result): View
    {
        $result->load([
            'courseEnrollment.student.program.department',
            'courseEnrollment.student.admissionAcademicYear',
            'courseEnrollment.course.department',
            'courseEnrollment.semester.academicYear',
            'enteredBy',
            'approvals.approvedBy',
        ]);

        return view(
            'registrar.result-approvals.show',
            compact('result')
        );
    }

    /**
     * Approve a submitted result.
     */
    public function approve(
        Request $request,
        Result $result
    ): RedirectResponse {
        $validated = $request->validate([
            'comments' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        if ($result->status !== 'submitted') {
            return redirect()
                ->route(
                    'registrar.result-approvals.show',
                    $result
                )
                ->with(
                    'error',
                    'Only submitted results can be approved.'
                );
        }

        $result->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        ResultApproval::create([
            'result_id' => $result->id,
            'approved_by' => auth()->id(),
            'action' => 'approved',
            'comments' => $validated['comments'] ?? null,
            'action_at' => now(),
        ]);

        return redirect()
            ->route(
                'registrar.result-approvals.show',
                $result
            )
            ->with(
                'success',
                'Result approved successfully.'
            );
    }

    /**
     * Reject a submitted result.
     */
    public function reject(
        Request $request,
        Result $result
    ): RedirectResponse {
        $validated = $request->validate([
            'comments' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        if ($result->status !== 'submitted') {
            return redirect()
                ->route(
                    'registrar.result-approvals.show',
                    $result
                )
                ->with(
                    'error',
                    'Only submitted results can be rejected.'
                );
        }

        $result->update([
            'status' => 'rejected',
        ]);

        ResultApproval::create([
            'result_id' => $result->id,
            'approved_by' => auth()->id(),
            'action' => 'rejected',
            'comments' => $validated['comments'],
            'action_at' => now(),
        ]);

        return redirect()
            ->route(
                'registrar.result-approvals.show',
                $result
            )
            ->with(
                'success',
                'Result rejected successfully.'
            );
    }

    /**
     * Return a submitted result to the lecturer for correction.
     */
    public function returnToLecturer(
        Request $request,
        Result $result
    ): RedirectResponse {
        $validated = $request->validate([
            'comments' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        if ($result->status !== 'submitted') {
            return redirect()
                ->route(
                    'registrar.result-approvals.show',
                    $result
                )
                ->with(
                    'error',
                    'Only submitted results can be returned to the lecturer.'
                );
        }

        $result->update([
            'status' => 'rejected',
        ]);

        ResultApproval::create([
            'result_id' => $result->id,
            'approved_by' => auth()->id(),
            'action' => 'returned',
            'comments' => $validated['comments'],
            'action_at' => now(),
        ]);

        return redirect()
            ->route(
                'registrar.result-approvals.show',
                $result
            )
            ->with(
                'success',
                'Result returned to the lecturer for correction.'
            );
    }

    /**
 * Publish an approved result.
 */
public function publish(Result $result): RedirectResponse
{
    if ($result->status !== 'approved') {
        return redirect()
            ->route(
                'registrar.result-approvals.show',
                $result
            )
            ->with(
                'error',
                'Only approved results can be published.'
            );
    }

    $result->update([
        'status' => 'published',
        'published_at' => now(),
    ]);

    ResultApproval::create([
        'result_id' => $result->id,
        'approved_by' => auth()->id(),
        'action' => 'published',
        'comments' => 'Result published by registrar.',
        'action_at' => now(),
    ]);

    return redirect()
        ->route(
            'registrar.result-approvals.show',
            $result
        )
        ->with(
            'success',
            'Result published successfully.'
        );
}

}