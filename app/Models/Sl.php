<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Sl extends Model
{
    protected $table = 'registry_sls';

    protected $fillable = [
        'sl_id',
        'lpu_1',
        'podr',
        'profil',
        'profil_k',
        'det',
        'p_cel',
        'nhistory',
        'p_per',
        'date_1',
        'date_2',
        'kd',
        'ds0',
        'ds1',
        'ds2',
        'ds3',
        'c_zab',
        'ds_onk',
        'dn',
        'code_mes1',
        'code_mes2',
        'reab',
        'prvs',
        'vers_spec',
        'iddokt',
        'ed_col',
        'tarif',
        'sum_m',
        'commentsl',
        'z_sl_id',
    ];

    protected function casts(): array
    {
        return [
            'ds2' => AsCollection::class,
            'ds3' => AsCollection::class,
        ];
    }

    /**
     * Вернет код типа отделения из podr
     * @return string
     */
    public function getParsedDepartmentAttribute(): string
    {
        $pattern = '/280003(\d)/';
        if (is_null($this->podr) || empty($this->podr)) return '0';
        return Str::match($pattern, $this->podr);
    }

    public function department()
    {
        return $this->belongsTo(LibDepartment::class, 'podr', 'podr');
    }

    public function usl(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Usl::class);
    }

    public function zSl()
    {
        return $this->belongsTo(ZSl::class);
    }

    public function zglv()
    {
        return $this->hasOneThrough(
            Zglv::class,
            ZSl::class,
            'id', // Foreign key on zsl table
            'id', // Foreign key on zglv table
            'z_sl_id', // Local key on sl table
            'zap_id' // Local key on zsl table
        );
    }

    /**
     * Вернет общую стоимость услуг
     * @return string
     */
    public function getCostSlAttribute(): string
    {
        return $this->usl()->sum('sumv_usl');
    }

    /**
     * Вернет детские услуги
     * @return Collection
     */
    public function getDetUslAttribute(): Collection
    {
        return $this->usl()->where('det', 1)->get();
    }

    /**
     * Вернет взрослые услуги
     * @return Collection
     */
    public function getOldUslAttribute(): Collection
    {
        return $this->usl()->where('det', 0)->get();
    }

    /**
     * Вернет детские случаи
     * @return Sl
     */
    public function getDetBuilder(string $podr): Builder
    {
        return $this->where('podr', $podr)->where('det', 1);
    }

    /**
     * Вернет взрослые случаи
     * @return Sl
     */
    public function getOldBuilder(): Builder
    {
        return $this->where('det', 0);
    }
}
