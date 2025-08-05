<?php

namespace App\Imports;

use App\Models\LibService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class LibServiceImport implements ToModel, WithHeadingRow, WithStartRow, WithBatchInserts, WithChunkReading, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $data = [];

        foreach ($row as $header => $value) {
            $data += [$header => $this->transformValue($header, $value)];
        }

        // Если обьект пуст
        if (empty($data)) {
            return null;
        }

        // Если есть уже услуга
        $exist = LibService::whereCode($data['code'])
            ->whereBeginAt($data['begin_at'])
            ->whereEndAt($data['end_at'])
            ->first();

        if ($exist) {
            return null;
        }

        try {
            return new LibService($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function headerRow(): int
    {
        return 2;
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    protected function transformValue($field, $value)
    {
        if ($field === 'is_active') {
            return in_array(mb_strtolower($value), ['да', 'yes', 'true', '1', 'активно']);
        }

        if ($field === 'p_cel') {
            return array($value);
        }

        if ($field === 'vidpom') {
            return array($value);
        }

        if ($field === 'profil') {
            return array($value);
        }

        if ($field === 'is_det') {
            return is_null($value) ? 0 : 1;
        }

        if ($field === 'begin_at') {
            return Carbon::parse($value)->toDateTimeLocalString();
        }

        if ($field === 'end_at') {
            return Carbon::parse($value)->toDateTimeLocalString();
        }

        return $value;
    }
}
