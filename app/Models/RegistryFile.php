<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistryFile extends Model
{
    protected $fillable = [
        'filename',
        'registry_type',
        'version',
        'creation_date',
    ];
}
