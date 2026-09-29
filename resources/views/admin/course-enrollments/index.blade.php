<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Course Enrollments
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Manage students enrolled in courses for each academic semester.
                </p>
            </div>

            <a
                href="{{ route('admin.course-enrollments.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                Add Enrollment
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success message --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-800 rounded-lg dark:bg-green-900/30 dark:border-green-800 dark:text-green-300">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error message --}}
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-800 rounded-lg dark:bg-red-900/30 dark:border-red-800 dark:text-red-300">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-800 rounded-lg dark:bg-red-900/30 dark:border-red-800 dark:text-red-300">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- Page heading --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Enrollment Records
                        </h3>

                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            A complete list of students registered for courses.
                        </p>
                    </div>

                    @if ($enrollments->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Student
                                        </th>

                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Course
                                        </th>

                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Semester
                                        </th>

                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status
                                        </th>

                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Enrolled At
                                        </th>

                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($enrollments as $enrollment)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">

                                            {{-- Student --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $enrollment->student->first_name }}
                                                    {{ $enrollment->student->middle_name }}
                                                    {{ $enrollment->student->last_name }}
                                                </div>

                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $enrollment->student->student_number }}
                                                </div>
                                            </td>

                                            {{-- Course --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $enrollment->course->code }}
                                                </div>

                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $enrollment->course->name }}
                                                </div>
                                            </td>

                                            {{-- Semester --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $enrollment->semester->academicYear->name }}
                                                </div>

                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $enrollment->semester->name }}
                                                </div>
                                            </td>

                                            {{-- Status --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusClasses = match ($enrollment->status) {
                                                        'enrolled' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                                        'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                                        'dropped' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                                        'withdrawn' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                                        'deferred' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
                                                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                                    };
                                                @endphp

                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusClasses }}">
                                                    {{ ucfirst($enrollment->status) }}
                                                </span>
                                            </td>

                                            {{-- Enrolled date --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                                {{ $enrollment->enrolled_at?->format('d M Y, H:i') ?? 'Not recorded' }}
                                            </td>

                                            {{-- Actions --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end gap-2">

                                                    <a
                                                        href="{{ route('admin.course-enrollments.show', $enrollment) }}"
                                                        class="inline-flex items-center px-3 py-1.5 bg-gray-600 text-white rounded-md hover:bg-gray-700"
                                                    >
                                                        View
                                                    </a>

                                                    <a
                                                        href="{{ route('admin.course-enrollments.edit', $enrollment) }}"
                                                        class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-blue rounded-md hover:bg-indigo-700"
                                                    >
                                                        Edit
                                                    </a>

                                                    <form
                                                        action="{{ route('admin.course-enrollments.destroy', $enrollment) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this enrollment?');"
                                                    >
                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="inline-flex items-center px-3 py-1.5 bg-red-600 text-blue rounded-md hover:bg-red-700"
                                                        >
                                                            Delete
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-6">
                            {{ $enrollments->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-5xl mb-4">
                                📚
                            </div>

                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                No Enrollment Records
                            </h4>

                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                No students have been enrolled in courses yet.
                            </p>

                            <div class="mt-6">
                                <a
                                    href="{{ route('admin.course-enrollments.create') }}"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-blue rounded-md font-semibold text-sm hover:bg-indigo-700"
                                >
                                    Add First Enrollment
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>