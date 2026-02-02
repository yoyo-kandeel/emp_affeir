<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LatenessRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_minutes',
        'to_minutes',
        'deduction_type',
        'deduction_value',
        'early_leave_type',
        'early_leave_value',
        'notes',
        'is_active'
    ];
}
