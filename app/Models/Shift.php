<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Shift extends Model
{
    use HasFactory;

    protected $fillable = ['name','start_time','end_time','description'];

   
    
    // علاقة الموظف
  public function employee()
{
    return $this->belongsTo(\App\Models\EmpData::class, 'employee_shift')->withPivot('date');
}
}
