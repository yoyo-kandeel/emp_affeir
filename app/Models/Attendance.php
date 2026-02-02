<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Attendance extends Model
{
    use HasFactory;
    protected $fillable = ['employee_id','shift_id','date','check_in','check_out'];

    public function employee()
    {
        return $this->belongsTo(\App\Models\EmpData::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}

