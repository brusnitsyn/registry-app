<?php

namespace App\Models\Mis;

use Illuminate\Database\Eloquent\Model;

class OmsDepartment extends Model
{
    protected $connection = 'mis';
    protected $table = 'oms_Department';
    protected $primaryKey = 'DepartmentID';

    public $timestamps = false;

    protected $visible = [
        'DepartmentID',
        'DepartmentCODE',
        'DepartmentNAME',
        'rf_kl_DepartmentTypeID',
        'rf_kl_DepartmentProfileID',
        'Rem',
        'GUIDDepartment',
        'Code_Department',
        'Date_B',
        'Date_E',
        'OID',
        'type'
    ];

    public function type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OmsDepartmentType::class, 'rf_kl_DepartmentTypeID');
    }
}
