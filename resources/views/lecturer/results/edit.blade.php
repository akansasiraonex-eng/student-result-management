<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Edit Result
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Update the student's coursework and examination marks.
                </p>
            </div>

            <a href="{{ route('lecturer.results.show', $result) }}"
               class="inline-flex items-center px-4 py-2
                      bg-gray-200 dark:bg-gray-700
                      text-gray-700 dark:text-gray-200
                      rounded-md font-semibold text-xs uppercase
                      tracking-widest hover:bg-gray-300
                      dark:hover:bg-gray-600">
                Back to Result
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
                        shadow-sm sm:rounded-lg overflow-hidden">

                <div class="p-6 border-b border-gray-200
                            dark:border-gray-700">

                    <div class="flex items-center justify-between">

                        <div>
                            <h3 class="text-lg font-semibold
                                       text-gray-900 dark:text-gray-100">
                                Result Information
                            </h3>

                            <p class="mt-1 text-sm text-gray-500
                                      dark:text-gray-400">
                                Result ID: {{ $result->id }}
                            </p>
                        </div>

                        <span class="inline-flex px-3 py-1.5
                                     rounded-full text-xs font-semibold
                                     bg-gray-100 text-gray-800
                                     dark:bg-gray-700
                                     dark:text-gray-200">
                            {{ ucfirst($result->status) }}
                        </span>

                    </div>
                </div>

                <div class="p-6">

                    <div class="grid grid-cols-1 md:grid-cols-2
                                gap-6 mb-8">

                        <div>
                            <p class="text-sm text-gray-500
                                      dark:text-gray-400">
                                Student
                            </p>

                            <p class="mt-1 font-semibold
                                      text-gray-900 dark:text-gray-100">

                                {{ $result->courseEnrollment->student->first_name }}
                                {{ $result->courseEnrollment->student->middle_name }}
                                {{ $result->courseEnrollment->student->last_name }}

                            </p>

                            <p class="text-sm text-gray-500
                                      dark:text-gray-400">

                                {{ $result->courseEnrollment->student->student_number }}

                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500
                                      dark:text-gray-400">
                                Course
                            </p>

                            <p class="mt-1 font-semibold
                                      text-gray-900 dark:text-gray-100">

                                {{ $result->courseEnrollment->course->code }}

                            </p>

                            <p class="text-sm text-gray-500
                                      dark:text-gray-400">

                                {{ $result->courseEnrollment->course->name }}

                            </p>
                        </div>

                    </div>

                    <form method="POST"
                          action="{{ route('lecturer.results.update', $result) }}">

                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2
                                    gap-6">

                            <div>
                                <label for="coursework_mark"
                                       class="block text-sm font-medium
                                              text-gray-700
                                              dark:text-gray-300">
                                    Coursework Mark
                                </label>

                                <div class="mt-1 relative">

                                    <input type="number"
                                           name="coursework_mark"
                                           id="coursework_mark"
                                           value="{{ old(
                                               'coursework_mark',
                                               $result->coursework_mark
                                           ) }}"
                                           min="0"
                                           max="40"
                                           step="0.01"
                                           required
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

                                @error('coursework_mark')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="final_exam_mark"
                                       class="block text-sm font-medium
                                              text-gray-700
                                              dark:text-gray-300">
                                    Final Examination Mark
                                </label>

                                <div class="mt-1 relative">

                                    <input type="number"
                                           name="final_exam_mark"
                                           id="final_exam_mark"
                                           value="{{ old(
                                               'final_exam_mark',
                                               $result->final_exam_mark
                                           ) }}"
                                           min="0"
                                           max="60"
                                           step="0.01"
                                           required
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

                                @error('final_exam_mark')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">

                                <label for="remarks"
                                       class="block text-sm font-medium
                                              text-gray-700
                                              dark:text-gray-300">
                                    Remarks
                                </label>

                                <textarea name="remarks"
                                          id="remarks"
                                          rows="4"
                                          maxlength="1000"
                                          class="mt-1 block w-full
                                                 rounded-md
                                                 border-gray-300
                                                 dark:border-gray-700
                                                 dark:bg-gray-900
                                                 dark:text-gray-300
                                                 shadow-sm
                                                 focus:border-indigo-500
                                                 focus:ring-indigo-500">{{ old('remarks', $result->remarks) }}</textarea>

                                @error('remarks')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                        <div class="mt-8 p-4 rounded-lg
                                    bg-yellow-50 dark:bg-yellow-900/20
                                    border border-yellow-200
                                    dark:border-yellow-800">

                            <h4 class="font-semibold text-yellow-900
                                       dark:text-yellow-300">
                                Important
                            </h4>

                            <p class="mt-2 text-sm text-yellow-800
                                      dark:text-yellow-300">

                                Coursework is marked out of 40 and the final
                                examination is marked out of 60. The system
                                automatically recalculates the total mark
                                when the result is updated.

                            </p>

                        </div>

                        <div class="mt-8 flex items-center justify-end gap-3">

                            <a href="{{ route('lecturer.results.show', $result) }}"
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
                                Update Result
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>