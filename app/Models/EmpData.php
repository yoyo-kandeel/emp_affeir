<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\departments;
use App\Models\Jobs;
use App\Models\EmpAttachment;
use App\Models\User;
use App\Models\emp_employment;


class EmpData extends Model
{
    use HasFactory, SoftDeletes;

    // اسم الجدول إذا كان غير مطابق للقواعد الافتراضية
    protected $table = 'emp_datas';

    // الحقول التي يمكن ملؤها بشكل جماعي
    protected $fillable = [
               'emp_number',  
        'full_name',
        'birth_date',
        'birth_place',
        'gender',
        'nationality',
        'marital_status',
        'children_count',
        'national_id',
        'phone',
        'address',
        'status_service',
        'experience',
        'certificate',
        'hire_date',
        'department_id',
        'job_id',
        'status',
        'notes',
        'profile_image',
        'created_by',
        'print_id',
        'english_name',
        'computer_skills',
        'english_proficiency',
        'religion',
    ];

    // التحويلات (اختياري: تحويل الحقول إلى نوع معين تلقائيًا)
    protected $casts = [
        'birth_date' => 'date',
        'hire_date' => 'date',
    ];
   
    // العلاقات
// علاقة الموظف بالمرفقات
public function attachments()
{
    return $this->hasMany(EmpAttachment::class, 'emp_data_id');
}

    // علاقة الموظف بالقسم
    public function department()
    {
        return $this->belongsTo(departments::class, 'department_id')->withDefault();
    }

    // علاقة الموظف بالوظيفة
    public function job()
    {
        return $this->belongsTo(Jobs::class, 'job_id')->withDefault();
    }

    // يمكن إضافة علاقة المستخدم الذي أنشأ الموظف
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'name');
    }
public function emp_employment()
{
    return $this->hasOne(emp_employment::class, 'emp_id', 'id');
}
public function fingerprintDevice()
{
    return $this->belongsTo(FingerprintDevice::class);
}
public function attendanceLogs()
{
    return $this->hasMany(\App\Models\AttendanceLog::class);
}

public function fingerprintDevices()
{
    return $this->belongsToMany(
        \App\Models\FingerprintDevice::class, // الموديل التابع
        'emp_data_fingerprint_device',        // جدول الربط
        'emp_data_id',                        // المفتاح في الجدول الحالي
        'fingerprint_device_id'               // المفتاح في جدول الأجهزة
    );
}
public function deductions() {
    return $this->hasMany(EmpDeduction::class, 'emp_data_id');
}

public function salaryAllowances() {
    return $this->hasMany(SalaryAllowance::class, 'emp_salary_id'); // أو حسب اسم جدول البدلات
}
public function employmentData(){ return $this->hasOne(emp_employment::class,'emp_id'); }
public function salaries(){ return $this->hasMany(EmpSalary::class,'emp_id'); }

}
