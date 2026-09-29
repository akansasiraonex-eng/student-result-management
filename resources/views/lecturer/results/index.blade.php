<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Lecturer Results
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    View and manage results for your assigned courses.
                </p>
            </div>

            <a href="{{ route('lecturer.results.create') }}"
               class="inline-flex items-center px-4 py-2
                      bg-indigo-600 text-white rounded-md
                      font-semibold text-xs uppercase tracking-widest
                      hover:bg-indigo-700">
                Enter Result
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/20
                            border border-green-200 dark:border-green-800
                            rounded-lg p-4 text-green-800
                            dark:text-green-300">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/20
                            border border-red-200 dark:border-red-800
                            rounded-lg p-4 text-red-800
                            dark:text-red-300">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 dark:bg-red-900/20
                            border border-red-200 dark:border-red-800
                            rounded-lg p-4">

                    <ul class="list-disc list-inside text-sm
                               text-red-700 dark:text-red-300">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <div class="bg-white dark:bg-gray-800
                            overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Total Results
                        </p>

                        <p class="mt-2 text-3xl font-bold
                                  text-gray-900 dark:text-gray-100">
                            {{ $results->total() }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800
                            overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Current Page
                        </p>

                        <p class="mt-2 text-3xl font-bold
                                  text-gray-900 dark:text-gray-100">
                            {{ $results->count() }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800
                            overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Records Per Page
                        </p>

                        <p class="mt-2 text-3xl font-bold
                                  text-gray-900 dark:text-gray-100">
                            10
                        </p>
                    </div>
                </div>

            </div>

            <div class="bg-white dark:bg-gray-800
                        overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y
                                      divide-gray-200
                                      dark:divide-gray-700">

                            <thead>
                                <tr>

                                    <th class="px-6 py-3 text-left text-xs
                                               font-medium text-gray-500
                                               dark:text-gray-400 uppercase
                                               tracking-wider">
                                        Student
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs
                                               font-medium text-gray-500
                                               dark:text-gray-400 uppercase
                                               tracking-wider">
                                        Course
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs
                                               font-medium text-gray-500
                                               dark:text-gray-400 uppercase
                                               tracking-wider">
                                        Semester
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs
                                               font-medium text-gray-500
                                               dark:text-gray-400 uppercase
                                               tracking-wider">
                                        Total
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs
                                               font-medium text-gray-500
                                               dark:text-gray-400 uppercase
                                               tracking-wider">
                                        Status
                                    </th>

                                    <th class="px-6 py-3 text-right text-xs
                                               font-medium text-gray-500
                                               dark:text-gray-400 uppercase
                                               tracking-wider">
                                        Actions
                                    </th>

                                </tr>
                            </thead>

                            <tbody class="divide-y
                                          divide-gray-200
                                          dark:divide-gray-700">

                                @forelse ($results as $result)

                                    <tr class="hover:bg-gray-50
                                               dark:hover:bg-gray-700/50">

                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <div class="text-sm font-medium
                                                        text-gray-900
                                                        dark:text-gray-100">

                                                {{ $result->courseEnrollment->student->first_name }}
                                                {{ $result->courseEnrollment->student->middle_name }}
                                                {{ $result->courseEnrollment->student->last_name }}

                                            </div>

                                            <div class="text-xs text-gray-500
                                                        dark:text-gray-400">

                                                {{ $result->courseEnrollment->student->student_number }}

                                            </div>

                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <div class="text-sm font-medium
                                                        text-gray-900
                                                        dark:text-gray-100">

                                                {{ $result->courseEnrollment->course->code }}

                                            </div>

                                            <div class="text-xs text-gray-500
                                                        dark:text-gray-400">

                                                {{ $result->courseEnrollment->course->name }}

                                            </div>

                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <div class="text-sm text-gray-900
                                                        dark:text-gray-100">

                                                {{ $result->courseEnrollment->semester->academicYear->name }}

                                            </div>

                                            <div class="text-xs text-gray-500
                                                        dark:text-gray-400">

                                                {{ $result->courseEnrollment->semester->name }}

                                            </div>

                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <span class="text-sm font-semibold
                                                         text-gray-900
                                                         dark:text-gray-100">

                                                {{ number_format((float) $result->total_mark, 2) }}

                                            </span>

                                            <span class="text-xs text-gray-500">
                                                / 100
                                            </span>

                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">

                                            @php
                                                $statusClasses = [
                                                    'draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
                                                    'submitted' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                                    'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                                    'published' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                                    'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                                ];

                                                $statusClass = $statusClasses[$result->status]
                                                    ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200';
                                            @endphp

                                            <span class="inline-flex px-2.5 py-1
                                                         rounded-full text-xs
                                                         font-semibold
                                                         {{ $statusClass }}">
                                                {{ ucfirst($result->status) }}
                                            </span>

                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap
                                                   text-right text-sm">

                                            <div class="flex justify-end gap-2">

                                                <a href="{{ route('lecturer.results.show', $result) }}"
                                                   class="inline-flex items-center
                                                          px-3 py-1.5
                                                          bg-gray-200
                                                          dark:bg-gray-700
                                                          text-gray-700
                                                          dark:text-gray-200
                                                          rounded-md text-xs
                                                          font-semibold
                                                          hover:bg-gray-300
                                                          dark:hover:bg-gray-600">
                                                    View
                                                </a>

                                                @if (in_array($result->status, ['draft', 'submitted']))
                                                    <a href="{{ route('lecturer.results.edit', $result) }}"
                                                       class="inline-flex items-center
                                                              px-3 py-1.5
                                                              bg-indigo-600
                                                              text-blue rounded-md
                                                              text-xs font-semibold
                                                              hover:bg-indigo-700">
                                                        Edit
                                                    </a>
                                                @endif

                                                @if ($result->status === 'draft')
                                                    <form method="POST"
                                                          action="{{ route('lecturer.results.destroy', $result) }}"
                                                          onsubmit="return confirm('Are you sure you want to delete this draft result?');">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                                class="inline-flex items-center
                                                                       px-3 py-1.5
                                                                       bg-red-600
                                                                       text-blue rounded-md
                                                                       text-xs font-semibold
                                                                       hover:bg-red-700">
                                                            Delete
                                                        </button>

                                                    </form>
                                                @endif

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="6"
                                            class="px-6 py-12 text-center">

                                            <div class="text-gray-500
                                                        dark:text-gray-400">

                                                <p class="text-lg font-semibold">
                                                    No Results Found
                                                </p>

                                                <p class="mt-2 text-sm">
                                                    No results have been entered
                                                    for your assigned courses yet.
                                                </p>

                                                <a href="{{ route('lecturer.results.create') }}"
                                                   class="inline-flex items-center
                                                          mt-4 px-4 py-2
                                                          bg-indigo-600
                                                          text-blue rounded-md
                                                          font-semibold text-xs
                                                          uppercase
                                                          tracking-widest
                                                          hover:bg-indigo-700">
                                                    Enter First Result
                                                </a>

                                            </div>

                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    @if ($results->hasPages())
                        <div class="mt-6">
                            {{ $results->links() }}
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>