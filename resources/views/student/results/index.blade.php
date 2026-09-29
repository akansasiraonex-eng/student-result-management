<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    My Academic Results
                </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                View your published academic results, semester performance and cumulative academic progress.
            </p>
        </div>

        <div>
            <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800 dark:bg-green-900/30 dark:text-green-300">
                Published Results Only
            </span>
        </div>
    </div>
</x-slot>

<div class="py-8">
    <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

        {{-- Success message --}}
        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-800 dark:border-green-800 dark:bg-green-900/20 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error message --}}
        @if (session('error'))
            <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800 dark:border-red-800 dark:bg-red-900/20 dark:text-red-300">
                {{ session('error') }}
            </div>
        @endif

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 p-4 dark:border-red-800 dark:bg-red-900/20">
                <ul class="list-disc space-y-1 pl-5 text-sm text-red-800 dark:text-red-300">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Student profile --}}
        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
            <div class="p-6">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Student Profile
                        </p>

                        <h3 class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $student->first_name }}

                            @if ($student->middle_name)
                                {{ $student->middle_name }}
                            @endif

                            {{ $student->last_name }}
                        </h3>

                        <div class="mt-2 flex flex-col gap-1 text-sm text-gray-600 dark:text-gray-300 sm:flex-row sm:gap-4">
                            <span>
                                Student Number:
                                <strong class="text-gray-900 dark:text-white">
                                    {{ $student->student_number }}
                                </strong>
                            </span>

                            <span class="hidden sm:inline">•</span>

                            <span>
                                Registration Number:
                                <strong class="text-gray-900 dark:text-white">
                                    {{ $student->registration_number }}
                                </strong>
                            </span>
                        </div>
                    </div>

                    <div class="rounded-lg bg-gray-50 p-4 sm:min-w-64 dark:bg-gray-900/50">
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Programme
                        </p>

                        <p class="mt-1 font-semibold text-gray-900 dark:text-white">
                            {{ $student->program?->name ?? 'Programme not assigned' }}
                        </p>

                        @if ($student->program?->code)
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ $student->program->code }}
                            </p>
                        @endif
                    </div>

                </div>
            </div>
        </div>


        {{-- Semester filter --}}

<div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">


<div class="border-b border-gray-200 px-6 py-5 dark:border-gray-700">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
        Filter Academic Results
    </h3>

    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
        Select an academic semester to view results for that period.
    </p>
</div>

