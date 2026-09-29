<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Enter Student Result
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Enter coursework and final examination marks for an enrolled student.
                </p>
            </div>

            <a href="{{ route('lecturer.results.index') }}"
               class="inline-flex items-center px-4 py-2
                      bg-gray-200 dark:bg-gray-700
                      text-gray-700 dark:text-gray-200
                      rounded-md font-semibold text-xs uppercase
                      tracking-widest hover:bg-gray-300
                      dark:hover:bg-gray-600">
                Back to Results
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

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

            <div class="bg-white dark:bg-gray-800
                        shadow-sm sm:rounded-lg">

                <div class="p-6 border-b border-gray-200
                            dark:border-gray-700">

                    <h3 class="text-lg font-semibold
                               text-gray-900 dark:text-gray-100">
                        Result Information
                    </h3>

                    <p class="mt-1 text-sm text-gray-600
                              dark:text-gray-400">
                        Select an enrolled student and enter marks within
                        the permitted ranges.
                    </p>
                </div>

                <form method="POST"
                      action="{{ route('lecturer.results.store') }}"
                      class="p-6">

                    @csrf

                    <div class="space-y-6">

                        <div>
                            <label for="course_enrollment_id"
                                   class="block text-sm font-medium
                                          text-gray-700 dark:text-gray-300">
                                Student Enrollment
                            </label>

                            <select name="course_enrollment_id"
                                    id="course_enrollment_id"
                                    required
                                    class="mt-1 block w-full rounded-md
                                           border-gray-300 dark:border-gray-700
                                           dark:bg-gray-900 dark:text-gray-300
                                           shadow-sm focus:border-indigo-500
                                           focus:ring-indigo-500">

                                <option value="">
                                    -- Select Student Enrollment --
                                </option>

                                @foreach ($enrollments as $enrollment)
                                    <option value="{{ $enrollment->id }}"
                                        @selected(
                                            old('course_enrollment_id') == $enrollment->id
                                        )>

                                        {{ $enrollment->student->student_number }}
                                        -
                                        {{ $enrollment->student->first_name }}
                                        {{ $enrollment->student->middle_name }}
                                        {{ $enrollment->student->last_name }}

                                        |
                                        {{ $enrollment->course->code }}
                                        -
                                        {{ $enrollment->course->name }}

                                        |
                                        {{ $enrollment->semester->academicYear->name }}
                                        -
                                        {{ $enrollment->semester->name }}

                                    </option>
                                @endforeach

                            </select>

                            @if ($enrollments->isEmpty())
                                <p class="mt-2 text-sm text-amber-600 dark:text-amber-400">
                                    There are currently no eligible student enrollments
                                    available for result entry.
                                </p>
                            @endif

                            @error('course_enrollment_id')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label for="coursework_mark"
                                       class="block text-sm font-medium
                                              text-gray-700 dark:text-gray-300">
                                    Coursework Mark
                                </label>

                                <div class="mt-1 relative">
                                    <input type="number"
                                           name="coursework_mark"
                                           id="coursework_mark"
                                           value="{{ old('coursework_mark') }}"
                                           min="0"
                                           max="40"
                                           step="0.01"
                                           required
                                           placeholder="0 - 40"
                                           class="block w-full rounded-md
                                                  border-gray-300
                                                  dark:border-gray-700
                                                  dark:bg-gray-900
                                                  dark:text-gray-300
                                                  shadow-sm
                                                  focus:border-indigo-500
                                                  focus:ring-indigo-500">

                                    <span class="absolute inset-y-0 right-0
                                                 flex items-center pr-3
                                                 text-sm text-gray-500">
                                        / 40
                                    </span>
                                </div>

                                <p class="mt-1 text-xs text-gray-500
                                          dark:text-gray-400">
                                    Maximum coursework mark: 40.
                                </p>

                                @error('coursework_mark')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="final_exam_mark"
                                       class="block text-sm font-medium
                                              text-gray-700 dark:text-gray-300">
                                    Final Examination Mark
                                </label>

                                <div class="mt-1 relative">
                                    <input type="number"
                                           name="final_exam_mark"
                                           id="final_exam_mark"
                                           value="{{ old('final_exam_mark') }}"
                                           min="0"
                                           max="60"
                                           step="0.01"
                                           required
                                           placeholder="0 - 60"
                                           class="block w-full rounded-md
                                                  border-gray-300
                                                  dark:border-gray-700
                                                  dark:bg-gray-900
                                                  dark:text-gray-300
                                                  shadow-sm
                                                  focus:border-indigo-500
                                                  focus:ring-indigo-500">

                                    <span class="absolute inset-y-0 right-0
                                                 flex items-center pr-3
                                                 text-sm text-gray-500">
                                        / 60
                                    </span>
                                </div>

                                <p class="mt-1 text-xs text-gray-500
                                          dark:text-gray-400">
                                    Maximum examination mark: 60.
                                </p>

                                @error('final_exam_mark')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                        </div>

                        <div>
                            <label for="remarks"
                                   class="block text-sm font-medium
                                          text-gray-700 dark:text-gray-300">
                                Remarks
                            </label>

                            <textarea name="remarks"
                                      id="remarks"
                                      rows="4"
                                      maxlength="1000"
                                      placeholder="Optional remarks about the result..."
                                      class="mt-1 block w-full rounded-md
                                             border-gray-300
                                             dark:border-gray-700
                                             dark:bg-gray-900
                                             dark:text-gray-300
                                             shadow-sm
                                             focus:border-indigo-500
                                             focus:ring-indigo-500">{{ old('remarks') }}</textarea>

                            @error('remarks')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="p-4 rounded-lg
                                    bg-blue-50 dark:bg-blue-900/20
                                    border border-blue-200
                                    dark:border-blue-800">

                            <h4 class="font-semibold text-blue-900
                                       dark:text-blue-300">
                                Mark Structure
                            </h4>

                            <div class="mt-2 text-sm text-blue-800
                                        dark:text-blue-300">

                                <p>
                                    Coursework:
                                    <strong>40 marks</strong>
                                </p>

                                <p>
                                    Final Examination:
                                    <strong>60 marks</strong>
                                </p>

                                <p>
                                    Total:
                                    <strong>100 marks</strong>
                                </p>

                            </div>
                        </div>

                    </div>

                    <div class="mt-8 flex items-center justify-end gap-3">

                        <a href="{{ route('lecturer.results.index') }}"
                           class="inline-flex items-center px-4 py-2
                                  bg-gray-200 dark:bg-gray-700
                                  text-gray-700 dark:text-gray-200
                                  rounded-md font-semibold text-xs
                                  uppercase tracking-widest
                                  hover:bg-gray-300
                                  dark:hover:bg-gray-600">
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
                            Save Result
                        </button>

                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>