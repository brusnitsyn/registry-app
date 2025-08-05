<?php

namespace App\Models;

use App\Models\Mis\OmsServiceMedical;
use App\Models\Mis\OmsTariff;
use Illuminate\Database\Eloquent\Model;

class MisStationarMedicalService extends Model
{
    protected $connection = 'mis';
    protected $table = 'stt_MedServicePatient';
    protected $primaryKey = 'MedServicePatientID';

    public $timestamps = false;

//    protected $visible = [
//        'MedServicePatientID',
//        'UGUID',
//        'Date',
//        'Count',
//        'flagBill',
//        'flagComplete',
//        'flagPay',
//        'flagStatic',
//        'PercentComplete',
//        'rf_MedicalHistoryID',
//        'rf_MKBID',
//        'rf_ServiceMedicalID',
//        'DateEnd',
//        'in_registry',
//        'registry_name',
//        // Отношения
//        'medicalHistory',
//        'stationarBranch',
//        'serviceMedical'
//    ];

    protected $fillable = [
        'Date',
        'Count',
        'flagBill',
        'flagComplete',
        'flagPay',
        'flagStatic',
        'PercentComplete',
        'rf_MedicalHistoryID',
        'rf_MKBID',
        'rf_ServiceMedicalID',
        'DateEnd'
    ];

    protected $casts = [
        'Date' => 'datetime',
        'Count' => 'float',
    ];

    public function getCreatedAtColumn(): string
    {
        return 'Date';
    }

    public function medicalHistory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MisStationarMedicalHistory::class, 'rf_MedicalHistoryID');
    }

    public function stationarBranch(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MisStationarBranch::class, 'rf_StationarBranchID');
    }

    public function serviceMedical(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OmsServiceMedical::class, 'rf_ServiceMedicalID');
    }

    public function tariff()
    {
        return $this->belongsTo(OmsTariff::class, 'rf_TariffID');
    }

    public function registryUsl()
    {
        return $this->belongsTo(Usl::class, 'UGUID', 'idserv');
    }
}
