<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    use HasFactory;

    protected $table = 'attendance_logs';
    protected $fillable = ['emp_data_id','fingerprint_device_id','print_id','log_date','log_time','type'];


    // علاقة الموظف
  public function employee()
{
    return $this->belongsTo(\App\Models\EmpData::class, 'emp_data_id', 'id');
}

public function device()
{
    return $this->belongsTo(\App\Models\FingerprintDevice::class, 'fingerprint_device_id', 'id');
}
    
}
