<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_start',
        'work_end',
        'grace_minutes',
        'late_penalty_per_minute',
        'absence_penalty_per_day',
        'bpjs_percent',
        'tax_percent',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'grace_minutes' => 'integer',
            'late_penalty_per_minute' => 'decimal:2',
            'absence_penalty_per_day' => 'decimal:2',
            'bpjs_percent' => 'decimal:2',
            'tax_percent' => 'decimal:2',
        ];
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
