<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Usl extends Model
{
    protected $table = 'registry_usls';
    protected $connection = 'pgsql';

    protected $fillable = [
        'idserv',
        'lpu',
        'lpu_1',
        'podr',
        'profil',
        'vid_vme',
        'det',
        'date_in',
        'date_out',
        'ds',
        'code_usl',
        'kol_usl',
        'tarif',
        'sumv_usl',
        'prvs',
        'p_otk',
        'code_md',
        'npl',
        'comentu',
        'sl_id'
    ];

    /**
     * Вернет код типа отделения из podr
     * @return string
     */
    public function getParsedDepartmentAttribute(): string
    {
        $pattern = '/280003(\d)/';
        if (is_null($this->podr)) return '0';
        return Str::match($pattern, $this->podr);
    }

    public function department(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        /*
            Используется для подстановки в реестрах типа
            STAGE1_REPRODUCTIVE
            MINORS_CHECKUPS
            ADULT_CHECKUPS
            STAGE1_ADULT
            WARDS_SCREENING
            STAGE2_ADULT
        */
        $nullablePodrInRegistryType = [
            'STAGE1_REPRODUCTIVE',
            'MINORS_CHECKUPS',
            'ADULT_CHECKUPS',
            'STAGE1_ADULT',
            'WARDS_SCREENING',
            'STAGE2_ADULT',
        ];
        $defaultDepartment = LibDepartment::whereLike('name', 'Амбулаторно%')->first();

        if (Arr::exists($nullablePodrInRegistryType, $this->getRegistryType())) {
            return $this->belongsTo(LibDepartment::class, 'podr', $defaultDepartment->podr);
        }

        return $this->belongsTo(LibDepartment::class, 'podr', 'podr');
    }

    public function sl(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Sl::class, 'sl_id');
    }

    public function getRegistryName()
    {
        return $this->sl->zSl->zap->zglv->registryFile->name;
    }

    public function getRegistryType()
    {
        return $this->sl->zSl->zap->zglv->type;
    }
}