<div class="p-6">

    <form
        method="GET"
        action="{{ route('student.results.index') }}"
        class="flex flex-col gap-4 sm:flex-row sm:items-end"
    >

        <div class="w-full sm:max-w-md">
            <label
                for="semester_id"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
            >
                Academic Semester
            </label>

            <select
                id="semester_id"
                name="semester_id"
                class="mt-1 block w-full rounded-md border-gray-300 bg-white py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            >
                <option value="">
                    All Published Results
                </option>

                @foreach ($availableSemesters as $semester)
                    <option
                        value="{{ $semester->id }}"
                        @selected($selectedSemesterId == $semester->id)
                    >
                        {{ $semester->academicYear?->name ?? 'Academic Year' }}
                        — {{ $semester->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-2">

            <button
                type="submit"
                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
            >
                Apply Filter
            </button>

            @if ($selectedSemesterId)
                <a
                    href="{{ route('student.results.index') }}"
                    class="inline-flex items-center rounded-md bg-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
                >
                    Clear
                </a>
            @endif

        </div>

    </form>

</div>


</div>


        {{-- Academic summary --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

            {{-- Published courses --}}
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Published Courses
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $results->count() }}
                </p>

                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Courses with officially published results
                </p>
            </div>

            {{-- Total credit units --}}
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Total Credit Units
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                    {{ number_format($totalCredits, 1) }}
                </p>

                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Credits from published results
                </p>
            </div>

            {{-- CGPA --}}
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Cumulative GPA (CGPA)
                </p>

                <p class="mt-2 text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                    {{ $gpa !== null ? number_format($gpa, 2) : '—' }}
                </p>

                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Based on all published results
                </p>
            </div>

            {{-- Semesters --}}
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Semesters Completed
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $semesterResults->count() }}
                </p>

                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Semesters with published results
                </p>
            </div>

        </div>

        {{-- Semester performance --}}
        @if ($semesterResults->count())
            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">

                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Semester Performance
                    </h3>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Your GPA, credit units and quality points for each semester with published results.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Academic Period
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Credit Units
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Quality Points
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Semester GPA
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">

                            @foreach ($semesterResults as $semesterId => $semesterEnrollments)
                                @php
                                    $semester = $semesterEnrollments->first()->semester;
                                    $semesterSummary = $semesterGpas->get($semesterId);
                                @endphp

                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">

                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900 dark:text-white">
                                            {{ $semester?->academicYear?->name ?? 'Academic Year' }}
                                        </div>

                                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $semester?->name ?? 'Semester' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center text-sm text-gray-700 dark:text-gray-300">
                                        {{ number_format((float) ($semesterSummary['credits'] ?? 0), 1) }}
                                    </td>

                                    <td class="px-6 py-4 text-center text-sm text-gray-700 dark:text-gray-300">
                                        {{ number_format((float) ($semesterSummary['quality_points'] ?? 0), 2) }}
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex rounded-full bg-indigo-100 px-3 py-1 text-sm font-bold text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">
                                            {{ isset($semesterSummary['gpa']) && $semesterSummary['gpa'] !== null
                                                ? number_format($semesterSummary['gpa'], 2)
                                                : '—' }}
                                        </span>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- Published course results --}}
        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">

            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-700">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Published Course Results
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Only officially approved and published academic results are displayed.
                        </p>
                    </div>

                    @if ($results->count())
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ $results->count() }}
                            {{ $results->count() === 1 ? 'result' : 'results' }}
                        </span>
                    @endif

                </div>
            </div>

            @if ($enrollments->count())

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Course
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Academic Period
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Credits
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Total Mark
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Grade
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Grade Point
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Status
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Action
                                </th>

                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">

                            @foreach ($enrollments as $enrollment)

                                @php
                                    $result = $enrollment->result;
                                @endphp

                                @if ($result)

                                    <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-700/50">

                                        {{-- Course --}}
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-gray-900 dark:text-white">
                                                {{ $enrollment->course?->code ?? 'N/A' }}
                                            </div>

                                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $enrollment->course?->name ?? 'Course name unavailable' }}
                                            </div>

                                            @if ($enrollment->course?->department)
                                                <div class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                                    {{ $enrollment->course->department->name }}
                                                </div>
                                            @endif
                                        </td>

                                        {{-- Academic period --}}
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $enrollment->semester?->academicYear?->name ?? 'N/A' }}
                                            </div>

                                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                {{ $enrollment->semester?->name ?? 'N/A' }}
                                            </div>
                                        </td>

                                        {{-- Credits --}}
                                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-700 dark:text-gray-300">
                                            {{ number_format((float) $result->credit_units, 1) }}
                                        </td>

                                        {{-- Total mark --}}
                                        <td class="whitespace-nowrap px-6 py-4 text-center font-semibold text-gray-900 dark:text-white">
                                            {{ number_format((float) $result->total_mark, 2) }}
                                        </td>

                                        {{-- Grade --}}
                                        <td class="whitespace-nowrap px-6 py-4 text-center">

                                            @if ($result->grade)
                                                <span class="inline-flex min-w-12 justify-center rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                    {{ $result->grade }}
                                                </span>
                                            @else
                                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                                    —
                                                </span>
                                            @endif

                                        </td>

                                        {{-- Grade point --}}
                                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $result->grade_point !== null
                                                ? number_format((float) $result->grade_point, 2)
                                                : '—' }}
                                        </td>

                                        {{-- Status --}}
                                        <td class="whitespace-nowrap px-6 py-4 text-center">

                                            <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                Published
                                            </span>

                                        </td>

                                        {{-- Action --}}
                                        <td class="whitespace-nowrap px-6 py-4 text-center">

                                            <a
                                                href="{{ route('student.results.show', $enrollment) }}"
                                                class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                                            >
                                                View Result
                                            </a>

                                        </td>

                                    </tr>

                                @endif

                            @endforeach

                        </tbody>
                    </table>
                </div>

            @else

                <div class="px-6 py-14 text-center">

                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
                        <svg
                            class="h-6 w-6 text-gray-500 dark:text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9v10a2 2 0 01-2 2z"
                            />
                        </svg>
                    </div>

                    <h4 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">
                        No Published Results
                    </h4>

                    <p class="mx-auto mt-2 max-w-md text-sm text-gray-500 dark:text-gray-400">
                        Your academic results will appear here after they have been reviewed, approved and officially published by the institution.
                    </p>

                </div>

            @endif

        </div>

        {{-- Academic records notice --}}
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
                        Academic Record Information
                    </h4>

                    <p class="mt-1 text-sm text-indigo-800 dark:text-indigo-400">
                        The academic information displayed on this page is based only on results that have completed the institutional approval and publication process.
                    </p>
                </div>

            </div>

        </div>

    </div>
</div>

</x-app-layout>
