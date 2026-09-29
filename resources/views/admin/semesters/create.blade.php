<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Add Semester
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if ($errors->any())
                        <div class="mb-6 rounded-lg bg-red-100 border border-red-300 text-red-800 px-4 py-3">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.semesters.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="md:col-span-2">
                                <label
                                    for="academic_year_id"
                                    class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                                >
                                    Academic Year
                                </label>

                                <select
                                    id="academic_year_id"
                                    name="academic_year_id"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                >
                                    <option value="">Select Academic Year</option>

                                    @foreach ($academicYears as $academicYear)
                                        <option
                                            value="{{ $academicYear->id }}"
                                            {{ old('academic_year_id') == $academicYear->id ? 'selected' : '' }}
                                        >
                                            {{ $academicYear->name }}
                                            ({{ $academicYear->start_year }} - {{ $academicYear->end_year }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label
                                    for="name"
                                    class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                                >
                                    Semester Name
                                </label>

                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="e.g. Semester One"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 w-full"
                                >
                            </div>

                            <div>
                                <label
                                    for="semester_number"
                                    class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                                >
                                    Semester Number
                                </label>

                                <select
                                    id="semester_number"
                                    name="semester_number"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                >
                                    <option value="">Select Number</option>
                                    <option value="1" {{ old('semester_number') == 1 ? 'selected' : '' }}>
                                        1
                                    </option>
                                    <option value="2" {{ old('semester_number') == 2 ? 'selected' : '' }}>
                                        2
                                    </option>
                                    <option value="3" {{ old('semester_number') == 3 ? 'selected' : '' }}>
                                        3
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label
                                    for="start_date"
                                    class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                                >
                                    Start Date
                                </label>

                                <input
                                    id="start_date"
                                    type="date"
                                    name="start_date"
                                    value="{{ old('start_date') }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 w-full"
                                >
                            </div>

                            <div>
                                <label
                                    for="end_date"
                                    class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                                >
                                    End Date
                                </label>

                                <input
                                    id="end_date"
                                    type="date"
                                    name="end_date"
                                    value="{{ old('end_date') }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 w-full"
                                >
                            </div>

                            <div class="md:col-span-2 space-y-4">

                                <label class="flex items-center">
                                    <input
                                        type="checkbox"
                                        name="is_current"
                                        value="1"
                                        {{ old('is_current') ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    >

                                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                                        Set as current semester
                                    </span>
                                </label>

                                <label class="flex items-center">
                                    <input
                                        type="checkbox"
                                        name="is_active"
                                        value="1"
                                        {{ old('is_active', true) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    >

                                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                                        Active
                                    </span>
                                </label>

                            </div>
                        </div>

                        <div class="mt-8 flex items-center gap-4">
                            <a
                                href="{{ route('admin.semesters.index') }}"
                                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600"
                            >
                                Cancel
                            </a>

                           <button
                        type="submit"
                        class="px-4 py-2 bg-indigo-600 text-blue rounded-md hover:bg-indigo-700"
                    >
                        Create Semester
                    </button>
                           </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>