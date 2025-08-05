<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schet extends Model
{
    protected $table = 'registry_schets';

    protected $fillable = [
        'code',
        'code_mo',
        'year',
        'month',
        'nschet',
        'dschet',
        'plat',
        'summav',
        'comments',
        'summap',
        'sank_mek',
        'sank_mee',
        'sank_ekmp',
        'zglv_id'
    ];
}
