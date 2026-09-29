<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Academic Year Details
            </h2>

            <div class="flex gap-2">
                <a
                    href="{{ route('admin.academic-years.edit', $academicYear) }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition"
                >
                    Edit Academic Year
                </a>

                <a
                    href="{{ route('admin.academic-years.index') }}"
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
                                    Academic Year
                                </p>

                                <h1 class="mt-1 text-3xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ $academicYear->name }}
                                </h1>
                            </div>

                            <div>

                                @if ($academicYear->is_current)
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Current
                                    </span>
                                @elseif ($academicYear->is_active)
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
                                Start Year
                            </p>

                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                                {{ $academicYear->start_year }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                End Year
                            </p>

                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                                {{ $academicYear->end_year }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                Start Date
                            </p>

                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                                {{ $academicYear->start_date?->format('d M Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                End Date
                            </p>

                            <p class="mt-1 text-base text-gray-900 dark:text-gray-100">
                                {{ $academicYear->end_date?->format('d M Y') }}
                            </p>
                        </div>

                    </div>

                    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2">

                        <div class="rounded-lg bg-gray-50 dark:bg-gray-700 p-5">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-300">
                                Semesters
                            </p>

                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $academicYear->semesters_count }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-gray-50 dark:bg-gray-700 p-5">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-300">
                                Students Linked
                            </p>

                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $academicYear->students_count }}
                            </p>
                        </div>

                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">

                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Record Information
                        </h3>

                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Created
                                </p>

                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $academicYear->created_at?->format('d M Y, H:i') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Last Updated
                                </p>

                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $academicYear->updated_at?->format('d M Y, H:i') }}
                                </p>
                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>