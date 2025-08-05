<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibService extends Model
{
    protected $connection = 'pgsql';

    protected $fillable = [
        'code',
        'name',
        'usl_ok',
        'vidpom',
        'for_pom',
        'profil',
        'profil_k',
        'p_cel',
        'idsp',
        'cod_nom',
        'is_det',
        'begin_at',
        'end_at',
        'parent_service_id',
    ];

    protected function casts()
    {
        return [
            'p_cel' => 'array',
            'vidpom' => 'array',
            'profil' => 'array',
            'idsp' => 'array',
        ];
    }
}
