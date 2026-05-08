<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalaryComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'is_percentage',
        'is_fixed',
        'default_amount',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_percentage' => 'boolean',
            'is_fixed' => 'boolean',
            'default_amount' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function employeeAssignments(): HasMany
    {
        return $this->hasMany(EmployeeSalaryComponent::class);
    }

    public function payrollItems(): HasMany
    {
        return $this->hasMany(PayrollItem::class);
    }
}
