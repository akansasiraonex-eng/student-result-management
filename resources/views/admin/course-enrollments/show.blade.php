<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Enrollment Details
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Complete information about this course enrollment.
                </p>
            </div>

            <a
                href="{{ route('admin.course-enrollments.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600"
            >
                Back to Enrollments
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">

                {{-- Page Header --}}
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">

                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $courseEnrollment->student->first_name }}
                                {{ $courseEnrollment->student->middle_name }}
                                {{ $courseEnrollment->student->last_name }}
                            </h3>

                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Student Number:
                                {{ $courseEnrollment->student->student_number }}
                            </p>
                        </div>

                        @php
                            $statusClasses = match ($courseEnrollment->status) {
                                'enrolled' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                'dropped' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                'withdrawn' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                'deferred' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
                                default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                            };
                        @endphp

                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusClasses }}">
                            {{ ucfirst($courseEnrollment->status) }}
                        </span>

                    </div>
                </div>

                <div class="p-6">

                    {{-- Student Information --}}
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Student Information
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Student Number
                                </p>

                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $courseEnrollment->student->student_number }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Full Name
                                </p>

                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $courseEnrollment->student->first_name }}
                                    {{ $courseEnrollment->student->middle_name }}
                                    {{ $courseEnrollment->student->last_name }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Program
                                </p>

                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $courseEnrollment->student->program->name ?? 'N/A' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Department
                                </p>

                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $courseEnrollment->student->program->department->name ?? 'N/A' }}
                                </p>
                            </div>

                        </div>
                    </div>

                    {{-- Course Information --}}
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Course Information
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Course Code
                                </p>

                                <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $courseEnrollment->course->code }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Course Name
                                </p>

                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $courseEnrollment->course->name }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Credit Units
                                </p>

                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $courseEnrollment->course->credit_units }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Course Department
                                </p>

                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $courseEnrollment->course->department->name ?? 'N/A' }}
                                </p>
                            </div>

                        </div>
                    </div>

                    {{-- Academic Information --}}
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Academic Information
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Academic Year
                                </p>

                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $courseEnrollment->semester->academicYear->name ?? 'N/A' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Semester
                                </p>

                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $courseEnrollment->semester->name }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Enrollment Status
                                </p>

                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ ucfirst($courseEnrollment->status) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Enrolled At
                                </p>

                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $courseEnrollment->enrolled_at
                                        ? $courseEnrollment->enrolled_at->format('d M Y, H:i')
                                        : 'Not recorded' }}
                                </p>
                            </div>

                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="pt-6 border-t border-gray-200 dark:border-gray-700">

                        <div class="flex flex-wrap gap-3">

                            <a
                                href="{{ route('admin.course-enrollments.edit', $courseEnrollment) }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-blue rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-indigo-700"
                            >
                                Edit Enrollment
                            </a>

                            <a
                                href="{{ route('admin.course-enrollments.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 text-blue rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-700"
                            >
                                Back to List
                            </a>

                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>