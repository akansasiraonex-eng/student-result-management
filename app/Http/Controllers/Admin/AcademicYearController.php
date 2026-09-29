<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of academic years.
     */
    public function index(): View
    {
        $academicYears = AcademicYear::orderByDesc('start_year')
            ->paginate(10);

        return view('admin.academic-years.index', compact('academicYears'));
    }

    /**
     * Show the form for creating a new academic year.
     */
    public function create(): View
    {
        return view('admin.academic-years.create');
    }

    /**
     * Store a newly created academic year.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:academic_years,name'],
            'start_year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'end_year' => ['required', 'integer', 'min:2000', 'max:2100', 'gte:start_year'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'is_current' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_current'] = $request->boolean('is_current');
        $validated['is_active'] = $request->boolean('is_active');

        if ($validated['is_current']) {
            AcademicYear::where('is_current', true)
                ->update(['is_current' => false]);
        }

        AcademicYear::create($validated);

        return redirect()
            ->route('admin.academic-years.index')
            ->with('success', 'Academic year created successfully.');
    }

    /**
     * Display the specified academic year.
     */
    public function show(AcademicYear $academicYear): View
    {
        $academicYear->loadCount('semesters', 'students');

        return view('admin.academic-years.show', compact('academicYear'));
    }

    /**
     * Show the form for editing the specified academic year.
     */
    public function edit(AcademicYear $academicYear): View
    {
        return view('admin.academic-years.edit', compact('academicYear'));
    }

    /**
     * Update the specified academic year.
     */
    public function update(
        Request $request,
        AcademicYear $academicYear
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                'unique:academic_years,name,' . $academicYear->id,
            ],
            'start_year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'end_year' => ['required', 'integer', 'min:2000', 'max:2100', 'gte:start_year'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'is_current' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_current'] = $request->boolean('is_current');
        $validated['is_active'] = $request->boolean('is_active');

        if ($validated['is_current']) {
            AcademicYear::whereKeyNot($academicYear->id)
                ->where('is_current', true)
                ->update(['is_current' => false]);
        }

        $academicYear->update($validated);

        return redirect()
            ->route('admin.academic-years.index')
            ->with('success', 'Academic year updated successfully.');
    }

    /**
     * Remove the specified academic year.
     */
    public function destroy(AcademicYear $academicYear): RedirectResponse
    {
        if ($academicYear->semesters()->exists()) {
            return redirect()
                ->route('admin.academic-years.index')
                ->with(
                    'error',
                    'This academic year cannot be deleted because it has semesters.'
                );
        }

        if ($academicYear->students()->exists()) {
            return redirect()
                ->route('admin.academic-years.index')
                ->with(
                    'error',
                    'This academic year cannot be deleted because students are linked to it.'
                );
        }

        $academicYear->delete();

        return redirect()
            ->route('admin.academic-years.index')
            ->with('success', 'Academic year deleted successfully.');
    }
}