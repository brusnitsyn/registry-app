<?php

namespace App\Models;

use App\Models\Mis\OmsDepartment;
use Illuminate\Database\Eloquent\Model;

class MisStationarBranch extends Model
{
    protected $connection = 'mis';
    protected $table = 'stt_StationarBranch';
    protected $primaryKey = 'StationarBranchID';

    public $timestamps = false;

    protected $visible = [
        'StationarBranchID',
        'rf_DepartmentID',
        'rf_StationarTypeID',
        'rf_BedProfileID',
        'IsHospitalWard',
        'rf_CalculateMethodID',
        'medicalServices',
        'department'
    ];

    protected $casts = [];

    public function medicalServices(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MisStationarMedicalService::class, 'rf_StationarBranchID');
    }

    public function department(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OmsDepartment::class, 'rf_DepartmentID');
    }
}
