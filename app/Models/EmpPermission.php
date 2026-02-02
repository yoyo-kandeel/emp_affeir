<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmpPermission extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'emp_permissions';

    protected $fillable = [
        'emp_data_id',
        'year_id',
        'month_id',
        'permission_date',
        'from_datetime',
        'to_datetime',
        'permission_type',
        'with_deduction',
        'notes',
        'created_by',
    ];

    // ===== أنواع الإذن =====
    const TYPE_EXIT   = 1; // خروج
    const TYPE_ABSENT = 2; // غياب
    const TYPE_LEAVE  = 3; // انصراف

    // ===== العلاقات =====
    public function employee()
    {
        return $this->belongsTo(EmpData::class, 'emp_data_id');
    }

    public function year()
    {
        return $this->belongsTo(Years::class, 'year_id');
    }

    public function month()
    {
        return $this->belongsTo(Months::class, 'month_id');
    }
}
