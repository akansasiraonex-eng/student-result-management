<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Course
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Edit Course: {{ $course->code }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Update the academic information for this course.
                        </p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-800 rounded-lg">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.courses.update', $course) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                            <div>
                                <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Department
                                </label>

                                <select
                                    id="department_id"
                                    name="department_id"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="">Select Department</option>

                                    @foreach ($departments as $department)
                                        <option
                                            value="{{ $department->id }}"
                                            {{ old('department_id', $course->department_id) == $department->id ? 'selected' : '' }}
                                        >
                                            {{ $department->name }} ({{ $department->code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Course Code
                                </label>

                                <input
                                    id="code"
                                    type="text"
                                    name="code"
                                    value="{{ old('code', $course->code) }}"
                                    required
                                    maxlength="50"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>

                            <div class="sm:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Course Name
                                </label>

                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name', $course->name) }}"
                                    required
                                    maxlength="255"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>

                            <div class="sm:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Description
                                </label>

                                <textarea
                                    id="description"
                                    name="description"
                                    rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >{{ old('description', $course->description) }}</textarea>
                            </div>

                            <div>
                                <label for="credit_units" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Credit Units
                                </label>

                                <input
                                    id="credit_units"
                                    type="number"
                                    name="credit_units"
                                    value="{{ old('credit_units', $course->credit_units) }}"
                                    min="1"
                                    max="20"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>

                            <div>
                                <label for="year_of_study" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Year of Study
                                </label>

                                <select
                                    id="year_of_study"
                                    name="year_of_study"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    @for ($year = 1; $year <= 10; $year++)
                                        <option
                                            value="{{ $year }}"
                                            {{ old('year_of_study', $course->year_of_study) == $year ? 'selected' : '' }}
                                        >
                                            Year {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div>
                                <label for="course_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Course Type
                                </label>

                                <select
                                    id="course_type"
                                    name="course_type"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="core" {{ old('course_type', $course->course_type) === 'core' ? 'selected' : '' }}>
                                        Core
                                    </option>

                                    <option value="elective" {{ old('course_type', $course->course_type) === 'elective' ? 'selected' : '' }}>
                                        Elective
                                    </option>

                                    <option value="practical" {{ old('course_type', $course->course_type) === 'practical' ? 'selected' : '' }}>
                                        Practical
                                    </option>

                                    <option value="project" {{ old('course_type', $course->course_type) === 'project' ? 'selected' : '' }}>
                                        Project
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Status
                                </label>

                                <select
                                    id="is_active"
                                    name="is_active"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="1" {{ old('is_active', $course->is_active ? '1' : '0') === '1' ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option value="0" {{ old('is_active', $course->is_active ? '1' : '0') === '0' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>

                        </div>

                        <div class="flex items-center justify-end gap-3 mt-8">
                            <a
                                href="{{ route('admin.courses.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 transition"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition"
                            >
                                Update Course
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>