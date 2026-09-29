<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Semester Management
            </h2>

            <a
                href="{{ route('admin.semesters.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700"
            >
                Add Semester
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-lg bg-red-100 border border-red-300 text-red-800 px-4 py-3">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                        Academic Year
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                        Semester
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                        Period
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                        Status
                                    </th>

                                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($semesters as $semester)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-medium">
                                                {{ $semester->academicYear->name }}
                                            </div>

                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $semester->academicYear->start_year }}
                                                -
                                                {{ $semester->academicYear->end_year }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-medium">
                                                {{ $semester->name }}
                                            </div>

                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                Semester {{ $semester->semester_number }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                {{ $semester->start_date->format('d M Y') }}
                                            </div>

                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                to
                                                {{ $semester->end_date->format('d M Y') }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-wrap gap-2">
                                                @if ($semester->is_current)
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        Current
                                                    </span>
                                                @endif

                                                @if ($semester->is_active)
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Active
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Inactive
                                                    </span>
                                                @endif
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                            <a
                                                href="{{ route('admin.semesters.show', $semester) }}"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3"
                                            >
                                                View
                                            </a>

                                            <a
                                                href="{{ route('admin.semesters.edit', $semester) }}"
                                                class="text-green-600 hover:text-green-900 mr-3"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('admin.semesters.destroy', $semester) }}"
                                                method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this semester?');"
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
                                        <td
                                            colspan="5"
                                            class="px-6 py-12 text-center text-gray-500 dark:text-gray-400"
                                        >
                                            <div class="text-lg font-medium mb-2">
                                                No semesters found.
                                            </div>

                                            <p class="mb-4">
                                                Create the first semester to begin managing academic periods.
                                            </p>

                                            <a
                                                href="{{ route('admin.semesters.create') }}"
                                                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-blue rounded-md hover:bg-indigo-700"
                                            >
                                                Add Semester
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($semesters->hasPages())
                        <div class="mt-6">
                            {{ $semesters->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>