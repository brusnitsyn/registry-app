<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MisStationarMedicalHistory extends Model
{
    protected $connection = 'mis';
    protected $table = 'stt_MedicalHistory';
    protected $primaryKey = 'MedicalHistoryID';

    public $timestamps = false;

    protected $hidden = [
        '*'
    ];

    protected $fillable = [
        'MedCardNum',
        'Address',
        'BD',
        'DateDirection',
        'DateExtract',
        'DateRecipient',
        'DateRecipientHS',
        'DurationHosp',
        'FAMILY',
        'Name',
        'OT',
    ];

    public function getCreatedAtColumn(): string
    {
        return 'CreateDate';
    }

    protected $casts = [
        'CreateDate' => 'datetime'
    ];

    public function medicalServices()
    {
        return $this->hasMany(MisStationarMedicalService::class, 'rf_MedicalHistoryID');
    }
}
