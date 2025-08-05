<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnkUsl extends Model
{
    protected $table = 'registry_onk_usls';

    protected $fillable = [
        'usl_tip',
        'hir_tip',
        'lek_tip_l',
        'lek_tip_v',
        'pptr',
        'luch_tip',
        'onk_sl_id'
    ];
}
