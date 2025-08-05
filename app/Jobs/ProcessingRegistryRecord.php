<?php

namespace App\Jobs;

use App\Data\Registry\Onko\ZapData;
use App\Data\Registry\SchetData;
use App\Data\Registry\ZglvData;
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
    private string $registryName;
    private ZglvData $zglv;
    private SchetData $schet;
    private array $zaps;

    /**
     * Create a new job instance.
     */
    public function __construct(array $fileData, string $registryName)
    {
        $this->fileData = $fileData;
        $this->registryName = $registryName;

        $this->zglv = ZglvData::from($this->fileData['zglv']);
        $this->schet = SchetData::from($this->fileData['schet']);
        $this->zaps = $this->fileData['zap'];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $registryFile = RegistryFile::create([
            'filename' => $this->registryName,
            'registry_type' => $this->fileData['type'],
            'version' => $this->zglv->version,
            'creation_date' => $this->zglv->data,
        ]);

        $this->zglv->createModel($registryFile);
        $this->schet->createModel($registryFile);

        $this->processZapInChunks(1, $registryFile);
    }

    protected function processZapInChunks(int $chunkSize, RegistryFile $registryFile): void
    {
        foreach (array_chunk($this->zaps, $chunkSize) as $chunk) {
            foreach ($chunk as $chunkData) {
                ZapData::from($chunkData)->createModels($registryFile);
            }
        }
    }
}
