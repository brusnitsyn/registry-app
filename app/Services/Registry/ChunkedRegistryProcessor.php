<?php

namespace App\Services\Registry;

use App\Models\RegistryFile;
use App\Models\Schet;
use App\Models\Zglv;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use JsonStreamingParser\Parser;

class ChunkedRegistryProcessor
{
    public function process(string $filePath, string $mainFileName, string $registryType): bool
    {
        $stream = fopen($filePath, 'r');

        try {
            $registryFile = null;
            $success = true;

            $listener = new StreamingZapListener(
                function (array $zapItem, array $registryItem) use (&$registryFile, $mainFileName, $registryType, &$success) {
                    DB::transaction(function () use (&$registryFile, $zapItem, $registryItem, $mainFileName, $registryType) {
                        if ($registryFile === null) {
                            $registryFile = RegistryFile::create([
                                'filename' => $registryItem['zglv']['filename'],
                                'registry_type' => $registryItem['type'],
                                'version' => $registryItem['zglv']['version'],
                                'creation_date' => $registryItem['zglv']['data'],
                            ]);
                        }

                        $zapData = \App\Data\Registry\Onko\ZapData::from($zapItem);
                        $zapData->createModels($registryFile);
                    });
                }
            );

            $parser = new Parser($stream, $listener);
            $parser->parse();

            return true;
        } catch (\Exception $e) {
            Log::error("Processing error: " . $e->getMessage());
            return false;
        } finally {
            if (is_resource($stream)) {
                fclose($stream);
            }
        }
    }

    private function createRegistryFile(array $registryItem): RegistryFile
    {
        $registryType = $registryItem['type'];
        $zglvData = $registryItem['zglv'];
        $schetData = $registryItem['schet'];

        $registryFile = RegistryFile::create([
            'filename' => $zglvData['filename'],
            'registry_type' => $registryType,
            'version' => $zglvData['version'] ?? null,
            'creation_date' => $zglvData['data'] ?? null,
        ]);


        $zglv = Zglv::create([
            ...$zglvData,
            'registry_file_id' => $registryFile->id
        ]);

        $schet = Schet::create([
            ...$schetData,
            'registry_file_id' => $registryFile->id
        ]);

        // Здесь можно сохранить zglv и schet если нужно
        return $registryFile;
    }

    private function processSingleZap(array $zapItem, RegistryFile $registryFile): void
    {
        // Преобразуем в DTO и сохраняем
        $zapData = \App\Data\Registry\Onko\ZapData::from($zapItem);
        $zapData->createModels($registryFile);
    }
}
