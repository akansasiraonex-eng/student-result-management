<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'lecturer_id',
        'semester_id',
        'is_primary',
        'is_active',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * A course assignment belongs to a course.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * A course assignment belongs to a lecturer.
     */
    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class);

    }
    
    
    /**
     * A course assignment belongs to a semester.
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }
}