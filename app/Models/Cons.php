<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cons extends Model
{
    protected $table = 'registry_cons';

    protected $fillable = [
        'pr_cons',
        'dt_cons',
        'sl_id'
    ];
}
