<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LekPr extends Model
{
    protected $table = 'registry_lek_prs';

    protected $fillable = [
        'regnum',
        'regnum_dop',
        'code_sh',
        'onk_usl_id'
    ];
}
