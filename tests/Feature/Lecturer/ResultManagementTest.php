<?php

namespace Tests\Feature\Lecturer;

use App\Models\Course;
use App\Models\CourseAssignment;
use App\Models\CourseEnrollment;
use App\Models\Lecturer;
use App\Models\Result;
use App\Models\Semester;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResultManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $lecturerUser;

    protected Lecturer $lecturer;

    protected Student $student;

    protected Course $course;

    protected Semester $semester;

    protected CourseEnrollment $enrollment;

    protected function setUp(): void
    {
        parent::setUp();

        $this->lecturerUser = User::factory()->create([
            'name' => 'Test Lecturer',
            'email' => 'lecturer@test.com',
            'role' => 'lecturer',
        ]);

        $department = \App\Models\Department::create([
            'name' => 'Information and Communication Technology',
            'code' => 'ICT',
            'description' => 'ICT Department',
            'is_active' => true,
        ]);

        $program = \App\Models\Program::create([
            'department_id' => $department->id,
            'name' => 'Bachelor of Information Technology',
            'code' => 'BIT',
            'award' => 'Bachelor Degree',
            'duration_years' => 4,
            'description' => 'Information Technology programme',
            'is_active' => true,
        ]);

        $academicYear = \App\Models\AcademicYear::create([
            'name' => '2027/2028',
            'start_year' => 2027,
            'end_year' => 2028,
            'start_date' => '2027-08-01',
            'end_date' => '2028-07-31',
            'is_current' => true,
            'is_active' => true,
        ]);

        $this->semester = Semester::create([
            'academic_year_id' => $academicYear->id,
            'name' => 'Second Semester',
            'semester_number' => 2,
            'start_date' => '2028-01-15',
            'end_date' => '2028-05-30',
            'is_current' => true,
            'is_active' => true,
        ]);

        $this->lecturer = Lecturer::create([
            'user_id' => $this->lecturerUser->id,
            'department_id' => $department->id,
            'staff_number' => 'TEST-LEC-001',
            'first_name' => 'Test',
            'middle_name' => null,
            'last_name' => 'Lecturer',
            'title' => 'Lecturer',
            'phone' => '0700000000',
            'specialization' => 'Software Engineering',
            'employment_type' => 'full_time',
            'status' => 'active',
        ]);

        $studentUser = User::factory()->create([
            'name' => 'Test Student',
            'email' => 'student@test.com',
            'role' => 'student',
        ]);

        $this->student = Student::create([
            'user_id' => $studentUser->id,
            'program_id' => $program->id,
            'admission_academic_year_id' => $academicYear->id,
            'student_number' => 'TEST-STU-001',
            'registration_number' => 'REG/TEST/001',
            'first_name' => 'Test',
            'middle_name' => null,
            'last_name' => 'Student',
            'date_of_birth' => '2000-01-01',
            'gender' => 'Male',
            'nationality' => 'Ugandan',
            'phone' => '0711111111',
            'address' => 'Kampala',
            'admission_date' => '2027-08-01',
            'status' => 'active',
        ]);

        $this->course = Course::create([
            'department_id' => $department->id,
            'code' => 'TEST1101',
            'name' => 'Test Programming',
            'description' => 'Test course',
            'credit_units' => 3,
            'course_type' => 'core',
            'year_of_study' => 1,
            'is_active' => true,
        ]);

        CourseAssignment::create([
            'course_id' => $this->course->id,
            'lecturer_id' => $this->lecturer->id,
            'semester_id' => $this->semester->id,
            'is_primary' => true,
            'is_active' => true,
        ]);

        $this->enrollment = CourseEnrollment::create([
            'student_id' => $this->student->id,
            'course_id' => $this->course->id,
            'semester_id' => $this->semester->id,
            'status' => 'enrolled',
            'enrolled_at' => now(),
        ]);
    }

    public function test_lecturer_can_create_a_result_with_automatic_grade(): void
    {
        $response = $this->actingAs($this->lecturerUser)
            ->post(route('lecturer.results.store'), [
                'course_enrollment_id' => $this->enrollment->id,
                'coursework_mark' => 35,
                'final_exam_mark' => 50,
                'remarks' => 'Good performance',
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('results', [
            'course_enrollment_id' => $this->enrollment->id,
            'coursework_mark' => 35,
            'final_exam_mark' => 50,
            'total_mark' => 85,
            'grade' => 'A',
            'grade_point' => 5.0,
            'status' => 'draft',
            'entered_by' => $this->lecturerUser->id,
        ]);
    }

    public function test_coursework_mark_cannot_exceed_40(): void
    {
        $response = $this->actingAs($this->lecturerUser)
            ->post(route('lecturer.results.store'), [
                'course_enrollment_id' => $this->enrollment->id,
                'coursework_mark' => 41,
                'final_exam_mark' => 50,
            ]);

        $response->assertSessionHasErrors('coursework_mark');

        $this->assertDatabaseCount('results', 0);
    }

    public function test_final_exam_mark_cannot_exceed_60(): void
    {
        $response = $this->actingAs($this->lecturerUser)
            ->post(route('lecturer.results.store'), [
                'course_enrollment_id' => $this->enrollment->id,
                'coursework_mark' => 35,
                'final_exam_mark' => 61,
            ]);

        $response->assertSessionHasErrors('final_exam_mark');

        $this->assertDatabaseCount('results', 0);
    }

    public function test_lecturer_cannot_enter_a_negative_mark(): void
    {
        $response = $this->actingAs($this->lecturerUser)
            ->post(route('lecturer.results.store'), [
                'course_enrollment_id' => $this->enrollment->id,
                'coursework_mark' => -1,
                'final_exam_mark' => 50,
            ]);

        $response->assertSessionHasErrors('coursework_mark');

        $this->assertDatabaseCount('results', 0);
    }

    public function test_total_mark_and_grade_point_are_calculated_automatically(): void
    {
        $response = $this->actingAs($this->lecturerUser)
            ->post(route('lecturer.results.store'), [
                'course_enrollment_id' => $this->enrollment->id,
                'coursework_mark' => 30,
                'final_exam_mark' => 45,
            ]);

        $response->assertRedirect();

        $result = Result::first();

        $this->assertNotNull($result);

        $this->assertSame(75.0, (float) $result->total_mark);
        $this->assertSame('B+', $result->grade);
        $this->assertSame(4.5, (float) $result->grade_point);
    }

    public function test_lecturer_can_update_a_draft_result(): void
    {
        $result = Result::create([
            'course_enrollment_id' => $this->enrollment->id,
            'coursework_mark' => 30,
            'final_exam_mark' => 40,
            'total_mark' => 70,
            'grade' => 'B',
            'grade_point' => 4.0,
            'credit_units' => 3,
            'status' => 'draft',
            'entered_by' => $this->lecturerUser->id,
        ]);

        $response = $this->actingAs($this->lecturerUser)
            ->put(
                route('lecturer.results.update', $result),
                [
                    'course_enrollment_id' => $this->enrollment->id,
                    'coursework_mark' => 35,
                    'final_exam_mark' => 50,
                    'remarks' => 'Updated marks',
                ]
            );

        $response->assertRedirect();

        $result->refresh();

        $this->assertSame(85.0, (float) $result->total_mark);
        $this->assertSame('A', $result->grade);
        $this->assertSame(5.0, (float) $result->grade_point);
    }

    public function test_lecturer_can_submit_a_draft_result(): void
    {
        $result = Result::create([
            'course_enrollment_id' => $this->enrollment->id,
            'coursework_mark' => 35,
            'final_exam_mark' => 50,
            'total_mark' => 85,
            'grade' => 'A',
            'grade_point' => 5.0,
            'credit_units' => 3,
            'status' => 'draft',
            'entered_by' => $this->lecturerUser->id,
        ]);

        $response = $this->actingAs($this->lecturerUser)
            ->post(route('lecturer.results.submit', $result));

        $response->assertRedirect();

        $result->refresh();

        $this->assertSame('submitted', $result->status);
        $this->assertNotNull($result->submitted_at);
    }

    public function test_submitting_result_creates_approval_history(): void
    {
        $result = Result::create([
            'course_enrollment_id' => $this->enrollment->id,
            'coursework_mark' => 35,
            'final_exam_mark' => 50,
            'total_mark' => 85,
            'grade' => 'A',
            'grade_point' => 5.0,
            'credit_units' => 3,
            'status' => 'draft',
            'entered_by' => $this->lecturerUser->id,
        ]);

        $this->actingAs($this->lecturerUser)
            ->post(route('lecturer.results.submit', $result));

        $this->assertDatabaseHas('result_approvals', [
            'result_id' => $result->id,
            'approved_by' => $this->lecturerUser->id,
            'action' => 'submitted',
        ]);
    }

    public function test_lecturer_cannot_edit_an_approved_result(): void
    {
        $result = Result::create([
            'course_enrollment_id' => $this->enrollment->id,
            'coursework_mark' => 35,
            'final_exam_mark' => 50,
            'total_mark' => 85,
            'grade' => 'A',
            'grade_point' => 5.0,
            'credit_units' => 3,
            'status' => 'approved',
            'entered_by' => $this->lecturerUser->id,
            'approved_at' => now(),
        ]);

        $response = $this->actingAs($this->lecturerUser)
            ->get(route('lecturer.results.edit', $result));

        $response->assertForbidden();
    }

    public function test_lecturer_cannot_delete_a_submitted_result(): void
    {
        $result = Result::create([
            'course_enrollment_id' => $this->enrollment->id,
            'coursework_mark' => 35,
            'final_exam_mark' => 50,
            'total_mark' => 85,
            'grade' => 'A',
            'grade_point' => 5.0,
            'credit_units' => 3,
            'status' => 'submitted',
            'entered_by' => $this->lecturerUser->id,
            'submitted_at' => now(),
        ]);

        $response = $this->actingAs($this->lecturerUser)
            ->delete(route('lecturer.results.destroy', $result));

        $response->assertRedirect();

        $this->assertDatabaseHas('results', [
            'id' => $result->id,
            'status' => 'submitted',
        ]);
    }

    public function test_student_cannot_access_lecturer_result_management(): void
    {
        $studentUser = $this->student->user;

        $response = $this->actingAs($studentUser)
            ->get(route('lecturer.results.index'));

        $response->assertForbidden();
    }

    public function test_lecturer_cannot_manage_results_for_another_lecturers_course(): void
    {
        $anotherLecturerUser = User::factory()->create([
            'name' => 'Another Lecturer',
            'email' => 'anotherlecturer@test.com',
            'role' => 'lecturer',
        ]);

        $response = $this->actingAs($anotherLecturerUser)
            ->post(route('lecturer.results.store'), [
                'course_enrollment_id' => $this->enrollment->id,
                'coursework_mark' => 35,
                'final_exam_mark' => 50,
            ]);

        $response->assertForbidden();

        $this->assertDatabaseCount('results', 0);
    }
}
