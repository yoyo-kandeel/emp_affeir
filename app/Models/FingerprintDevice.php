<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FingerprintDevice extends Model
{
    use HasFactory;
      protected $fillable = [
        'name',
        'ip_address',
        'port',
        'comm_key',
        'type',
        'is_active'
    ];
    public function employees()
{
    return $this->belongsToMany(
        \App\Models\EmpData::class,
        'emp_data_fingerprint_device',
        'fingerprint_device_id',
        'emp_data_id'
    );
}

}
