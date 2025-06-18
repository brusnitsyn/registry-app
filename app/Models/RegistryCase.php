<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistryCase extends Model
{
    protected $fillable = [
        'id_case',
        'treatment_type',
        'result',
        'outcome',
        'total_sum',
        'diagnosis',
        'patient_id',
        'registry_file_id'
    ];

    public function patient(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(RegistryPatient::class, 'patient_id');
    }

    public function services(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RegistryService::class, 'case_id');
    }

    public function registry_file(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(RegistryFile::class, 'registry_file_id');
    }
}
