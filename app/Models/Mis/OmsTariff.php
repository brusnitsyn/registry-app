<?php

namespace App\Models\Mis;

use Illuminate\Database\Eloquent\Model;

class OmsTariff extends Model
{
    protected $connection = 'mis';
    protected $table = 'oms_Tariff';
    protected $primaryKey = 'TariffID';

    public $timestamps = false;
}
