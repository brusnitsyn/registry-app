<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zglv extends Model
{
    protected $table = 'registry_zglvs';

    protected $fillable = [
        'version',
        'data',
        'filename',
        'sd_z',
        'type',
        'registry_file_id'
    ];

    public function registryFile()
    {
        return $this->belongsTo(RegistryFile::class, 'registry_file_id');
    }

    public function zap()
    {
        return $this->hasMany(Zap::class);
    }

    public function usls()
    {
        $zglvId = $this->id;

        return Usl::whereHas('sl.zSl.zap.zglv', function($q) use ($zglvId) {
            $q->whereId($zglvId);
        })->get();

    }

    public function relationUsls()
    {
        $instance = new Usl;
        $relation = $instance->newQuery();

        return $relation->whereHas('sl.zSl.zap', function($q) {
            $q->where('zglv_id', $this->id);
        });
    }
}
