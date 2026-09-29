<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Academic Year
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('admin.academic-years.update', $academicYear) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                            <div class="sm:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Academic Year Name
                                </label>

                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name', $academicYear->name) }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >

                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="start_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Start Year
                                </label>

                                <input
                                    id="start_year"
                                    name="start_year"
                                    type="number"
                                    min="2000"
                                    max="2100"
                                    value="{{ old('start_year', $academicYear->start_year) }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >

                                @error('start_year')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="end_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    End Year
                                </label>

                                <input
                                    id="end_year"
                                    name="end_year"
                                    type="number"
                                    min="2000"
                                    max="2100"
                                    value="{{ old('end_year', $academicYear->end_year) }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:text-gray-100 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >

                                @error('end_year')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Start Date
                                </label>

                                <input
                                    id="start_date"
                                    name="start_date"
                                    type="date"
                                    value="{{ old('start_date', $academicYear->start_date?->format('Y-m-d')) }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:text-gray-100 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >

                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    End Date
                                </label>

                                <input
                                    id="end_date"
                                    name="end_date"
                                    type="date"
                                    value="{{ old('end_date', $academicYear->end_date?->format('Y-m-d')) }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:text-gray-100 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >

                                @error('end_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">

                                <label class="inline-flex items-center">
                                    <input
                                        type="checkbox"
                                        name="is_current"
                                        value="1"
                                        {{ old('is_current', $academicYear->is_current) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    >

                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Set as current academic year
                                    </span>
                                </label>

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Only one academic year should normally be marked as current.
                                </p>

                                @error('is_current')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                            </div>

                            <div class="sm:col-span-2">

                                <label class="inline-flex items-center">
                                    <input
                                        type="checkbox"
                                        name="is_active"
                                        value="1"
                                        {{ old('is_active', $academicYear->is_active) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    >

                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Active
                                    </span>
                                </label>

                                @error('is_active')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                            </div>

                        </div>

                        <div class="mt-8 flex items-center justify-end gap-3">

                            <a
                                href="{{ route('admin.academic-years.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 transition"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition"
                            >
                                Update Academic Year
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>