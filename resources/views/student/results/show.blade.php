<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Result Details
                </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                View the official details of your published academic result.
            </p>
        </div>

        <span class="inline-flex w-fit items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800 dark:bg-green-900/30 dark:text-green-300">
            Officially Published
        </span>
    </div>
</x-slot>

<div class="py-8">
    <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6 lg:px-8">

        {{-- Back button --}}
        <div>
            <a
                href="{{ route('student.results.index') }}"
                class="inline-flex items-center rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
            >
                <svg
                    class="mr-2 h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>

                Back to Results
            </a>
        </div>

        {{-- Student information --}}
        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">

            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Student Information
                </h3>
            </div>

            <div class="p-6">
                <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Student Name
                        </p>

                        <h4 class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $student->first_name }}

                            @if ($student->middle_name)
                                {{ $student->middle_name }}
                            @endif

                            {{ $student->last_name }}
                        </h4>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Student Number
                            </p>

                            <p class="mt-1 font-semibold text-gray-900 dark:text-white">
                                {{ $student->student_number }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Registration Number
                            </p>

                            <p class="mt-1 font-semibold text-gray-900 dark:text-white">
                                {{ $student->registration_number }}
                            </p>
                        </div>

                    </div>

                </div>

                @if ($student->program)
                    <div class="mt-5 rounded-lg bg-gray-50 p-4 dark:bg-gray-900/50">
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Programme
                        </p>

                        <p class="mt-1 font-semibold text-gray-900 dark:text-white">
                            {{ $student->program->name }}
                        </p>

                        @if ($student->program->code)
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ $student->program->code }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        {{-- Course and academic period --}}
        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">

            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Course Information
                </h3>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Course Code
                        </p>

                        <p class="mt-1 text-lg font-bold text-gray-900 dark:text-white">
                            {{ $courseEnrollment->course?->code ?? 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Course Name
                        </p>

                        <p class="mt-1 font-semibold text-gray-900 dark:text-white">
                            {{ $courseEnrollment->course?->name ?? 'Course name unavailable' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Department
                        </p>

                        <p class="mt-1 font-semibold text-gray-900 dark:text-white">
                            {{ $courseEnrollment->course?->department?->name ?? 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Credit Units
                        </p>

                        <p class="mt-1 font-semibold text-gray-900 dark:text-white">
                            {{ number_format((float) $result->credit_units, 1) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Academic Year
                        </p>

                        <p class="mt-1 font-semibold text-gray-900 dark:text-white">
                            {{ $courseEnrollment->semester?->academicYear?->name ?? 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Semester
                        </p>

                        <p class="mt-1 font-semibold text-gray-900 dark:text-white">
                            {{ $courseEnrollment->semester?->name ?? 'N/A' }}
                        </p>
                    </div>

                </div>
            </div>
        </div>

        {{-- Assessment results --}}
        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">

            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Assessment Results
                </h3>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Marks recorded for this course.
                </p>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                    {{-- Coursework --}}
                    <div class="rounded-xl bg-gray-50 p-5 ring-1 ring-gray-200 dark:bg-gray-900/50 dark:ring-gray-700">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Coursework
                        </p>

                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                            {{ number_format((float) $result->coursework_mark, 2) }}
                        </p>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Out of 40 marks
                        </p>
                    </div>

                    {{-- Final examination --}}
                    <div class="rounded-xl bg-gray-50 p-5 ring-1 ring-gray-200 dark:bg-gray-900/50 dark:ring-gray-700">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Final Examination
                        </p>

                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                            {{ number_format((float) $result->final_exam_mark, 2) }}
                        </p>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Out of 60 marks
                        </p>
                    </div>

                    {{-- Total --}}
                    <div class="rounded-xl bg-indigo-50 p-5 ring-1 ring-indigo-200 dark:bg-indigo-900/20 dark:ring-indigo-800">
                        <p class="text-sm font-medium text-indigo-600 dark:text-indigo-300">
                            Total Mark
                        </p>

                        <p class="mt-2 text-3xl font-bold text-indigo-700 dark:text-indigo-200">
                            {{ number_format((float) $result->total_mark, 2) }}
                        </p>

                        <p class="mt-1 text-xs text-indigo-600 dark:text-indigo-300">
                            Out of 100 marks
                        </p>
                    </div>

                </div>
            </div>
        </div>

        {{-- Grade summary --}}
        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">

            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Grade Summary
                </h3>
            </div>

            <div class="p-6">

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                    {{-- Grade --}}
                    <div class="rounded-xl bg-green-50 p-6 text-center ring-1 ring-green-200 dark:bg-green-900/20 dark:ring-green-800">
                        <p class="text-sm font-medium text-green-700 dark:text-green-300">
                            Grade
                        </p>

                        <p class="mt-2 text-4xl font-extrabold text-green-700 dark:text-green-300">
                            {{ $result->grade ?? '—' }}
                        </p>
                    </div>

                    {{-- Grade point --}}
                    <div class="rounded-xl bg-indigo-50 p-6 text-center ring-1 ring-indigo-200 dark:bg-indigo-900/20 dark:ring-indigo-800">
                        <p class="text-sm font-medium text-indigo-700 dark:text-indigo-300">
                            Grade Point
                        </p>

                        <p class="mt-2 text-4xl font-extrabold text-indigo-700 dark:text-indigo-300">
                            {{ $result->grade_point !== null
                                ? number_format((float) $result->grade_point, 2)
                                : '—' }}
                        </p>
                    </div>

                    {{-- Remarks --}}
                    <div class="rounded-xl bg-gray-50 p-6 text-center ring-1 ring-gray-200 dark:bg-gray-900/50 dark:ring-gray-700">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Remarks
                        </p>

                        <p class="mt-2 text-xl font-bold text-gray-900 dark:text-white">
                            {{ $result->remarks ?? '—' }}
                        </p>
                    </div>

                </div>

            </div>
        </div>

        {{-- Publication information --}}
        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">

            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Publication Information
                </h3>
            </div>

            <div class="p-6">

                <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Result Status
                        </p>

                        <span class="mt-2 inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-800 dark:bg-green-900/30 dark:text-green-300">
                            Published
                        </span>
                    </div>

                    <div class="sm:text-right">
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Published On
                        </p>

                        <p class="mt-1 font-semibold text-gray-900 dark:text-white">
                            {{ $result->published_at
                                ? $result->published_at->format('d M Y, H:i')
                                : '—' }}
                        </p>
                    </div>

                </div>

                <div class="mt-5 rounded-lg border border-green-200 bg-green-50 p-4 dark:border-green-800 dark:bg-green-900/20">

                    <div class="flex gap-3">

                        <svg
                            class="mt-0.5 h-5 w-5 flex-shrink-0 text-green-600 dark:text-green-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 3c-2.755 0-5.37.936-7.348 2.516A11.942 11.942 0 003 12c0 2.21.6 4.28 1.652 6.016A11.955 11.955 0 0112 21c2.755 0 5.37-.936 7.348-2.516A11.942 11.942 0 0021 12c0-2.21-.6-4.28-1.652-6.016z"
                            />
                        </svg>

                        <div>
                            <p class="text-sm font-semibold text-green-900 dark:text-green-300">
                                Official Academic Record
                            </p>

                            <p class="mt-1 text-sm text-green-800 dark:text-green-400">
                                This result has completed the institutional approval process and has been officially published for student viewing.
                            </p>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        {{-- Footer navigation --}}
        <div class="flex justify-start border-t border-gray-200 pt-6 dark:border-gray-700">
            <a
                href="{{ route('student.results.index') }}"
                class="inline-flex items-center rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-700"
            >
                ← Back to Academic Results
            </a>
        </div>

    </div>
</div>


</x-app-layout>
