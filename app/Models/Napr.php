<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Napr extends Model
{
    protected $table = 'registry_naprs';

    protected $fillable = [
        'napr_date',
        'napr_mo',
        'napr_v',
        'met_issl',
        'napr_usl',
        'sl_id'
    ];
}
