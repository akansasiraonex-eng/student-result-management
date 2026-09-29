<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Lecturer Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8">
                
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    Lecturer Portal
                </h1>

                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Manage your assigned courses, students and academic results
                    from this dashboard.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Assigned Courses
                        </p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $statistics['assigned_courses'] }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Enrolled Students
                        </p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $statistics['enrolled_students'] }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Draft Results
                        </p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $statistics['draft_results'] }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Submitted Results
                        </p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $statistics['submitted_results'] }}
                        </p>
                    </div>
                </div>

            </div>

            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Lecturer Workspace
                    </h3>

                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Your assigned courses and students will appear here.
                        Result entry and submission will be enabled in the
                        result management stage.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>