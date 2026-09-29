<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Student Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    Student Portal
                </h1>

                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    View your academic information, enrolled courses and
                    published examination results from this dashboard.
                </p>
            </div>

            <div class="mb-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Welcome, {{ $student->first_name }} {{ $student->last_name }}
                    </h3>

                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Student Number:
                        <span class="font-medium text-gray-900 dark:text-gray-200">
                            {{ $student->student_number }}
                        </span>
                    </p>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Registration Number:
                        <span class="font-medium text-gray-900 dark:text-gray-200">
                            {{ $student->registration_number }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Total Courses
                        </p>

                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $statistics['total_courses'] }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Completed Courses
                        </p>

                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $statistics['completed_courses'] }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Published Results
                        </p>

                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $statistics['published_results'] }}
                        </p>
                    </div>
                </div>

            </div>

            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Student Workspace
                    </h3>

                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Your enrolled courses, academic results, GPA and other
                        academic information will appear here as the student
                        portal is developed.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>