<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Course Assignment Details
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    View the complete details of this course assignment.
                </p>
            </div>

            <a
                href="{{ route('admin.course-assignments.index') }}"
                class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-800 font-semibold text-sm rounded-md hover:bg-gray-300 transition"
            >
                Back to Assignments
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Success message --}}
            @if (session('success'))
                <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200">
                    <div class="text-sm font-medium text-green-800">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- Error message --}}
            @if (session('error'))
                <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200">
                    <div class="text-sm font-medium text-red-800">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            {{-- Assignment summary --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="flex items-start justify-between">

                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $courseAssignment->course->code }}
                            </h3>

                            <p class="mt-1 text-lg text-gray-600 dark:text-gray-400">
                                {{ $courseAssignment->course->name }}
                            </p>
                        </div>

                        <div>
                            @if ($courseAssignment->is_active)
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                    Inactive
                                </span>
                            @endif
                        </div>

                    </div>

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Course information --}}
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-5">

                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                Course Information
                            </h4>

                            <dl class="mt-4 space-y-3">

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Course Code
                                    </dt>

                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $courseAssignment->course->code }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Course Name
                                    </dt>

                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $courseAssignment->course->name }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Department
                                    </dt>

                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $courseAssignment->course->department->name }}
                                        ({{ $courseAssignment->course->department->code }})
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Credit Units
                                    </dt>

                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $courseAssignment->course->credit_units }}
                                    </dd>
                                </div>

                            </dl>

                        </div>

                        {{-- Lecturer information --}}
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-5">

                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                Lecturer Information
                            </h4>

                            <dl class="mt-4 space-y-3">

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Staff Number
                                    </dt>

                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $courseAssignment->lecturer->staff_number }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Lecturer Name
                                    </dt>

                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $courseAssignment->lecturer->title }}
                                        {{ $courseAssignment->lecturer->first_name }}
                                        {{ $courseAssignment->lecturer->middle_name }}
                                        {{ $courseAssignment->lecturer->last_name }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Department
                                    </dt>

                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $courseAssignment->lecturer->department->name }}
                                        ({{ $courseAssignment->lecturer->department->code }})
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Specialization
                                    </dt>

                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $courseAssignment->lecturer->specialization ?: 'Not specified' }}
                                    </dd>
                                </div>

                            </dl>

                        </div>

                        {{-- Semester information --}}
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-5">

                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                Academic Period
                            </h4>

                            <dl class="mt-4 space-y-3">

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Academic Year
                                    </dt>

                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $courseAssignment->semester->academicYear->name }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Semester
                                    </dt>

                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $courseAssignment->semester->name }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Semester Number
                                    </dt>

                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $courseAssignment->semester->semester_number }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Period
                                    </dt>

                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $courseAssignment->semester->start_date->format('d M Y') }}
                                        —
                                        {{ $courseAssignment->semester->end_date->format('d M Y') }}
                                    </dd>
                                </div>

                            </dl>

                        </div>

                        {{-- Assignment status --}}
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-5">

                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                Assignment Status
                            </h4>

                            <dl class="mt-4 space-y-3">

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Lecturer Role
                                    </dt>

                                    <dd class="mt-1">
                                        @if ($courseAssignment->is_primary)
                                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                Primary Lecturer
                                            </span>
                                        @else
                                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-700">
                                                Assistant Lecturer
                                            </span>
                                        @endif
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Assignment Status
                                    </dt>

                                    <dd class="mt-1">
                                        @if ($courseAssignment->is_active)
                                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                                Inactive
                                            </span>
                                        @endif
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Assignment Created
                                    </dt>

                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $courseAssignment->created_at->format('d M Y, H:i') }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Last Updated
                                    </dt>

                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $courseAssignment->updated_at->format('d M Y, H:i') }}
                                    </dd>
                                </div>

                            </dl>

                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6 flex items-center justify-end gap-3">

                        <a
                            href="{{ route('admin.course-assignments.edit', $courseAssignment) }}"
                            class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-semibold text-sm rounded-md shadow-sm hover:bg-indigo-700 transition"
                        >
                            Edit Assignment
                        </a>

                        <form
                            method="POST"
                            action="{{ route('admin.course-assignments.destroy', $courseAssignment) }}"
                            onsubmit="return confirm('Are you sure you want to delete this course assignment?');"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="inline-flex items-center px-5 py-2.5 bg-red-600 text-blue font-semibold text-sm rounded-md shadow-sm hover:bg-red-700 transition"
                            >
                                Delete Assignment
                            </button>
                        </form>

                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>