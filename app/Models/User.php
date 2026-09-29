<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Student;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Attributes that can be mass assigned.
     */
    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
];

    /**
     * Attributes hidden from serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * A user may have a student profile.
     */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    /**
     * A user may have a lecturer profile.
     */
    public function lecturer(): HasOne
    {
        return $this->hasOne(Lecturer::class);
    }

    /**
     * A user can enter many results.
     */
    public function enteredResults(): HasMany
    {
        return $this->hasMany(Result::class, 'entered_by');
    }

    /**
     * A user can perform many result approval actions.
     */
    public function resultApprovals(): HasMany
    {
        return $this->hasMany(ResultApproval::class, 'approved_by');
    }

    /**
     * A user can have many audit log records.
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }
    public function isAdmin(): bool
{
    return $this->role === 'admin';
}

public function isLecturer(): bool
{
    return $this->role === 'lecturer';
}

public function isRegistrar(): bool
{
    return $this->role === 'registrar';
}

public function isStudent(): bool
{
    return $this->role === 'student';
}

public function isFinance(): bool
{
    return $this->role === 'finance';
}
}
