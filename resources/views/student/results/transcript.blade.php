
<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

           <div class="flex flex-wrap items-center gap-2">

    <a
        href="{{ route('student.transcript') }}"
        class="btn-primary"
    >
        Academic Transcript
    </a>

    <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800 dark:bg-green-900/30 dark:text-green-300">
        Published Results Only
    </span>

</div>
            <span class="inline-flex w-fit items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800 dark:bg-green-900/30 dark:text-green-300">
                Official Record
            </span>

        </div>

    </x-slot>


    <div class="py-8">

        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">


            {{-- Navigation --}}

            <div class="flex flex-wrap gap-2">

                <a
                    href="{{ route('student.results.index') }}"
                    class="btn-secondary"
                >
                    ← My Academic Results
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

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">


                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Student Name
                            </p>

                            <p class="mt-1 font-semibold text-gray-900 dark:text-white">

                                {{ $student->first_name }}

                                @if ($student->middle_name)
                                    {{ $student->middle_name }}
                                @endif

                                {{ $student->last_name }}

                            </p>

                        </div>


                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Student Number
                            </p>

                            <p class="mt-1 font-semibold text-gray-900 dark:text-white">
                                {{ $student->student_number }}
                            </p>

                        </div>


                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Registration Number
                            </p>

                            <p class="mt-1 font-semibold text-gray-900 dark:text-white">
                                {{ $student->registration_number }}
                            </p>

                        </div>


                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Programme
                            </p>

                            <p class="mt-1 font-semibold text-gray-900 dark:text-white">
                                {{ $student->program?->name ?? 'Programme not assigned' }}
                            </p>

                            @if ($student->program?->code)

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    {{ $student->program->code }}
                                </p>

                            @endif

                        </div>


                    </div>

                </div>

            </div>


            {{-- Academic summary --}}

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">


                {{-- Total courses --}}

                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Published Courses
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $enrollments->count() }}
                    </p>

                </div>


                {{-- Credit units --}}

                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Total Credit Units
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ number_format($totalCredits, 1) }}
                    </p>

                </div>


                {{-- Quality points --}}

                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Quality Points
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ number_format($totalQualityPoints, 2) }}
                    </p>

                </div>


                {{-- CGPA --}}

                <div class="rounded-xl bg-indigo-50 p-6 shadow-sm ring-1 ring-indigo-200 dark:bg-indigo-900/20 dark:ring-indigo-800">

                    <p class="text-sm font-medium text-indigo-700 dark:text-indigo-300">
                        Overall CGPA
                    </p>

                    <p class="mt-2 text-3xl font-bold text-indigo-700 dark:text-indigo-300">
                        {{ $cgpa !== null ? number_format($cgpa, 2) : '—' }}
                    </p>

                </div>


            </div>


            {{-- Semester results --}}

            @if ($semesterResults->count())

                @foreach ($semesterResults as $semesterId => $semesterEnrollments)

                    @php

                        $semester = $semesterEnrollments->first()->semester;

                        $summary = $semesterSummaries->get($semesterId);

                    @endphp


                    <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">


                        {{-- Semester heading --}}

                        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-700">

                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                                <div>

                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">

                                        {{ $semester?->academicYear?->name ?? 'Academic Year' }}

                                    </h3>

                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">

                                        {{ $semester?->name ?? 'Semester' }}

                                    </p>

                                </div>


                                <div class="text-left sm:text-right">

                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                        Semester GPA
                                    </p>

                                    <p class="mt-1 text-2xl font-bold text-indigo-600 dark:text-indigo-400">

                                        {{ isset($summary['gpa']) && $summary['gpa'] !== null
                                            ? number_format($summary['gpa'], 2)
                                            : '—' }}

                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- Courses --}}

                        <div class="overflow-x-auto">

                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">


                                <thead class="bg-gray-50 dark:bg-gray-900/50">

                                    <tr>

                                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                            Course
                                        </th>

                                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                            Credits
                                        </th>

                                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                            Coursework
                                        </th>

                                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                            Exam
                                        </th>

                                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                            Total
                                        </th>

                                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                            Grade
                                        </th>

                                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                            Grade Point
                                        </th>

                                    </tr>

                                </thead>


                                <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">


                                    @foreach ($semesterEnrollments as $enrollment)

                                        @php
                                            $result = $enrollment->result;
                                        @endphp


                                        @if ($result)

                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">


                                                {{-- Course --}}

                                                <td class="px-6 py-4">

                                                    <div class="font-semibold text-gray-900 dark:text-white">
                                                        {{ $enrollment->course?->code ?? 'N/A' }}
                                                    </div>

                                                    <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $enrollment->course?->name ?? 'Course name unavailable' }}
                                                    </div>

                                                </td>


                                                {{-- Credits --}}

                                                <td class="px-6 py-4 text-center text-sm text-gray-700 dark:text-gray-300">

                                                    {{ number_format((float) $result->credit_units, 1) }}

                                                </td>


                                                {{-- Coursework --}}

                                                <td class="px-6 py-4 text-center text-sm text-gray-700 dark:text-gray-300">

                                                    {{ number_format((float) $result->coursework_mark, 2) }}

                                                </td>


                                                {{-- Examination --}}

                                                <td class="px-6 py-4 text-center text-sm text-gray-700 dark:text-gray-300">

                                                    {{ number_format((float) $result->final_exam_mark, 2) }}

                                                </td>


                                                {{-- Total --}}

                                                <td class="px-6 py-4 text-center font-semibold text-gray-900 dark:text-white">

                                                    {{ number_format((float) $result->total_mark, 2) }}

                                                </td>


                                                {{-- Grade --}}

                                                <td class="px-6 py-4 text-center">

                                                    <span class="inline-flex min-w-12 justify-center rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/30 dark:text-green-300">

                                                        {{ $result->grade }}

                                                    </span>

                                                </td>


                                                {{-- Grade point --}}

                                                <td class="px-6 py-4 text-center text-sm font-semibold text-gray-900 dark:text-white">

                                                    {{ $result->grade_point !== null
                                                        ? number_format((float) $result->grade_point, 2)
                                                        : '—' }}

                                                </td>


                                            </tr>

                                        @endif

                                    @endforeach


                                </tbody>

                            </table>

                        </div>


                        {{-- Semester summary --}}

                        <div class="border-t border-gray-200 bg-gray-50 px-6 py-4 dark:border-gray-700 dark:bg-gray-900/30">

                            <div class="flex flex-wrap gap-x-8 gap-y-2 text-sm">


                                <div>

                                    <span class="text-gray-500 dark:text-gray-400">
                                        Credit Units:
                                    </span>

                                    <strong class="text-gray-900 dark:text-white">
                                        {{ number_format((float) ($summary['credits'] ?? 0), 1) }}
                                    </strong>

                                </div>


                                <div>

                                    <span class="text-gray-500 dark:text-gray-400">
                                        Quality Points:
                                    </span>

                                    <strong class="text-gray-900 dark:text-white">
                                        {{ number_format((float) ($summary['quality_points'] ?? 0), 2) }}
                                    </strong>

                                </div>


                                <div>

                                    <span class="text-gray-500 dark:text-gray-400">
                                        GPA:
                                    </span>

                                    <strong class="text-indigo-600 dark:text-indigo-400">

                                        {{ isset($summary['gpa']) && $summary['gpa'] !== null
                                            ? number_format($summary['gpa'], 2)
                                            : '—' }}

                                    </strong>

                                </div>


                            </div>

                        </div>


                    </div>

                @endforeach


            @else


                {{-- No results --}}

                <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">

                    <div class="px-6 py-14 text-center">

                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            No Published Results
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm text-gray-500 dark:text-gray-400">

                            Your academic transcript will appear here after your results have been approved and officially published.

                        </p>

                    </div>

                </div>


            @endif


            {{-- Transcript notice --}}

            <div class="rounded-xl border border-indigo-200 bg-indigo-50 p-5 dark:border-indigo-900/50 dark:bg-indigo-900/10">

                <div class="flex gap-3">

                    <div class="flex-shrink-0">

                        <svg
                            class="h-5 w-5 text-indigo-600 dark:text-indigo-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"
                            />

                        </svg>

                    </div>


                    <div>

                        <h4 class="text-sm font-semibold text-indigo-900 dark:text-indigo-300">
                            Transcript Information
                        </h4>

                        <p class="mt-1 text-sm text-indigo-800 dark:text-indigo-400">

                            This transcript contains only academic results that have completed the institutional approval and publication process.

                        </p>

                    </div>

                </div>

            </div>


        </div>

    </div>

</x-app-layout>

