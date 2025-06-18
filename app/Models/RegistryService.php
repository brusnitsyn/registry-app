<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistryService extends Model
{
    protected $fillable = [
        'id_serv',
        'code',
        'date_in',
        'date_out',
        'tariff',
        'sum',
        'count',
        'department_code', // as PODR
        'doctor_speciality',
        'doctor_id',
        'case_id'
    ];

    public function case(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(RegistryCase::class, 'case_id');
    }
}
