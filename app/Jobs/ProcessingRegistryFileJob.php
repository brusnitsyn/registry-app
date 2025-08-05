<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessingRegistryFileJob implements ShouldQueue
{
    use Batchable, Queueable;

    private string $fileXml;
    private string $registryFileName;

    /**
     * Create a new job instance.
     */
    public function __construct(string $fileXml, string $registryFileName)
    {
        $this->fileXml = $fileXml;
        $this->registryFileName = $registryFileName;
    }

    /**
     * Execute the job.
     * @throws ConnectionException
     */
    public function handle(): void
    {
        $fileContent = Storage::disk('temp')->get($this->fileXml);
        $fileName = basename($this->fileXml);

        $response = Http::timeout(600)
            ->attach('file', $fileContent, $fileName)
            ->post(config('services.parser.url') . "/api/v1/parse");

        if ($response->successful()) {
//            $data = $response->getBody()->getContents();
//            Storage::disk('temp')->put('json/' . $fileName . '.json', $data);
//            dispatch(new ProcessingRegistryRecord($data['registry'], $this->registryFileName));
        }
    }
}
