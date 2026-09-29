<?php

namespace Tests\Feature\Registrar;

use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\CourseAssignment;
use App\Models\CourseEnrollment;
use App\Models\Department;
use App\Models\Lecturer;
use App\Models\Program;
use App\Models\Result;
use App\Models\ResultApproval;
use App\Models\Semester;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResultApprovalTest extends TestCase
{
    use RefreshDatabase;

    protected User $registrarUser;
    protected User $lecturerUser;
    protected User $studentUser;

    protected Lecturer $lecturer;
    protected Student $student;
    protected CourseEnrollment $enrollment;

    protected function setUp(): void
    {
        parent::setUp();

        /*
         * ---------------------------------------------------------
         * Department
         * ---------------------------------------------------------
         */
        $department = Department::create([
            'name' => 'Information and Communication Technology',
            'code' => 'ICT',
            'description' => 'ICT Department',
            'is_active' => true,
        ]);

        /*
         * ---------------------------------------------------------
         * Academic Program
         * ---------------------------------------------------------
         */
        $program = Program::create([
            'department_id' => $department->id,
            'name' => 'Bachelor of Information Technology',
            'code' => 'BIT',
            'award' => 'Bachelor of Information Technology',
            'duration_years' => 3,
            'is_active' => true,
        ]);

        /*
         * ---------------------------------------------------------
         * Academic Year
         * ---------------------------------------------------------
         *
         * The existing academic_years schema requires:
         * - name
         * - start_year
         * - end_year
         * - start_date
         * - end_date
         * - is_current
         * - is_active
         */
        $academicYear = AcademicYear::create([
            'name' => '2027/2028',
            'start_year' => 2027,
            'end_year' => 2028,
            'start_date' => '2027-08-01',
            'end_date' => '2028-07-31',
            'is_current' => true,
            'is_active' => true,
        ]);

        /*
         * ---------------------------------------------------------
         * Semester
         * ---------------------------------------------------------
         */
        $semester = Semester::create([
            'academic_year_id' => $academicYear->id,
            'semester_number' => 2,
            'name' => 'Second Semester',
            'start_date' => '2028-01-15',
            'end_date' => '2028-05-30',
            'is_current' => true,
            'is_active' => true,
        ]);

        /*
         * ---------------------------------------------------------
         * Registrar User
         * ---------------------------------------------------------
         */
        $this->registrarUser = User::create([
            'name' => 'Test Registrar',
            'email' => 'test.registrar@example.com',
            'password' => 'password',
            'role' => 'registrar',
        ]);

        /*
         * ---------------------------------------------------------
         * Lecturer User
         * ---------------------------------------------------------
         */
        $this->lecturerUser = User::create([
            'name' => 'Test Lecturer',
            'email' => 'test.lecturer@example.com',
            'password' => 'password',
            'role' => 'lecturer',
        ]);

        /*
         * ---------------------------------------------------------
         * Student User
         * ---------------------------------------------------------
         */
        $this->studentUser = User::create([
            'name' => 'Test Student',
            'email' => 'test.student@example.com',
            'password' => 'password',
            'role' => 'student',
        ]);

        /*
         * ---------------------------------------------------------
         * Lecturer Profile
         * ---------------------------------------------------------
         */
        $this->lecturer = Lecturer::create([
            'user_id' => $this->lecturerUser->id,
            'staff_number' => 'TEST-LEC-001',
            'first_name' => 'Test',
            'last_name' => 'Lecturer',
            'email' => 'test.lecturer@example.com',
            'phone' => '0700000000',
            'department_id' => $department->id,
            'status' => 'active',
        ]);

        /*
         * ---------------------------------------------------------
         * Student Profile
         * ---------------------------------------------------------
         *
         * IMPORTANT:
         * The existing Student model uses student_number.
         * We are NOT changing the students table.
         */
             $this->student = Student::create([
            'user_id' => $this->studentUser->id,
            'student_number' => 'TEST-STU-001',
            'registration_number' => 'REG-TEST-001',
            'first_name' => 'Test',
            'last_name' => 'Student',
            'gender' => 'Male',
            'date_of_birth' => '2000-01-01',
            'phone' => '0711111111',
            'program_id' => $program->id,
            'admission_academic_year_id' => $academicYear->id,
            'status' => 'active',
        ]);

        /*
         * ---------------------------------------------------------
         * Course
         * ---------------------------------------------------------
         */
                $course = Course::create([
            'department_id' => $department->id,
            'code' => 'BIT1101',
            'name' => 'Introduction to Computer Programming',
            'description' => 'Programming fundamentals.',
            'credit_units' => 3,
            'year_of_study' => 1,
            'course_type' => 'core',
            'is_active' => true,
        ]);
        /*
         * --------$co-------------------------------------------------
         * Course Assignment
         * ---------------------------------------------------------
         */
        CourseAssignment::create([
            'course_id' => $course->id,
            'lecturer_id' => $this->lecturer->id,
            'semester_id' => $semester->id,
            'is_primary' => true,
            'is_active' => true,
        ]);

        /*
         * ---------------------------------------------------------
         * Course Enrollment
         * ---------------------------------------------------------
         */
        $this->enrollment = CourseEnrollment::create([
            'student_id' => $this->student->id,
            'course_id' => $course->id,
            'semester_id' => $semester->id,
            'status' => 'enrolled',
            'enrolled_at' => now(),
        ]);
    }

    /*
     * -------------------------------------------------------------
     * Helper: Create Submitted Result
     * -------------------------------------------------------------
     */
    protected function createSubmittedResult(): Result
    {
        return Result::create([
            'course_enrollment_id' => $this->enrollment->id,
            'coursework_mark' => 35,
            'final_exam_mark' => 50,
            'total_mark' => 85,
            'grade' => 'A',
            'grade_point' => 5.0,
            'credit_units' => 3,
            'status' => 'submitted',
            'remarks' => 'Good performance',
            'entered_by' => $this->lecturerUser->id,
            'submitted_at' => now(),
        ]);
    }

    /*
     * -------------------------------------------------------------
     * Test 1
     * Registrar can view submitted results.
     * -------------------------------------------------------------
     */
    public function test_registrar_can_view_submitted_results(): void
    {
        $result = $this->createSubmittedResult();

        $response = $this->actingAs($this->registrarUser)
            ->get(route('registrar.result-approvals.index'));

        $response->assertOk();

        $response->assertSee(
            $result->courseEnrollment->student->first_name
        );

        $response->assertSee('BIT1101');
    }

    /*
     * -------------------------------------------------------------
     * Test 2
     * Registrar can view result details.
     * -------------------------------------------------------------
     */
    public function test_registrar_can_view_result_details(): void
    {
        $result = $this->createSubmittedResult();

        $response = $this->actingAs($this->registrarUser)
            ->get(
                route(
                    'registrar.result-approvals.show',
                    $result
                )
            );

        $response->assertOk();

        $response->assertSee(
            'Introduction to Computer Programming'
        );

        $response->assertSee('85');

        $response->assertSee('A');
    }

    /*
     * -------------------------------------------------------------
     * Test 3
     * Registrar can approve submitted result.
     * -------------------------------------------------------------
     */
    public function test_registrar_can_approve_submitted_result(): void
    {
        $result = $this->createSubmittedResult();

        $response = $this->actingAs($this->registrarUser)
            ->post(
                route(
                    'registrar.result-approvals.approve',
                    $result
                )
            );

        $response->assertRedirect(
            route(
                'registrar.result-approvals.show',
                $result
            )
        );

        $this->assertDatabaseHas('results', [
            'id' => $result->id,
            'status' => 'approved',
        ]);

        $this->assertDatabaseHas('result_approvals', [
            'result_id' => $result->id,
            'approved_by' => $this->registrarUser->id,
            'action' => 'approved',
        ]);
    }

    /*
     * -------------------------------------------------------------
     * Test 4
     * Approval records approved_at timestamp.
     * -------------------------------------------------------------
     */
    public function test_approval_records_approved_at_timestamp(): void
    {
        $result = $this->createSubmittedResult();

        $this->actingAs($this->registrarUser)
            ->post(
                route(
                    'registrar.result-approvals.approve',
                    $result
                )
            );

        $result->refresh();

        $this->assertNotNull($result->approved_at);
    }

    /*
     * -------------------------------------------------------------
     * Test 5
     * Registrar can reject submitted result.
     * -------------------------------------------------------------
     */
    public function test_registrar_can_reject_submitted_result(): void
    {
        $result = $this->createSubmittedResult();

        $response = $this->actingAs($this->registrarUser)
            ->post(
                route(
                    'registrar.result-approvals.reject',
                    $result
                ),
               [
                    'comments' => 'Please verify the examination marks.',
                ]
            );

        $response->assertRedirect(
            route(
                'registrar.result-approvals.show',
                $result
            )
        );

        $this->assertDatabaseHas('results', [
            'id' => $result->id,
            'status' => 'rejected',
        ]);

        $this->assertDatabaseHas('result_approvals', [
            'result_id' => $result->id,
            'approved_by' => $this->registrarUser->id,
            'action' => 'rejected',
        ]);
    }

    /*
     * -------------------------------------------------------------
     * Test 6
     * Registrar can return submitted result to lecturer.
     * -------------------------------------------------------------
     */
    public function test_registrar_can_return_submitted_result_to_lecturer(): void
    {
        $result = $this->createSubmittedResult();

        $response = $this->actingAs($this->registrarUser)
            ->post(
                route(
                    'registrar.result-approvals.return',
                    $result
                ),
              [
                'comments' => 'Correct the coursework mark before resubmission.',
            ]
            );

        $response->assertRedirect(
            route(
                'registrar.result-approvals.show',
                $result
            )
        );

        $this->assertDatabaseHas('results', [
            'id' => $result->id,
            'status' => 'rejected',
        ]);

        $this->assertDatabaseHas('result_approvals', [
            'result_id' => $result->id,
            'approved_by' => $this->registrarUser->id,
            'action' => 'returned',
        ]);
    }

    /*
     * -------------------------------------------------------------
     * Test 7
     * Registrar can publish approved result.
     * -------------------------------------------------------------
     */
    public function test_registrar_can_publish_approved_result(): void
    {
        $result = $this->createSubmittedResult();

        /*
         * Approve first.
         */
        $this->actingAs($this->registrarUser)
            ->post(
                route(
                    'registrar.result-approvals.approve',
                    $result
                )
            );

        $result->refresh();

        /*
         * Publish after approval.
         */
        $response = $this->actingAs($this->registrarUser)
            ->post(
                route(
                    'registrar.result-approvals.publish',
                    $result
                )
            );

        $response->assertRedirect(
            route(
                'registrar.result-approvals.show',
                $result
            )
        );

        $this->assertDatabaseHas('results', [
            'id' => $result->id,
            'status' => 'published',
        ]);

        $this->assertDatabaseHas('result_approvals', [
            'result_id' => $result->id,
            'approved_by' => $this->registrarUser->id,
            'action' => 'published',
        ]);
    }

    /*
     * -------------------------------------------------------------
     * Test 8
     * Publishing records published_at timestamp.
     * -------------------------------------------------------------
     */
    public function test_publishing_records_published_at_timestamp(): void
    {
        $result = $this->createSubmittedResult();

        /*
         * Approve.
         */
        $this->actingAs($this->registrarUser)
            ->post(
                route(
                    'registrar.result-approvals.approve',
                    $result
                )
            );

        $result->refresh();

        /*
         * Publish.
         */
        $this->actingAs($this->registrarUser)
            ->post(
                route(
                    'registrar.result-approvals.publish',
                    $result
                )
            );

        $result->refresh();

        $this->assertNotNull($result->published_at);
    }

    /*
     * -------------------------------------------------------------
     * Test 9
     * Submitted result cannot be published directly.
     * -------------------------------------------------------------
     */
    public function test_submitted_result_cannot_be_published_directly(): void
    {
        $result = $this->createSubmittedResult();

        $response = $this->actingAs($this->registrarUser)
            ->post(
                route(
                    'registrar.result-approvals.publish',
                    $result
                )
            );

        $response->assertRedirect(
            route(
                'registrar.result-approvals.show',
                $result
            )
        );

        $this->assertDatabaseHas('results', [
            'id' => $result->id,
            'status' => 'submitted',
        ]);

        $this->assertDatabaseMissing('result_approvals', [
            'result_id' => $result->id,
            'action' => 'published',
        ]);
    }

    /*
     * -------------------------------------------------------------
     * Test 10
     * Published result cannot be approved again.
     * -------------------------------------------------------------
     */
    public function test_published_result_cannot_be_approved_again(): void
    {
        $result = $this->createSubmittedResult();

        /*
         * Approve.
         */
        $this->actingAs($this->registrarUser)
            ->post(
                route(
                    'registrar.result-approvals.approve',
                    $result
                )
            );

        $result->refresh();

        /*
         * Publish.
         */
        $this->actingAs($this->registrarUser)
            ->post(
                route(
                    'registrar.result-approvals.publish',
                    $result
                )
            );

        $result->refresh();

        $this->assertSame(
            'published',
            $result->status
        );

        /*
         * Count existing approval records.
         */
        $approvalCount = ResultApproval::where(
            'result_id',
            $result->id
        )
            ->where('action', 'approved')
            ->count();

        /*
         * Attempt to approve the published result again.
         */
        $this->actingAs($this->registrarUser)
            ->post(
                route(
                    'registrar.result-approvals.approve',
                    $result
                )
            );

        $result->refresh();

        /*
         * Status must remain published.
         */
        $this->assertSame(
            'published',
            $result->status
        );

        /*
         * No second approval record should be created.
         */
        $this->assertSame(
            $approvalCount,
            ResultApproval::where(
                'result_id',
                $result->id
            )
                ->where('action', 'approved')
                ->count()
        );
    }

    /*
     * -------------------------------------------------------------
     * Test 11
     * Student cannot access approval management.
     * -------------------------------------------------------------
     */
    public function test_student_cannot_access_result_approval_management(): void
    {
        $response = $this->actingAs($this->studentUser)
            ->get(
                route('registrar.result-approvals.index')
            );

        $response->assertForbidden();
    }

    /*
     * -------------------------------------------------------------
     * Test 12
     * Lecturer cannot access approval management.
     * -------------------------------------------------------------
     */
    public function test_lecturer_cannot_access_result_approval_management(): void
    {
        $response = $this->actingAs($this->lecturerUser)
            ->get(
                route('registrar.result-approvals.index')
            );

        $response->assertForbidden();
    }

    /*
     * -------------------------------------------------------------
     * Test 13
     * Guest cannot access approval management.
     * -------------------------------------------------------------
     */
    public function test_guest_cannot_access_result_approval_management(): void
    {
        $response = $this->get(
            route('registrar.result-approvals.index')
        );

        $response->assertRedirect(
            route('login')
        );
    }
}
