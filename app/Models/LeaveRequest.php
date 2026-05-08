<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveRequest extends Model
{
    protected $fillable = [
        'employee_id', 'leave_type', 'start_date', 'end_date',
        'total_days', 'reason', 'status', 'approved_by', 'approved_at', 'approver_notes',
    ];

    protected $casts = [
        'start_date'  => 'date',
        'end_date'    => 'date',
        'approved_at' => 'datetime',
    ];

    public static array $typeLabels = [
        'annual' => 'Cuti Tahunan',
        'sick'   => 'Sakit',
        'unpaid' => 'Cuti Tanpa Bayar',
        'other'  => 'Lainnya',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }

    public function isPaid(): bool
    {
        return in_array($this->leave_type, ['annual', 'sick', 'other']);
    }
}
