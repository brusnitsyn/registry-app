<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibDepartment extends Model
{
    protected $fillable = [
        'podr',
        'name',
        'department_type_id',
    ];

    public function departmentType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(LibDepartmentType::class, 'department_type_id');
    }
}
