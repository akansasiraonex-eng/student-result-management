<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Registrar Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    Registrar Portal
                </h1>

                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Manage students, academic programmes, courses and
                    examination results from this dashboard.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Students
                        </p>

                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $statistics['students'] }}
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

            </div>

            <div class="grid grid-cols-1 gap-6 mt-8 sm:grid-cols-2 lg:grid-cols-4">

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Pending Results
                        </p>

                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $statistics['pending_results'] }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Approved Results
                        </p>

                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $statistics['approved_results'] }}
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

            </div>

            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Registrar Workspace
                    </h3>

                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        The registrar will be able to manage student records,
                        academic programmes, course enrollments and examination
                        results. Result approval and publication workflows will
                        be implemented in the upcoming stages.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>