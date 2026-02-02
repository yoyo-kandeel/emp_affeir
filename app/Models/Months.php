<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Months extends Model
{
    use HasFactory;
    protected $fillable = [
        'year_id',
        'month_number',
        'month_name',
    ];
    public function year()
    {
        return $this->belongsTo(Years::class, 'year_id');
    }
}
