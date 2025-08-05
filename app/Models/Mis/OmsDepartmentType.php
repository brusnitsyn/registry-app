<?php

namespace App\Models\Mis;

use Illuminate\Database\Eloquent\Model;

class OmsDepartmentType extends Model
{
    protected $connection = 'mis';
    protected $table = 'oms_kl_DepartmentType';
    protected $primaryKey = 'kl_DepartmentTypeID';

    public $timestamps = false;

    protected $visible = [
        'kl_DepartmentTypeID',
        'Code',
        'Name',
        'Date_B',
        'Date_E',
    ];
}
