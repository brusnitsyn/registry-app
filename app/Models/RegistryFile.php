<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistryFile extends Model
{
    protected $table = 'registry_files';

    protected $fillable = [
        'name',
        'creation_date',
    ];

    public function zglvs()
    {
        return $this->hasMany(Zglv::class);
    }

    public function usls()
    {
        // Сначала получаем все zglv, связанные с RegistryFile
        $zglvIds = $this->zglvs()->pluck('id');

        // Затем получаем все usl, связанные через цепочку
        return Usl::whereHas('sl.zSl.zap.zglv', function($q) use ($zglvIds) {
            $q->whereIn('id', $zglvIds);
        })->get();

    }
}
