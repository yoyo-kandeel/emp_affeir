<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryAllowance extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_salary_id','allowance_id','amount'
    ];

    public function allowance()
    {
        return $this->belongsTo(EmpAllowance::class);
    }
}
