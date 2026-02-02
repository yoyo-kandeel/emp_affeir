<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
class EmpSalary extends Model
{
    use HasFactory, SoftDeletes; 

    protected $table = 'emp_salaries';

    protected $fillable = [
        'emp_id',
        'year_id',
        'month_id',
        'basic_salary',
        'working_days',
        'daily_rate',
        'hourly_rate',
        'advance',
        'insurance_status',
        'insurance_amount',
        'absence_days',
        'delay_hours',
        'penalties',
        'total_deductions',
        'total_allowances',
        'net_salary',
        'payment_number'
    ];

    public function emp()
    {
        return $this->belongsTo(EmpData::class, 'emp_id');
    }

    public function year()
    {
        return $this->belongsTo(Years::class, 'year_id');
    }

    public function month()
    {
        return $this->belongsTo(Months::class, 'month_id');
    }

    public function allowances()
    {
        return $this->hasMany(SalaryAllowance::class);
    }

}
