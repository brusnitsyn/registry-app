<?php

namespace App\Jobs;

use App\Models\RegistryCase;
use App\Models\RegistryFile;
use App\Models\RegistryPatient;
use App\Models\RegistryService;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Arr;

class ProcessingRegistryRecord implements ShouldQueue
{
    use Queueable, Batchable;

    private array $fileData;

    /**
     * Create a new job instance.
     */
    public function __construct(array $fileData)
    {
        $this->fileData = $fileData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Обработка файла
        $registry = RegistryFile::updateOrCreate(
            ['filename' => $this->fileData['filename']],
            Arr::except($this->fileData, ['records', 'count'])
        );

        foreach ($this->fileData['records'] as $record) {
            // Обработка пациента
            $patient = RegistryPatient::updateOrCreate(
                ['id_pac' => $record['patient']['guid']],
                $record['patient']
            );

            // Обработка случая
            if ($record['case']) {
                $case = RegistryCase::updateOrCreate(
                    ['id_case' => $record['case']['id']],
                    array_merge($record['case'], [
                        'patient_id' => $patient->id,
                        'registry_file_id' => $registry->id
                    ])
                );

                // Обработка услуг
                foreach ($record['case']['services'] as $service) {
                    RegistryService::updateOrCreate(
                        ['id_serv' => $service['guid']],
                        array_merge($service, ['case_id' => $case->id])
                    );
                }
            }
        }
    }
}
