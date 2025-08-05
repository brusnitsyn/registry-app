<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KsgKpg extends Model
{
    protected $table = 'registry_ksg_kpgs';

    protected $fillable = [
        'n_ksg',
        'ver_ksg',
        'ksg_pg',
        'n_kpg',
        'koef_z',
        'koef_up',
        'bztsz',
        'koef_d',
        'koef_u',
        'k_zp',
        'crit',
        'sl_k',
        'it_sl',
        'sl_id'
    ];
}
