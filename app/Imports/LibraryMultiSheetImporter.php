<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Excel;

class LibraryMultiSheetImporter implements WithMultipleSheets, WithChunkReading
{

    public function sheets(): array
    {
        return [
            new LibraryImport($this), // Передаем текущий объект для связи
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
