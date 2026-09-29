<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Finance Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    Finance Portal
                </h1>

                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Monitor student populations and financial information
                    from the finance management portal.
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
                            Active Students
                        </p>

                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $statistics['active_students'] }}
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
                        Finance Workspace
                    </h3>

                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Financial management features such as student fees,
                        invoices, payments, receipts, outstanding balances and
                        financial reports will be implemented in the financial
                        management stage.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>