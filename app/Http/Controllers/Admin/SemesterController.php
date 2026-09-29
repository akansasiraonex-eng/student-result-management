<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Semester;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SemesterController extends Controller
{
    public function index(): View
    {
        $semesters = Semester::with('academicYear')
            ->orderByDesc('academic_year_id')
            ->orderBy('semester_number')
            ->paginate(10);

        return view('admin.semesters.index', compact('semesters'));
    }

    public function create(): View
    {
        $academicYears = AcademicYear::where('is_active', true)
            ->orderByDesc('start_year')
            ->get();

        return view('admin.semesters.create', compact('academicYears'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'academic_year_id' => [
                'required',
                'exists:academic_years,id',
            ],
            'name' => [
                'required',
                'string',
                'max:50',
            ],
            'semester_number' => [
                'required',
                'integer',
                'min:1',
                'max:3',
            ],
            'start_date' => [
                'required',
                'date',
            ],
            'end_date' => [
                'required',
                'date',
                'after:start_date',
            ],
            'is_current' => [
                'nullable',
                'boolean',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $validated['is_current'] = $request->boolean('is_current');
        $validated['is_active'] = $request->boolean('is_active');

        $exists = Semester::where('academic_year_id', $validated['academic_year_id'])
            ->where('semester_number', $validated['semester_number'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'semester_number' =>
                        'This semester number already exists for the selected academic year.',
                ]);
        }

        if ($validated['is_current']) {
            Semester::where('is_current', true)
                ->update(['is_current' => false]);
        }

        Semester::create($validated);

        return redirect()
            ->route('admin.semesters.index')
            ->with('success', 'Semester created successfully.');
    }

    public function show(Semester $semester): View
    {
        $semester->load('academicYear');
        $semester->loadCount('courseAssignments', 'courseEnrollments');

        return view('admin.semesters.show', compact('semester'));
    }

    public function edit(Semester $semester): View
    {
        $academicYears = AcademicYear::where('is_active', true)
            ->orderByDesc('start_year')
            ->get();

        return view(
            'admin.semesters.edit',
            compact('semester', 'academicYears')
        );
    }

    public function update(
        Request $request,
        Semester $semester
    ): RedirectResponse {
        $validated = $request->validate([
            'academic_year_id' => [
                'required',
                'exists:academic_years,id',
            ],
            'name' => [
                'required',
                'string',
                'max:50',
            ],
            'semester_number' => [
                'required',
                'integer',
                'min:1',
                'max:3',
            ],
            'start_date' => [
                'required',
                'date',
            ],
            'end_date' => [
                'required',
                'date',
                'after:start_date',
            ],
            'is_current' => [
                'nullable',
                'boolean',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $validated['is_current'] = $request->boolean('is_current');
        $validated['is_active'] = $request->boolean('is_active');

        $exists = Semester::where('academic_year_id', $validated['academic_year_id'])
            ->where('semester_number', $validated['semester_number'])
            ->where('id', '!=', $semester->id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'semester_number' =>
                        'This semester number already exists for the selected academic year.',
                ]);
        }

        if ($validated['is_current']) {
            Semester::where('is_current', true)
                ->where('id', '!=', $semester->id)
                ->update(['is_current' => false]);
        }

        $semester->update($validated);

        return redirect()
            ->route('admin.semesters.index')
            ->with('success', 'Semester updated successfully.');
    }

    public function destroy(Semester $semester): RedirectResponse
    {
        if ($semester->courseAssignments()->exists()) {
            return redirect()
                ->route('admin.semesters.index')
                ->with(
                    'error',
                    'This semester cannot be deleted because courses have been assigned to it.'
                );
        }

        if ($semester->courseEnrollments()->exists()) {
            return redirect()
                ->route('admin.semesters.index')
                ->with(
                    'error',
                    'This semester cannot be deleted because students are enrolled in courses for it.'
                );
        }

        $semester->delete();

        return redirect()
            ->route('admin.semesters.index')
            ->with('success', 'Semester deleted successfully.');
    }
}