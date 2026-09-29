<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Academic Year Management
            </h2>

            <a
                href="{{ route('admin.academic-years.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition"
            >
                Add Academic Year
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-lg bg-green-100 border border-green-200 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-lg bg-red-100 border border-red-200 px-4 py-3 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Academic Year
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Period
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Start Date
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        End Date
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status
                                    </th>

                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">

                                @forelse ($academicYears as $academicYear)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $academicYear->name }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                            {{ $academicYear->start_year }} / {{ $academicYear->end_year }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                            {{ $academicYear->start_date?->format('d M Y') }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                            {{ $academicYear->end_date?->format('d M Y') }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">

                                            @if ($academicYear->is_current)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    Current
                                                </span>
                                            @elseif ($academicYear->is_active)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    Inactive
                                                </span>
                                            @endif

                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                                            <a
                                                href="{{ route('admin.academic-years.show', $academicYear) }}"
                                                class="text-blue-600 hover:text-blue-900 mr-3"
                                            >
                                                View
                                            </a>

                                            <a
                                                href="{{ route('admin.academic-years.edit', $academicYear) }}"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('admin.academic-years.destroy', $academicYear) }}"
                                                method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this academic year?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="text-red-600 hover:text-red-900"
                                                >
                                                    Delete
                                                </button>
                                            </form>

                                        </td>

                                    </tr>
                                @empty

                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">

                                            <div class="text-gray-500 dark:text-gray-400">
                                                <p class="text-lg font-medium">
                                                    No academic years have been registered yet.
                                                </p>

                                                <p class="mt-2 text-sm">
                                                    Create an academic year to begin managing semesters and academic records.
                                                </p>
                                            </div>

                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>
                    </div>

                    @if ($academicYears->hasPages())
                        <div class="mt-6">
                            {{ $academicYears->links() }}
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>