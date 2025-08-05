<?php

namespace App\Models\Mis;

use Illuminate\Database\Eloquent\Model;

class OmsServiceMedical extends Model
{
    protected $connection = 'mis';
    protected $table = 'oms_ServiceMedical';
    protected $primaryKey = 'ServiceMedicalID';

    public $timestamps = false;

    protected $visible = [
        'ServiceMedicalID',
        'ServiceMedicalCode',
        'ServiceMedicalName',
        'rf_kl_MedCareTypeID',
        'rf_kl_MedCareUnitID',
        'rf_kl_NomServiceID',
        'rf_kl_AgeGroupID',
        'rf_kl_DepartmentTypeID',
        'rf_kl_DepartmentProfileID',
        'rf_PRVSID',
        'Date_B',
        'Date_E',
        'FCode_Usl',
        'rf_kl_ProfitTypeID',
    ];
}
