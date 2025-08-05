<?php

namespace App\Imports;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeSheet;

class LibraryImport implements ToModel, WithStartRow, WithHeadingRow, WithEvents, WithBatchInserts, SkipsEmptyRows
{
    use RemembersRowNumber;

    protected LibraryMultiSheetImporter $sheetImporter;
    protected $modelClass;
    protected $modelName;
    protected $sheetName;
    protected $fieldMapping = [
        'p_cel',
        'vidpom',
        'profil',
        'is_det'
    ];

    public function __construct(LibraryMultiSheetImporter $sheetImporter)
    {
        $this->sheetImporter = $sheetImporter;
        // Отключаем автоматическое форматирование заголовков
//        \Maatwebsite\Excel\Imports\HeadingRowFormatter::default('none');
    }

    public function headingRow(): int { return 2; }
    public function startRow(): int { return 1; }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                $this->sheetName = $event->getSheet()->getTitle();

                $worksheet = $event->getSheet();

                if ($this->modelClass !== null) return;

                // Получаем модель из B1
                $this->modelName = $worksheet->getCell([2, 1])->getValue();
                $this->modelClass = $this->resolveModelClass($this->modelName);

                if (!$this->modelClass) {
                    Log::error("Модель {$this->modelName} не найдена для листа {$this->sheetName}");
                    $event->getConcernable()->skipSheet();
                    return;
                }

                $this->fieldMapping = $this->getFieldMapping();
                Log::info("Начало обработки листа {$this->sheetName} для модели {$this->modelName}");
            }
        ];
    }

    protected function resolveModelClass($modelName)
    {
        $modelClass = "App\\Models\\" . str_replace(' ', '', ucwords($modelName));

        if (class_exists($modelClass)) {
            return $modelClass;
        }

        // Попробуем добавить префикс Lib
        $modelClass = "App\\Models\\Lib" . str_replace(' ', '', ucwords($modelName));
        return class_exists($modelClass) ? $modelClass : null;
    }

    protected function getFieldMapping(): array
    {
        // Можно настроить разные маппинги для разных моделей
        $mappings = [
            'LibService' => [
                'name' => 'name',
                'code' => 'code',
                'usl_ok' => 'usl_ok',
                'vidpom' => 'vidpom',
                'for_pom' => 'for_pom',
                'profil' => 'profil',
                'profil_k' => 'profil_k',
                'p_cel' => 'p_cel',
                'idsp' => 'idsp',
                'cod_nom' => 'cod_nom',
                'is_det' => 'is_det',
                'begin_at' => 'begin_at',
                'end_at' => 'end_at',
            ],
        ];

        return $mappings[$this->modelName] ?? [
            'name' => 'name',
            'code' => 'code',
        ];
    }

    public function model(array $row)
    {
        $currentRowNumber = $this->getRowNumber();

        if ($currentRowNumber < 3) return;

        $data = [];

        foreach ($row as $header => $value) {
            $normalizedHeader = mb_strtolower(trim($header));
            foreach ($this->fieldMapping as $excelField => $dbField) {
                if (mb_strtolower(trim($excelField)) === $normalizedHeader && $value !== null) {
                    $data[$dbField] = $this->transformValue($dbField, $value);
                    break;
                } else if (mb_strtolower(trim($excelField)) === $normalizedHeader && $value === null) {
                    $data[$header] = $this->transformValue($header, $value);
                    break;
                }
            }
        }

        if (empty($data)) {
            return null;
        }

        try {
            return new $this->modelClass($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
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

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 500;
    }
}
