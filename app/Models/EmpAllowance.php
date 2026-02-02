<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmpAllowance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'emp_allowances';

    protected $fillable = [
        'allowance_name',
        'description',
        'year_id',
        'month_id',
        'created_by',
    ];

    // علاقة السنة
    public function year()
    {
        return $this->belongsTo(Years::class);
    }

    // علاقة الشهر
    public function month()
    {
        return $this->belongsTo(Months::class);
    }
}
