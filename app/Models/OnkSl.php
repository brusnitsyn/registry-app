<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnkSl extends Model
{
    protected $table = 'registry_onk_sls';

    protected $fillable = [
        'ds1_t',
        'stad',
        'onk_t',
        'onk_n',
        'onk_m',
        'mtstz',
        'sod',
        'k_fr',
        'wei',
        'hei',
        'bsa',
        'sl_id'
    ];
}
