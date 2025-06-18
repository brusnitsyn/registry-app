<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibLpu extends Model
{
    protected $fillable = [
        'name',
        'mcode',
        'code',
        'federal_code'
    ];
}
