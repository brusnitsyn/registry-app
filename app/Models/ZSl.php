<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Model;

class ZSl extends Model
{
    protected $table = 'registry_zsls';

    protected $fillable = [
        'idcase',
        'usl_ok',
        'vidpom',
        'for_pom',
        'npr_mo',
        'npr_date',
        'lpu',
        'p_otk',
        'date_z_1',
        'date_z_2',
        'kd_z',
        'vnov_m',
        'rslt',
        'ishod',
        'os_sluch',
        'vb_p',
        'idsp',
        'sumv',
        'oplata',
        'sump',
        'sank_it',
        'zap_id'
    ];

    protected function casts(): array
    {
        return [
            'os_sluch' => AsCollection::class
        ];
    }

    public function zap()
    {
        return $this->belongsTo(Zap::class);
    }

    public function sl()
    {
        return $this->hasMany(Sl::class);
    }
}
