<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'name',
        'code',
        'award',
        'duration_years',
        'description',
        'is_active',
    ];

    protected $casts = [
        'duration_years' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * A program belongs to a department.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * A program has many students.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}