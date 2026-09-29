<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    /**
     * Display a listing of courses.
     */
    public function index(): View
    {
        $courses = Course::with('department')
            ->orderBy('code')
            ->paginate(10);

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create(): View
    {
        $departments = Department::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.courses.create', compact('departments'));
    }

    /**
     * Store a newly created course.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'department_id' => ['required', 'exists:departments,id'],
            'code' => ['required', 'string', 'max:50', 'unique:courses,code'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'credit_units' => ['required', 'integer', 'min:1', 'max:20'],
            'course_type' => ['required', 'in:core,elective,practical,project'],
            'year_of_study' => ['required', 'integer', 'min:1', 'max:10'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Course::create($validated);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified course.
     */
    public function show(Course $course): View
    {
        $course->load('department');

        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course): View
    {
        $departments = Department::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.courses.edit', compact('course', 'departments'));
    }

    /**
     * Update the specified course.
     */
    public function update(Request $request, Course $course): RedirectResponse
    {
        $validated = $request->validate([
            'department_id' => ['required', 'exists:departments,id'],
            'code' => [
                'required',
                'string',
                'max:50',
                'unique:courses,code,' . $course->id,
            ],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'credit_units' => ['required', 'integer', 'min:1', 'max:20'],
            'course_type' => ['required', 'in:core,elective,practical,project'],
            'year_of_study' => ['required', 'integer', 'min:1', 'max:10'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $course->update($validated);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified course.
     */
    public function destroy(Course $course): RedirectResponse
    {
        if (
            $course->courseAssignments()->exists() ||
            $course->courseEnrollments()->exists()
        ) {
            return redirect()
                ->route('admin.courses.index')
                ->with('error', 'This course cannot be deleted because it has assignments or student enrollments.');
        }

        $course->delete();

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}