<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibDoctor extends Model
{
    protected $fillable = [
        'code',
        'last_name',
        'first_name',
        'middle_name',
    ];
}
