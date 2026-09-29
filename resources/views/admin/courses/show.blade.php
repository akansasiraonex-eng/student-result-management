<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Course Details
            </h2>

            <div class="flex gap-2">
                <a
                    href="{{ route('admin.courses.edit', $course) }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition"
                >
                    Edit Course
                </a>

                <a
                    href="{{ route('admin.courses.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 transition"
                >
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                        <div class="flex items-start justify-between gap-6">

                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Course Code
                                </p>

                                <h1 class="mt-1 text-3xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ $course->code }}
                                </h1>

                                <p class="mt-2 text-lg text-gray-700 dark:text-gray-300">
                                    {{ $course->name }}
                                </p>
                            </div>

                            <div>
                                @if ($course->is_active)
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Inactive
                                    </span>
                                @endif
                            </div>

                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2">

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Department
                            </p>

                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                                {{ $course->department->name }}
                                ({{ $course->department->code }})
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Credit Units
                            </p>

                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                                {{ $course->credit_units }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Course Type
                            </p>

                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                                {{ ucfirst($course->course_type) }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Year of Study
                            </p>

                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                                Year {{ $course->year_of_study }}
                            </p>
                        </div>

                        <div class="sm:col-span-2">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Description
                            </p>

                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                                {{ $course->description ?: 'No description has been provided for this course.' }}
                            </p>
                        </div>

                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Course Record
                        </h3>

                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Created
                                </p>

                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $course->created_at?->format('d M Y, H:i') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Last Updated
                                </p>

                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $course->updated_at?->format('d M Y, H:i') }}
                                </p>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>