<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'division_id',
        'position_id',
        'nik',
        'name',
        'address',
        'phone',
        'join_date',
        'status',
        'base_salary',
    ];

    protected function casts(): array
    {
        return [
            'join_date' => 'date',
            'base_salary' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function payrolls(): HasMany
    {
        return $this->hasMany(Payroll::class);
    }

    public function salaryComponents(): BelongsToMany
    {
        return $this->belongsToMany(SalaryComponent::class, 'employee_salary_components')
            ->withPivot(['amount', 'is_active', 'effective_from', 'effective_to'])
            ->withTimestamps();
    }
}
