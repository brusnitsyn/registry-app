<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pacient extends Model
{
    protected $table = 'registry_pacients';

    protected $fillable = [
        'id_pac',
        'vpolis',
        'spolis',
        'npolis',
        'enp',
        'st_okato',
        'smo',
        'smo_ogrn',
        'smo_ok',
        'smo_nam',
        'inv',
        'mse',
        'novor',
        'vnov_d',
        'soc',
        'zap_id'
    ];
}
