<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Course Assignments
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Manage lecturers assigned to courses for each academic semester.
                </p>
            </div>

            <a
                href="{{ route('admin.course-assignments.create') }}"
                class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-semibold text-sm rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition"
            >
                + Assign Course
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200">
                    <ul class="list-disc list-inside text-sm text-red-800">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    @if ($assignments->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                            Course
                                        </th>

                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                            Lecturer
                                        </th>

                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                            Academic Year
                                        </th>

                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                            Semester
                                        </th>

                                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                            Primary
                                        </th>

                                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                            Status
                                        </th>

                                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">

                                    @foreach ($assignments as $assignment)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">

                                            {{-- Course --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $assignment->course->code }}
                                                </div>

                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $assignment->course->name }}
                                                </div>
                                            </td>

                                            {{-- Lecturer --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $assignment->lecturer->title }}
                                                    {{ $assignment->lecturer->first_name }}
                                                    {{ $assignment->lecturer->middle_name }}
                                                    {{ $assignment->lecturer->last_name }}
                                                </div>

                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $assignment->lecturer->staff_number }}
                                                </div>
                                            </td>

                                            {{-- Academic Year --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                {{ $assignment->semester->academicYear->name }}
                                            </td>

                                            {{-- Semester --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm text-gray-700 dark:text-gray-300">
                                                    {{ $assignment->semester->name }}
                                                </span>

                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    Semester {{ $assignment->semester->semester_number }}
                                                </div>
                                            </td>

                                            {{-- Primary --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if ($assignment->is_primary)
                                                    <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                        Primary
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                                                        Assistant
                                                    </span>
                                                @endif
                                            </td>

                                            {{-- Status --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if ($assignment->is_active)
                                                    <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Active
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Inactive
                                                    </span>
                                                @endif
                                            </td>

                                            {{-- Actions --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">

                                                <a
                                                    href="{{ route('admin.course-assignments.show', $assignment) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 font-medium mr-3"
                                                >
                                                    View
                                                </a>

                                                <a
                                                    href="{{ route('admin.course-assignments.edit', $assignment) }}"
                                                    class="text-blue-600 hover:text-blue-900 font-medium mr-3"
                                                >
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('admin.course-assignments.destroy', $assignment) }}"
                                                    method="POST"
                                                    class="inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this course assignment?');"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="text-red-600 hover:text-red-900 font-medium"
                                                    >
                                                        Delete
                                                    </button>
                                                </form>

                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-6">
                            {{ $assignments->links() }}
                        </div>

                    @else

                        <div class="text-center py-12">

                            <div class="text-gray-400 dark:text-gray-500 text-5xl mb-4">
                                📚
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                No Course Assignments
                            </h3>

                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                No lecturers have been assigned to courses yet.
                            </p>

                            <div class="mt-6">
                                <a
                                    href="{{ route('admin.course-assignments.create') }}"
                                    class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-blue font-semibold text-sm rounded-md shadow-sm hover:bg-indigo-700 transition"
                                >
                                    Assign the First Course
                                </a>
                            </div>

                        </div>

                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>