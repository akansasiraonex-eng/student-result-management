<?php

namespace App\Services;

class GradingService
{
    /**
     * Calculate the grade and grade point from a total mark.
     *
     * Grading scale:
     * 80-100 = A  = 5.0
     * 75-79  = B+ = 4.5
     * 70-74  = B  = 4.0
     * 65-69  = C+ = 3.5
     * 60-64  = C  = 3.0
     * 55-59  = D+ = 2.5
     * 50-54  = D  = 2.0
     * 0-49   = F  = 0.0
     */
    public function calculate(float $totalMark): array
    {
        if ($totalMark >= 80) {
            return [
                'grade' => 'A',
                'grade_point' => 5.0,
            ];
        }

        if ($totalMark >= 75) {
            return [
                'grade' => 'B+',
                'grade_point' => 4.5,
            ];
        }

        if ($totalMark >= 70) {
            return [
                'grade' => 'B',
                'grade_point' => 4.0,
            ];
        }

        if ($totalMark >= 65) {
            return [
                'grade' => 'C+',
                'grade_point' => 3.5,
            ];
        }

        if ($totalMark >= 60) {
            return [
                'grade' => 'C',
                'grade_point' => 3.0,
            ];
        }

        if ($totalMark >= 55) {
            return [
                'grade' => 'D+',
                'grade_point' => 2.5,
            ];
        }

        if ($totalMark >= 50) {
            return [
                'grade' => 'D',
                'grade_point' => 2.0,
            ];
        }

        return [
            'grade' => 'F',
            'grade_point' => 0.0,
        ];
    }
}