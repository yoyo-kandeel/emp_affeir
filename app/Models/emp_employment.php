<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\EmpData;

class emp_employment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'employment_data';
    protected $fillable = [
        'emp_id',
        'basic_salary',
        'insured',
        'insurance_date',
        'insurance_rate',
        'insurance_amount',
        'insurance_number',
        'created_by',
    ];
    public function employee()
    {
        return $this->belongsTo(EmpData::class, 'emp_id');
    }
    

}
