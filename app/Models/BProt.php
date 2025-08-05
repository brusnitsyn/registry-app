<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BProt extends Model
{
    protected $table = 'registry_b_prots';

    protected $fillable = [
        'prot',
        'd_prot',
        'onk_sl_id'
    ];
}
