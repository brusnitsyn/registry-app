<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zap extends Model
{
    protected $table = 'registry_zaps';

    protected $fillable = [
        'n_zap',
        'pr_nov',
        'zglv_id'
    ];

    public function zglv()
    {
        return $this->belongsTo(Zglv::class, 'zglv_id');
    }

    public function ZSl()
    {
        return $this->hasMany(ZSl::class);
    }
}
