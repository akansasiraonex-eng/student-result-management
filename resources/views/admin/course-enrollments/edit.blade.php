<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Edit Course Enrollment
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Update the student's course enrollment information.
                </p>
            </div>

            <a href="{{ route('admin.course-enrollments.show', $courseEnrollment) }}"
               class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700
                      text-gray-700 dark:text-gray-200 rounded-md font-semibold
                      text-xs uppercase tracking-widest hover:bg-gray-300
                      dark:hover:bg-gray-600">
                Back to Enrollment
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 dark:bg-red-900/20
                            border border-red-200 dark:border-red-800
                            rounded-lg p-4">

                    <div class="font-semibold text-red-800 dark:text-red-300">
                        Please correct the following errors:
                    </div>

                    <ul class="mt-2 list-disc list-inside text-sm
                               text-red-700 dark:text-red-300">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">

                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Enrollment Information
                    </h3>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Enrollment ID: {{ $courseEnrollment->id }}
                    </p>
                </div>

                <form method="POST"
                      action="{{ route('admin.course-enrollments.update', $courseEnrollment) }}"
                      class="p-6">

                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Student --}}
                        <div>
                            <label for="student_id"
                                   class="block text-sm font-medium
                                          text-gray-700 dark:text-gray-300">
                                Student
                            </label>

                            <select name="student_id"
                                    id="student_id"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300
                                           dark:border-gray-700 dark:bg-gray-900
                                           dark:text-gray-300 shadow-sm
                                           focus:border-indigo-500 focus:ring-indigo-500">

                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}"
                                        @selected(
                                            old(
                                                'student_id',
                                                $courseEnrollment->student_id
                                            ) == $student->id
                                        )>

                                        {{ $student->student_number }}
                                        -
                                        {{ $student->first_name }}
                                        {{ $student->middle_name }}
                                        {{ $student->last_name }}

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
                            <label for="course_id"
                                   class="block text-sm font-medium
                                          text-gray-700 dark:text-gray-300">
                                Course
                            </label>

                            <select name="course_id"
                                    id="course_id"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300
                                           dark:border-gray-700 dark:bg-gray-900
                                           dark:text-gray-300 shadow-sm
                                           focus:border-indigo-500 focus:ring-indigo-500">

                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"
                                        @selected(
                                            old(
                                                'course_id',
                                                $courseEnrollment->course_id
                                            ) == $course->id
                                        )>

                                        {{ $course->code }}
                                        -
                                        {{ $course->name }}

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
                            <label for="semester_id"
                                   class="block text-sm font-medium
                                          text-gray-700 dark:text-gray-300">
                                Semester
                            </label>

                            <select name="semester_id"
                                    id="semester_id"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300
                                           dark:border-gray-700 dark:bg-gray-900
                                           dark:text-gray-300 shadow-sm
                                           focus:border-indigo-500 focus:ring-indigo-500">

                                @foreach ($semesters as $semester)
                                    <option value="{{ $semester->id }}"
                                        @selected(
                                            old(
                                                'semester_id',
                                                $courseEnrollment->semester_id
                                            ) == $semester->id
                                        )>

                                        {{ $semester->academicYear->name }}
                                        -
                                        {{ $semester->name }}

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
                            <label for="status"
                                   class="block text-sm font-medium
                                          text-gray-700 dark:text-gray-300">
                                Enrollment Status
                            </label>

                            <select name="status"
                                    id="status"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300
                                           dark:border-gray-700 dark:bg-gray-900
                                           dark:text-gray-300 shadow-sm
                                           focus:border-indigo-500 focus:ring-indigo-500">

                                @foreach ([
                                    'enrolled' => 'Enrolled',
                                    'completed' => 'Completed',
                                    'dropped' => 'Dropped',
                                    'withdrawn' => 'Withdrawn',
                                    'deferred' => 'Deferred',
                                ] as $value => $label)

                                    <option value="{{ $value }}"
                                        @selected(
                                            old(
                                                'status',
                                                $courseEnrollment->status
                                            ) === $value
                                        )>
                                        {{ $label }}
                                    </option>

                                @endforeach
                            </select>

                            @error('status')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Enrollment Date --}}
                        <div class="md:col-span-2">
                            <label for="enrolled_at"
                                   class="block text-sm font-medium
                                          text-gray-700 dark:text-gray-300">
                                Enrollment Date and Time
                            </label>

                            <input type="datetime-local"
                                   name="enrolled_at"
                                   id="enrolled_at"
                                   value="{{ old(
                                       'enrolled_at',
                                       $courseEnrollment->enrolled_at
                                           ? $courseEnrollment->enrolled_at->format('Y-m-d\TH:i')
                                           : ''
                                   ) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300
                                          dark:border-gray-700 dark:bg-gray-900
                                          dark:text-gray-300 shadow-sm
                                          focus:border-indigo-500
                                          focus:ring-indigo-500">

                            @error('enrolled_at')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>

                    {{-- Current Enrollment Summary --}}
                    <div class="mt-8 p-4 rounded-lg
                                bg-gray-50 dark:bg-gray-900
                                border border-gray-200 dark:border-gray-700">

                        <h4 class="font-semibold text-gray-900 dark:text-gray-100">
                            Current Enrollment
                        </h4>

                        <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">

                            <div>
                                <span class="text-gray-500 dark:text-gray-400">
                                    Student
                                </span>

                                <p class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $courseEnrollment->student->student_number }}
                                </p>
                            </div>

                            <div>
                                <span class="text-gray-500 dark:text-gray-400">
                                    Course
                                </span>

                                <p class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $courseEnrollment->course->code }}
                                </p>
                            </div>

                            <div>
                                <span class="text-gray-500 dark:text-gray-400">
                                    Status
                                </span>

                                <p class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ ucfirst($courseEnrollment->status) }}
                                </p>
                            </div>

                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="mt-8 flex items-center justify-end gap-3">

                        <a href="{{ route('admin.course-enrollments.show', $courseEnrollment) }}"
                           class="inline-flex items-center px-4 py-2
                                  bg-gray-200 dark:bg-gray-700
                                  text-gray-700 dark:text-gray-200
                                  rounded-md font-semibold text-xs
                                  uppercase tracking-widest
                                  hover:bg-gray-300 dark:hover:bg-gray-600">
                            Cancel
                        </a>

                        <button type="submit"
                                class="inline-flex items-center px-5 py-2
                                       bg-indigo-600 text-blue
                                       rounded-md font-semibold text-xs
                                       uppercase tracking-widest
                                       hover:bg-indigo-700
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-indigo-500
                                       focus:ring-offset-2">
                            Update Enrollment
                        </button>

                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>