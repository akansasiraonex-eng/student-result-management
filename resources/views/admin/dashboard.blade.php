<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Administrator Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    Student Result Management System
                </h1>

                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Welcome to the central administration dashboard.
                    Monitor and manage the academic system from one place.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Total Students
                        </p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $statistics['students'] }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Total Lecturers
                        </p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $statistics['lecturers'] }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Total Courses
                        </p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $statistics['courses'] }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Departments
                        </p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $statistics['departments'] }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Programs
                        </p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $statistics['programs'] }}
                        </p>
                    </div>
                </div>

                 <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Courses
                        </p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                           {{ $statistics['courses'] }}
                        </p>
                        <a href="{{ route('admin.courses.index') }}">
                          Manage Courses
                         </a>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    Course Assignments
                </h3>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Assign lecturers to courses for academic semesters.
                </p>
            </div>

            <div class="text-3xl font-bold text-indigo-600">
                {{ \App\Models\CourseAssignment::count() }}
            </div>
        </div>

        <div class="mt-4">
            <a
                href="{{ route('admin.course-assignments.index') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-blue text-sm font-semibold rounded-md hover:bg-indigo-700"
            >
                Manage Assignments
            </a>
        </div>
    </div>
</div>


                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Academic Years
                        </p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $statistics['academic_years'] }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Semesters
                        </p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $statistics['semesters'] }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    Semesters
                </h3>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Manage academic semesters and current semester status.
                </p>
            </div>

            <div class="text-3xl font-bold text-indigo-600">
                {{ \App\Models\Semester::count() }}
            </div>
        </div>

        <div class="mt-4">
            <a
                href="{{ route('admin.semesters.index') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-blue text-sm font-semibold rounded-md hover:bg-indigo-700"
            >
                Manage Semesters
            </a>
        </div>
    </div>
</div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Results
                        </p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $statistics['results'] }}
                        </p>
                    </div>
                </div>

            </div>

            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        System Overview
                    </h3>

                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        The dashboard is connected to the academic database.
                        As students, lecturers, courses, programs and results
                        are added, these statistics will update automatically.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>