<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Result Approvals
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Review results submitted by lecturers.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/20 dark:text-green-300">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700 dark:border-red-800 dark:bg-red-900/20 dark:text-red-300">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-lg border border-red-200 bg-red-50 p-4 dark:border-red-800 dark:bg-red-900/20">
                    <ul class="list-disc space-y-1 pl-5 text-sm text-red-700 dark:text-red-300">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Awaiting Review
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $results->total() }}
                    </p>
                </div>

                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Current Page
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $results->count() }}
                    </p>
                </div>

                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Workflow
                    </p>

                    <p class="mt-2 text-lg font-bold text-indigo-600 dark:text-indigo-400">
                        Submitted → Review
                    </p>
                </div>
            </div>

            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">

                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Submitted Results
                    </h3>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        These results have been submitted by lecturers and are waiting for approval action.
                    </p>
                </div>

                @if ($results->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                        Student
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                        Course
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                        Semester
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                        Total
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                        Lecturer
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                        Submitted
                                    </th>

                                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($results as $result)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">

                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="font-medium text-gray-900 dark:text-white">
                                                {{ $result->courseEnrollment->student->first_name }}
                                                {{ $result->courseEnrollment->student->last_name }}
                                            </div>

                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $result->courseEnrollment->student->student_number }}
                                            </div>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="font-medium text-gray-900 dark:text-white">
                                                {{ $result->courseEnrollment->course->code }}
                                            </div>

                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $result->courseEnrollment->course->name }}
                                            </div>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                            {{ $result->courseEnrollment->semester->academicYear->name }}
                                            —
                                            {{ $result->courseEnrollment->semester->name }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span class="font-semibold text-gray-900 dark:text-white">
                                                {{ number_format((float) $result->total_mark, 2) }}
                                            </span>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                            {{ $result->enteredBy?->name ?? 'Unknown' }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $result->submitted_at?->format('d M Y, H:i') ?? '—' }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-right">
                                            <a
                                                href="{{ route('registrar.result-approvals.show', $result) }}"
                                                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-blue transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                            >
                                                Review
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-700">
                        {{ $results->links() }}
                    </div>
                @else
                    <div class="px-6 py-12 text-center">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            No results awaiting approval
                        </h3>

                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Submitted lecturer results will appear here when they are ready for review.
                        </p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>