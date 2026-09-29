<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Add Course Enrollment
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Enroll an active student in a course for a specific academic semester.
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-800 rounded-lg dark:bg-red-900/30 dark:border-red-800 dark:text-red-300">
                    <div class="font-semibold mb-2">
                        Please correct the following errors:
                    </div>

                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Enrollment Information
                        </h3>

                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Select the student, course and semester for this enrollment.
                        </p>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('admin.course-enrollments.store') }}"
                        class="space-y-6"
                    >
                        @csrf

                        {{-- Student --}}
                        <div>
                            <label
                                for="student_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Student
                            </label>

                            <select
                                id="student_id"
                                name="student_id"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">Select Student</option>

                                @foreach ($students as $student)
                                    <option
                                        value="{{ $student->id }}"
                                        @selected(old('student_id') == $student->id)
                                    >
                                        {{ $student->student_number }}
                                        —
                                        {{ $student->first_name }}
                                        {{ $student->middle_name }}
                                        {{ $student->last_name }}
                                        — {{ $student->program->code ?? 'No Program' }}
                                    </option>
                                @endforeach
                            </select>

                            @error('student_id')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

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
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">Select Course</option>

                                @foreach ($courses as $course)
                                    <option
                                        value="{{ $course->id }}"
                                        @selected(old('course_id') == $course->id)
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

                        {{-- Semester --}}
                        <div>
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
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">Select Semester</option>

                                @foreach ($semesters as $semester)
                                    <option
                                        value="{{ $semester->id }}"
                                        @selected(old('semester_id') == $semester->id)
                                    >
                                        {{ $semester->academicYear->name }}
                                        — {{ $semester->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('semester_id')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div>
                            <label
                                for="status"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Enrollment Status
                            </label>

                            <select
                                id="status"
                                name="status"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="enrolled" @selected(old('status', 'enrolled') === 'enrolled')>
                                    Enrolled
                                </option>

                                <option value="completed" @selected(old('status') === 'completed')>
                                    Completed
                                </option>

                                <option value="dropped" @selected(old('status') === 'dropped')>
                                    Dropped
                                </option>

                                <option value="withdrawn" @selected(old('status') === 'withdrawn')>
                                    Withdrawn
                                </option>

                                <option value="deferred" @selected(old('status') === 'deferred')>
                                    Deferred
                                </option>
                            </select>

                            @error('status')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Enrollment date --}}
                        <div>
                            <label
                                for="enrolled_at"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Enrollment Date and Time
                            </label>

                            <input
                                type="datetime-local"
                                id="enrolled_at"
                                name="enrolled_at"
                                value="{{ old('enrolled_at') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Leave blank if the enrollment date is not yet recorded.
                            </p>

                            @error('enrolled_at')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">

                            <a
                                href="{{ route('admin.course-enrollments.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 transition"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-blue font-semibold text-sm rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition"
                            >
                                Create Enrollment
                            </button>

                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>