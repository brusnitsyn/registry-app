<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RegistryService extends Model
{
    protected $fillable = [
        'id_serv',
        'code',
        'date_in',
        'date_out',
        'tariff',
        'sum',
        'count',
        'department_code', // as PODR
        'doctor_speciality',
        'doctor_id',
        'case_id'
    ];

    protected $appends = ['parsed_department'];

    public function case(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(RegistryCase::class, 'case_id');
    }

    /**
     * Вернет код типа отделения из department_code (PODR)
     * @return string
     */
    public function getParsedDepartmentAttribute(): string
    {
        $pattern = '/280003(\d)/';
        if (is_null($this->department_code)) return '0';
        return Str::match($pattern, $this->department_code);
    }
}
