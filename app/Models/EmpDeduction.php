<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmpDeduction extends Model
{
use HasFactory, SoftDeletes; 
    protected $table = 'emp_deductions';

     protected $fillable = [
        'emp_data_id',
        'year_id',      
        'month_id',
        'deduction_type',
        'quantity',
        'created_by',
    ];


    // علاقة بالموظف
    public function employee()
    {
        return $this->belongsTo(EmpData::class, 'emp_data_id');
    }

    // علاقة بالسنة
    public function year()
    {
        return $this->belongsTo(Years::class, 'year_id');
    }

    // علاقة بالشهر
    public function month()
    {
        return $this->belongsTo(Months::class, 'month_id');
    }
    public function emp_data()
{
    return $this->belongsTo(EmpData::class, 'emp_data_id');
}

}
