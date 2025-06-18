<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistryPatient extends Model
{
    protected $fillable = [
        'id_pac',
        'polis_type',
        'polis_number',
        'smo_code',
        'is_newborn',
        'is_invalid',
    ];
}
