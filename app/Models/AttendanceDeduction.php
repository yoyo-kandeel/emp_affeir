<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceDeduction extends Model
{
    use HasFactory;

    protected $table = 'attendance_deductions';

    protected $fillable = [
        'emp_data_id',
        'date',
        'lateness_deduction',
        'early_leave_deduction',
        'total_deduction',
    ];

    public function employee()
    {
        return $this->belongsTo(EmpData::class, 'emp_data_id');
    }
}
