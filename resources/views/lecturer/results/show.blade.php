<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Result Details
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    View the complete student result information.
                </p>
            </div>

            <a href="{{ route('lecturer.results.index') }}"
               class="inline-flex items-center px-4 py-2
                      bg-gray-200 dark:bg-gray-700
                      text-gray-700 dark:text-gray-200
                      rounded-md font-semibold text-xs uppercase
                      tracking-widest hover:bg-gray-300
                      dark:hover:bg-gray-600">
                Back to Results
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/20
                            border border-green-200 dark:border-green-800
                            rounded-lg p-4 text-green-800
                            dark:text-green-300">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/20
                            border border-red-200 dark:border-red-800
                            rounded-lg p-4 text-red-800
                            dark:text-red-300">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800
                        shadow-sm sm:rounded-lg overflow-hidden">

                <div class="p-6 border-b border-gray-200
                            dark:border-gray-700">

                    <div class="flex items-center justify-between">

                        <div>
                            <h3 class="text-lg font-semibold
                                       text-gray-900 dark:text-gray-100">
                                Result Information
                            </h3>

                            <p class="mt-1 text-sm text-gray-500
                                      dark:text-gray-400">
                                Result ID: {{ $result->id }}
                            </p>
                        </div>

                        @php
                            $statusClasses = [
                                'draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
                                'submitted' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                'published' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                            ];

                            $statusClass = $statusClasses[$result->status]
                                ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200';
                        @endphp

                        <span class="inline-flex px-3 py-1.5
                                     rounded-full text-xs font-semibold
                                     {{ $statusClass }}">
                            {{ ucfirst($result->status) }}
                        </span>

                    </div>
                </div>

                <div class="p-6">

                    <div class="grid grid-cols-1 md:grid-cols-2
                                gap-6">

                        <div>
                            <p class="text-sm text-gray-500
                                      dark:text-gray-400">
                                Student
                            </p>

                            <p class="mt-1 text-base font-semibold
                                      text-gray-900 dark:text-gray-100">

                                {{ $result->courseEnrollment->student->first_name }}
                                {{ $result->courseEnrollment->student->middle_name }}
                                {{ $result->courseEnrollment->student->last_name }}

                            </p>

                            <p class="text-sm text-gray-500
                                      dark:text-gray-400">
                                {{ $result->courseEnrollment->student->student_number }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500
                                      dark:text-gray-400">
                                Registration Number
                            </p>

                            <p class="mt-1 text-base font-semibold
                                      text-gray-900 dark:text-gray-100">

                                {{ $result->courseEnrollment->student->registration_number }}

                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500
                                      dark:text-gray-400">
                                Course
                            </p>

                            <p class="mt-1 text-base font-semibold
                                      text-gray-900 dark:text-gray-100">

                                {{ $result->courseEnrollment->course->code }}

                            </p>

                            <p class="text-sm text-gray-500
                                      dark:text-gray-400">

                                {{ $result->courseEnrollment->course->name }}

                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500
                                      dark:text-gray-400">
                                Semester
                            </p>

                            <p class="mt-1 text-base font-semibold
                                      text-gray-900 dark:text-gray-100">

                                {{ $result->courseEnrollment->semester->academicYear->name }}

                            </p>

                            <p class="text-sm text-gray-500
                                      dark:text-gray-400">

                                {{ $result->courseEnrollment->semester->name }}

                            </p>
                        </div>

                    </div>

                    <div class="mt-8">

                        <h4 class="text-base font-semibold
                                   text-gray-900 dark:text-gray-100">
                            Marks
                        </h4>

                        <div class="mt-4 grid grid-cols-1 md:grid-cols-3
                                    gap-6">

                            <div class="p-5 rounded-lg
                                        bg-gray-50 dark:bg-gray-900
                                        border border-gray-200
                                        dark:border-gray-700">

                                <p class="text-sm text-gray-500
                                          dark:text-gray-400">
                                    Coursework
                                </p>

                                <p class="mt-2 text-3xl font-bold
                                          text-gray-900 dark:text-gray-100">

                                    {{ number_format((float) $result->coursework_mark, 2) }}

                                </p>

                                <p class="text-sm text-gray-500">
                                    out of 40
                                </p>

                            </div>

                            <div class="p-5 rounded-lg
                                        bg-gray-50 dark:bg-gray-900
                                        border border-gray-200
                                        dark:border-gray-700">

                                <p class="text-sm text-gray-500
                                          dark:text-gray-400">
                                    Final Examination
                                </p>

                                <p class="mt-2 text-3xl font-bold
                                          text-gray-900 dark:text-gray-100">

                                    {{ number_format((float) $result->final_exam_mark, 2) }}

                                </p>

                                <p class="text-sm text-gray-500">
                                    out of 60
                                </p>

                            </div>

                            <div class="p-5 rounded-lg
                                        bg-indigo-50 dark:bg-indigo-900/20
                                        border border-indigo-200
                                        dark:border-indigo-800">

                                <p class="text-sm text-indigo-700
                                          dark:text-indigo-300">
                                    Total Mark
                                </p>

                                <p class="mt-2 text-3xl font-bold
                                          text-indigo-700
                                          dark:text-indigo-300">

                                    {{ number_format((float) $result->total_mark, 2) }}

                                </p>

                                <p class="text-sm text-indigo-600
                                          dark:text-indigo-400">
                                    out of 100
                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2
                                gap-6">

                        <div>
                            <p class="text-sm text-gray-500
                                      dark:text-gray-400">
                                Grade
                            </p>

                            <p class="mt-1 text-xl font-bold
                                      text-gray-900 dark:text-gray-100">

                                {{ $result->grade ?? 'Not yet calculated' }}

                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500
                                      dark:text-gray-400">
                                Grade Point
                            </p>

                            <p class="mt-1 text-xl font-bold
                                      text-gray-900 dark:text-gray-100">

                                {{ $result->grade_point !== null
                                    ? number_format((float) $result->grade_point, 2)
                                    : 'Not yet calculated' }}

                            </p>
                        </div>

                    </div>

                    @if ($result->remarks)
                        <div class="mt-8">

                            <p class="text-sm text-gray-500
                                      dark:text-gray-400">
                                Remarks
                            </p>

                            <div class="mt-2 p-4 rounded-lg
                                        bg-gray-50 dark:bg-gray-900
                                        border border-gray-200
                                        dark:border-gray-700
                                        text-gray-800
                                        dark:text-gray-200">

                                {{ $result->remarks }}

                            </div>

                        </div>
                    @endif

                    <div class="mt-8">

                        <h4 class="text-base font-semibold
                                   text-gray-900 dark:text-gray-100">
                            Result Timeline
                        </h4>

                        <div class="mt-4 space-y-3 text-sm">

                            <div class="flex justify-between
                                        border-b border-gray-200
                                        dark:border-gray-700 pb-3">

                                <span class="text-gray-500
                                             dark:text-gray-400">
                                    Entered
                                </span>

                                <span class="font-medium
                                             text-gray-900
                                             dark:text-gray-100">

                                    {{ $result->created_at?->format('d M Y, H:i') ?? '—' }}

                                </span>

                            </div>

                            <div class="flex justify-between
                                        border-b border-gray-200
                                        dark:border-gray-700 pb-3">

                                <span class="text-gray-500
                                             dark:text-gray-400">
                                    Submitted
                                </span>

                                <span class="font-medium
                                             text-gray-900
                                             dark:text-gray-100">

                                    {{ $result->submitted_at?->format('d M Y, H:i') ?? '—' }}

                                </span>

                            </div>

                            <div class="flex justify-between
                                        border-b border-gray-200
                                        dark:border-gray-700 pb-3">

                                <span class="text-gray-500
                                             dark:text-gray-400">
                                    Approved
                                </span>

                                <span class="font-medium
                                             text-gray-900
                                             dark:text-gray-100">

                                    {{ $result->approved_at?->format('d M Y, H:i') ?? '—' }}

                                </span>

                            </div>

                            <div class="flex justify-between">

                                <span class="text-gray-500
                                             dark:text-gray-400">
                                    Published
                                </span>

                                <span class="font-medium
                                             text-gray-900
                                             dark:text-gray-100">

                                    {{ $result->published_at?->format('d M Y, H:i') ?? '—' }}

                                </span>

                            </div>

                        </div>

                    </div>

                    <div class="mt-8 flex items-center justify-end gap-3">

                        @if (in_array($result->status, ['draft', 'submitted']))
                            <a href="{{ route('lecturer.results.edit', $result) }}"
                               class="inline-flex items-center px-4 py-2
                                      bg-indigo-600 text-blue rounded-md
                                      font-semibold text-xs uppercase
                                      tracking-widest
                                      hover:bg-indigo-700">
                                Edit Result
                            </a>
                        @endif

                        @if ($result->status === 'draft')
                        <form
                            method="POST"
                            action="{{ route('lecturer.results.submit', $result) }}"
                            class="inline"
                            onsubmit="return confirm('Are you sure you want to submit this result for approval? Once submitted, it cannot be edited until it is returned or rejected.');"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-blue transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            >
                                Submit for Approval
                            </button>
                        </form>
                    @endif

                        <a href="{{ route('lecturer.results.index') }}"
                           class="inline-flex items-center px-4 py-2
                                  bg-gray-200 dark:bg-gray-700
                                  text-gray-700 dark:text-gray-200
                                  rounded-md font-semibold text-xs
                                  uppercase tracking-widest
                                  hover:bg-gray-300
                                  dark:hover:bg-gray-600">
                            Back to Results
                        </a>

                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>