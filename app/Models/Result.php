<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_enrollment_id',
        'coursework_mark',
        'final_exam_mark',
        'total_mark',
        'grade',
        'grade_point',
        'credit_units',
        'status',
        'remarks',
        'entered_by',
        'submitted_at',
        'approved_at',
        'published_at',
    ];

    protected $casts = [
        'coursework_mark' => 'decimal:2',
        'final_exam_mark' => 'decimal:2',
        'total_mark' => 'decimal:2',
        'grade_point' => 'decimal:2',
        'credit_units' => 'decimal:1',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    /**
     * A result belongs to a course enrollment.
     */
    public function courseEnrollment(): BelongsTo
    {
        return $this->belongsTo(CourseEnrollment::class);
    }

    /**
     * A result belongs to the user who entered it.
     */
    public function enteredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'entered_by');
    }

    /**
     * A result can have many approval actions.
     */
    public function approvals(): HasMany
    {
        return $this->hasMany(ResultApproval::class);
    }
}