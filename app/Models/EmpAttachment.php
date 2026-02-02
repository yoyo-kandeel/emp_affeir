<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpAttachment
 extends Model
{
    use HasFactory;
    protected $fillable = [
        'emp_data_id',
        'file_path',
        'file_type',
        'file_name',
 
        'created_by',
    ];
    public function employee()
{
    return $this->belongsTo(EmpData::class, 'emp_data_id');
}
}
