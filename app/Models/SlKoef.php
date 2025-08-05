<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlKoef extends Model
{
    protected $table = 'registry_sl_koefs';

    protected $fillable = [
        'idsl',
        'z_sl',
        'ksg_kpg_id',
    ];
}
