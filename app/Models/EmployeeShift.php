<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeShift extends Model
{
    use HasFactory;

    protected $table = 'employee_shift'; // اسم الجدول

    protected $fillable = [
        'emp_data_id',
        'shift_id',
        'from_date',
        'to_date',
        'work_days',
    ];

    protected $casts = [
        'from_date' => 'date',
        'to_date'   => 'date',
    ];

    // علاقة الموظف
    public function employee()
    {
        return $this->belongsTo(EmpData::class, 'emp_data_id');
    }

    // علاقة الوردية
    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
}
