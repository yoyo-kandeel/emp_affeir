<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'english_name',
        'tax_number',
        'commercial_register',
        'phone',
        'email',
        'website',
        'address',
        'description',
        'logo',
        'created_by',
    ];
}
