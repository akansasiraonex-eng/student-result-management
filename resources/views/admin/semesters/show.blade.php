<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Semester Details
            </h2>

            <a
                href="{{ route('admin.semesters.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700"
            >
                Back to Semesters
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <div>
                            <h3 class="text-2xl font-bold">
                                {{ $semester->name }}
                            </h3>

                            <p class="mt-1 text-gray-500 dark:text-gray-400">
                                {{ $semester->academicYear->name }}
                            </p>
                        </div>

                        <div class="mt-4 md:mt-0 flex gap-2">
                            @if ($semester->is_current)
                                <span class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Current
                                </span>
                            @endif

                            @if ($semester->is_active)
                                <span class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Inactive
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="p-5 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-300">
                                Academic Year
                            </h4>

                            <p class="mt-2 text-lg font-medium">
                                {{ $semester->academicYear->name }}
                            </p>
                        </div>

                        <div class="p-5 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-300">
                                Semester Number
                            </h4>

                            <p class="mt-2 text-lg font-medium">
                                Semester {{ $semester->semester_number }}
                            </p>
                        </div>

                        <div class="p-5 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-300">
                                Start Date
                            </h4>

                            <p class="mt-2 text-lg font-medium">
                                {{ $semester->start_date->format('d F Y') }}
                            </p>
                        </div>

                        <div class="p-5 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-300">
                                End Date
                            </h4>

                            <p class="mt-2 text-lg font-medium">
                                {{ $semester->end_date->format('d F Y') }}
                            </p>
                        </div>

                        <div class="p-5 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-300">
                                Course Assignments
                            </h4>

                            <p class="mt-2 text-2xl font-bold">
                                {{ $semester->course_assignments_count }}
                            </p>
                        </div>

                        <div class="p-5 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-300">
                                Course Enrollments
                            </h4>

                            <p class="mt-2 text-2xl font-bold">
                                {{ $semester->course_enrollments_count }}
                            </p>
                        </div>

                    </div>

                    <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-lg font-semibold mb-4">
                            Record Information
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-medium">Created:</span>
                                {{ $semester->created_at->format('d F Y, H:i') }}
                            </div>

                            <div>
                                <span class="font-medium">Last Updated:</span>
                                {{ $semester->updated_at->format('d F Y, H:i') }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center gap-4">
                        <a
                            href="{{ route('admin.semesters.edit', $semester) }}"
                            class="px-4 py-2 bg-green-600 text-blue rounded-md hover:bg-green-700"
                        >
                            Edit Semester
                        </a>

                        <a
                            href="{{ route('admin.semesters.index') }}"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600"
                        >
                            Back
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>