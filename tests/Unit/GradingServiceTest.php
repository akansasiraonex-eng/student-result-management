<?php
namespace Tests\Unit;

use App\Services\GradingService;
use Tests\TestCase;

class GradingServiceTest extends TestCase
{
    protected GradingService $gradingService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->gradingService = app(GradingService::class);
    }

    public function test_grading_scale_returns_correct_grades_and_points(): void
    {
        $expected = [
            100 => ['grade' => 'A', 'grade_point' => 5.0],
            85  => ['grade' => 'A', 'grade_point' => 5.0],
            80  => ['grade' => 'A', 'grade_point' => 5.0],

            79  => ['grade' => 'B+', 'grade_point' => 4.5],
            75  => ['grade' => 'B+', 'grade_point' => 4.5],

            74  => ['grade' => 'B', 'grade_point' => 4.0],
            70  => ['grade' => 'B', 'grade_point' => 4.0],

            69  => ['grade' => 'C+', 'grade_point' => 3.5],
            65  => ['grade' => 'C+', 'grade_point' => 3.5],

            64  => ['grade' => 'C', 'grade_point' => 3.0],
            60  => ['grade' => 'C', 'grade_point' => 3.0],

            59  => ['grade' => 'D+', 'grade_point' => 2.5],
            55  => ['grade' => 'D+', 'grade_point' => 2.5],

            54  => ['grade' => 'D', 'grade_point' => 2.0],
            50  => ['grade' => 'D', 'grade_point' => 2.0],

            49  => ['grade' => 'F', 'grade_point' => 0.0],
            0   => ['grade' => 'F', 'grade_point' => 0.0],
        ];

        foreach ($expected as $mark => $expectedResult) {
            $actual = $this->gradingService->calculate((float) $mark);

            $this->assertSame(
                $expectedResult['grade'],
                $actual['grade'],
                "Incorrect grade for mark {$mark}."
            );

            $this->assertSame(
                $expectedResult['grade_point'],
                $actual['grade_point'],
                "Incorrect grade point for mark {$mark}."
            );
        }
    }

    public function test_decimal_marks_are_classified_correctly(): void
    {
        $this->assertSame(
            ['grade' => 'A', 'grade_point' => 5.0],
            $this->gradingService->calculate(80.99)
        );

        $this->assertSame(
            ['grade' => 'B+', 'grade_point' => 4.5],
            $this->gradingService->calculate(79.99)
        );

        $this->assertSame(
            ['grade' => 'B+', 'grade_point' => 4.5],
            $this->gradingService->calculate(75.50)
        );

        $this->assertSame(
            ['grade' => 'B', 'grade_point' => 4.0],
            $this->gradingService->calculate(74.99)
        );

        $this->assertSame(
            ['grade' => 'D', 'grade_point' => 2.0],
            $this->gradingService->calculate(50.50)
        );

        $this->assertSame(
            ['grade' => 'F', 'grade_point' => 0.0],
            $this->gradingService->calculate(49.99)
        );
    }

    public function test_maximum_mark_is_an_a(): void
    {
        $result = $this->gradingService->calculate(100);

        $this->assertSame('A', $result['grade']);
        $this->assertSame(5.0, $result['grade_point']);
    }

    public function test_zero_mark_is_an_f(): void
    {
        $result = $this->gradingService->calculate(0);

        $this->assertSame('F', $result['grade']);
        $this->assertSame(0.0, $result['grade_point']);
    }
}

