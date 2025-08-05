<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BDiag extends Model
{
    protected $table = 'registry_b_diags';

    protected $fillable = [
        'diag_date',
        'diag_tip',
        'diag_code',
        'diag_rslt',
        'rec_rslt',
        'onk_sl_id'
    ];
}
