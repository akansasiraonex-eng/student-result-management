<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Review Student Result
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Review the submitted result before taking an approval action.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6 lg:px-8">

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

            {{-- Result Header --}}
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $result->courseEnrollment->student->first_name }}
                            {{ $result->courseEnrollment->student->last_name }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ $result->courseEnrollment->student->student_number }}
                        </p>
                    </div>

                    <span class="inline-flex w-fit rounded-full bg-yellow-100 px-3 py-1 text-sm font-semibold text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                        {{ ucfirst($result->status) }}
                    </span>
                </div>
            </div>

            {{-- Student and Course Information --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                        Student Information
                    </h3>

                    <dl class="space-y-3">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Student Number
                            </dt>

                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $result->courseEnrollment->student->student_number }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Registration Number
                            </dt>

                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $result->courseEnrollment->student->registration_number }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Programme
                            </dt>

                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $result->courseEnrollment->student->program->name }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Department
                            </dt>

                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $result->courseEnrollment->student->program->department->name }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                        Course Information
                    </h3>

                    <dl class="space-y-3">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Course Code
                            </dt>

                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $result->courseEnrollment->course->code }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Course Name
                            </dt>

                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $result->courseEnrollment->course->name }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Credit Units
                            </dt>

                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ number_format((float) $result->credit_units, 1) }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Semester
                            </dt>

                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $result->courseEnrollment->semester->academicYear->name }}
                                —
                                {{ $result->courseEnrollment->semester->name }}
                            </dd>
                        </div>
                    </dl>
                </div>

            </div>

            {{-- Marks --}}
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <h3 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">
                    Result Details
                </h3>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                    <div class="rounded-lg bg-gray-50 p-5 dark:bg-gray-900/50">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Coursework
                        </p>

                        <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                            {{ number_format((float) $result->coursework_mark, 2) }}
                            <span class="text-sm font-normal text-gray-500">/ 40</span>
                        </p>
                    </div>

                    <div class="rounded-lg bg-gray-50 p-5 dark:bg-gray-900/50">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Final Examination
                        </p>

                        <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                            {{ number_format((float) $result->final_exam_mark, 2) }}
                            <span class="text-sm font-normal text-gray-500">/ 60</span>
                        </p>
                    </div>

                    <div class="rounded-lg bg-indigo-50 p-5 dark:bg-indigo-900/20">
                        <p class="text-sm text-indigo-600 dark:text-indigo-400">
                            Total Mark
                        </p>

                        <p class="mt-2 text-3xl font-bold text-indigo-700 dark:text-indigo-300">
                            {{ number_format((float) $result->total_mark, 2) }}
                            <span class="text-sm font-normal text-gray-500">/ 100</span>
                        </p>
                    </div>

                </div>

                <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Grade
                        </p>

                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $result->grade ?? 'Not yet calculated' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Grade Point
                        </p>

                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $result->grade_point !== null ? number_format((float) $result->grade_point, 2) : 'Not yet calculated' }}
                        </p>
                    </div>

                </div>

                @if ($result->remarks)
                    <div class="mt-6 rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Lecturer Remarks
                        </p>

                        <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                            {{ $result->remarks }}
                        </p>
                    </div>
                @endif
            </div>

            {{-- Submission Information --}}
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                    Submission Information
                </h3>

                <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Entered By
                        </dt>

                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $result->enteredBy?->name ?? 'Unknown' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Submitted At
                        </dt>

                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $result->submitted_at?->format('d M Y, H:i') ?? '—' }}
                        </dd>
                    </div>

                </dl>
            </div>

            {{-- Approval Actions --}}
            @if ($result->status === 'submitted')
                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">

                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Approval Action
                    </h3>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Choose the appropriate action after reviewing the student's result.
                    </p>

                    <div class="mt-6 space-y-6">

                        {{-- Approve --}}
                        <form
                            method="POST"
                            action="{{ route('registrar.result-approvals.approve', $result) }}"
                        >
                            @csrf

                            <label
                                for="approve_comments"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Approval Comments
                            </label>

                            <textarea
                                id="approve_comments"
                                name="comments"
                                rows="3"
                                class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                placeholder="Optional approval comments..."
                            ></textarea>

                            <button
                                type="submit"
                                class="mt-3 inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-Green transition hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                                onclick="return confirm('Are you sure you want to approve this result?');"
                            >
                                Approve Result
                            </button>
                        </form>

                        {{-- Reject --}}
                        <form
                            method="POST"
                            action="{{ route('registrar.result-approvals.reject', $result) }}"
                            class="border-t border-gray-200 pt-6 dark:border-gray-700"
                        >
                            @csrf

                            <label
                                for="reject_comments"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Rejection Reason
                            </label>

                            <textarea
                                id="reject_comments"
                                name="comments"
                                rows="3"
                                required
                                class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                placeholder="Explain why this result is being rejected..."
                            ></textarea>

                            <button
                                type="submit"
                                class="mt-3 inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-blue transition hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                onclick="return confirm('Are you sure you want to reject this result?');"
                            >
                                Reject Result
                            </button>
                        </form>

                        {{-- Return --}}
                        <form
                            method="POST"
                            action="{{ route('registrar.result-approvals.return', $result) }}"
                            class="border-t border-gray-200 pt-6 dark:border-gray-700"
                        >
                            @csrf

                            <label
                                for="return_comments"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Correction Instructions
                            </label>

                            <textarea
                                id="return_comments"
                                name="comments"
                                rows="3"
                                required
                                class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                placeholder="Tell the lecturer what needs to be corrected..."
                            ></textarea>

                            <button
                                type="submit"
                                class="mt-3 inline-flex items-center rounded-md bg-yellow-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-blue transition hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2"
                                onclick="return confirm('Are you sure you want to return this result to the lecturer?');"
                            >
                                Return to Lecturer
                            </button>
                        </form>

                    </div>
                </div>
            @endif
                 
             @if ($result->status === 'approved')
    <div class="mt-6 border-t pt-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            Publish Result
        </h3>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Publishing makes this approved result available for the student portal.
        </p>

        <form
            method="POST"
            action="{{ route('registrar.result-approvals.publish', $result) }}"
            class="mt-4"
            onsubmit="return confirm('Are you sure you want to publish this approved result? Once published, it will become available to the student.');"
        >
            @csrf

            <button
                type="submit"
                class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-blue shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
            >
                Publish Result
            </button>
        </form>
    </div>
@endif

            {{-- Approval History --}}
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Approval History
                </h3>

                @if ($result->approvals->count())
                    <div class="mt-5 space-y-4">
                        @foreach ($result->approvals->sortByDesc('action_at') as $approval)
                            <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                                    <div>
                                        <p class="font-semibold capitalize text-gray-900 dark:text-white">
                                            {{ $approval->action }}
                                        </p>

                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $approval->approvedBy?->name ?? 'Unknown user' }}
                                        </p>
                                    </div>

                                    <p class="text-sm text-blue-500 dark:text-gray-400">
                                        {{ $approval->action_at?->format('d M Y, H:i') }}
                                    </p>

                                </div>

                                @if ($approval->comments)
                                    <p class="mt-3 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $approval->comments }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                        No approval actions have been recorded yet.
                    </p>
                @endif
            </div>

            <div>
                <a
                    href="{{ route('registrar.result-approvals.index') }}"
                    class="inline-flex items-center rounded-md bg-gray-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-blue transition hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                >
                    Back to Approval Queue
                </a>
            </div>

        </div>
    </div>
</x-app-layout>