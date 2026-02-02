<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class jobs extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'job_name',
        'department_id',
        'description',
        'created_by',
        
    ];
               protected $dates = ['deleted_at']; 

    public function department()
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }
}
