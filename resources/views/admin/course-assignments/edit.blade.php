<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Course Assignment
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update the lecturer, course, semester, or assignment status.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200">
                    <ul class="list-disc list-inside text-sm text-red-800">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form
                        method="POST"
                        action="{{ route('admin.course-assignments.update', $courseAssignment) }}"
                    >
                        @csrf
                        @method('PUT')

                        {{-- Course --}}
                        <div>
                            <label
                                for="course_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Course
                            </label>

                            <select
                                id="course_id"
                                name="course_id"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">Select a course</option>

                                @foreach ($courses as $course)
                                    <option
                                        value="{{ $course->id }}"
                                        {{ old('course_id', $courseAssignment->course_id) == $course->id ? 'selected' : '' }}
                                    >
                                        {{ $course->code }} — {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('course_id')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Lecturer --}}
                        <div class="mt-6">
                            <label
                                for="lecturer_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Lecturer
                            </label>

                            <select
                                id="lecturer_id"
                                name="lecturer_id"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">Select a lecturer</option>

                                @foreach ($lecturers as $lecturer)
                                    <option
                                        value="{{ $lecturer->id }}"
                                        {{ old('lecturer_id', $courseAssignment->lecturer_id) == $lecturer->id ? 'selected' : '' }}
                                    >
                                        {{ $lecturer->staff_number }} —
                                        {{ $lecturer->title }}
                                        {{ $lecturer->first_name }}
                                        {{ $lecturer->middle_name }}
                                        {{ $lecturer->last_name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('lecturer_id')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Semester --}}
                        <div class="mt-6">
                            <label
                                for="semester_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Academic Semester
                            </label>

                            <select
                                id="semester_id"
                                name="semester_id"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">Select a semester</option>

                                @foreach ($semesters as $semester)
                                    <option
                                        value="{{ $semester->id }}"
                                        {{ old('semester_id', $courseAssignment->semester_id) == $semester->id ? 'selected' : '' }}
                                    >
                                        {{ $semester->academicYear->name }}
                                        —
                                        {{ $semester->name }}
                                        (Semester {{ $semester->semester_number }})
                                    </option>
                                @endforeach
                            </select>

                            @error('semester_id')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Assignment options --}}
                        <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">

                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                Assignment Options
                            </h3>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Configure the responsibility and status of this assignment.
                            </p>

                            {{-- Primary lecturer --}}
                            <div class="mt-5">
                                <label class="inline-flex items-center">
                                    <input
                                        type="checkbox"
                                        name="is_primary"
                                        value="1"
                                        {{ old('is_primary', $courseAssignment->is_primary) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    >

                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Set as primary lecturer
                                    </span>
                                </label>

                                <p class="mt-1 ml-6 text-xs text-gray-500 dark:text-gray-400">
                                    If selected, this lecturer becomes the primary lecturer for
                                    this course in the selected semester.
                                </p>
                            </div>

                            {{-- Active --}}
                            <div class="mt-5">
                                <label class="inline-flex items-center">
                                    <input
                                        type="checkbox"
                                        name="is_active"
                                        value="1"
                                        {{ old('is_active', $courseAssignment->is_active) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    >

                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Assignment is active
                                    </span>
                                </label>

                                <p class="mt-1 ml-6 text-xs text-gray-500 dark:text-gray-400">
                                    Active assignments can be used for teaching and result management.
                                </p>
                            </div>

                        </div>

                        {{-- Buttons --}}
                        <div class="mt-8 flex items-center justify-end gap-3">

                            <a
                                href="{{ route('admin.course-assignments.show', $courseAssignment) }}"
                                class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-800 font-semibold text-sm rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-blue font-semibold text-sm rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition"
                            >
                                Update Assignment
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>