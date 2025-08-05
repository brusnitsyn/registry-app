<?php

namespace App\Data\Registry\Onko;

use App\Data\Registry\SchetData;
use App\Data\Registry\ZglvData;
use App\Models\RegistryFile;
use App\Models\Schet;
use App\Models\Zglv;
use Generator;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\Data;

class RegistryData extends Data
{
    public function __construct(
        public ZglvData $zglv,
        public SchetData $schet,
        /** @var Generator */
        private array $zapRaw
    ) {

    }

    public function processZapInChunks(int $chunkSize, callable $callback): void
    {
        foreach (array_chunk($this->zapRaw, $chunkSize) as $chunk) {
            $zapItems = array_map(fn($item) => ZapData::from($item), $chunk);
            $callback($zapItems);

            // Очищаем память
            unset($zapItems, $chunk);
            gc_collect_cycles();
        }
    }

    public static function fromArray(array $data): static
    {
        return new static(
            ZglvData::from($data['zglv']),
            SchetData::from($data['schet']),
            $data['zap']
        );
    }

    public function createModels(string $mainFileName, string $registryType): void
    {
        DB::transaction(function () use ($mainFileName, $registryType) {
            $registryFile = RegistryFile::create([
                'filename' => $mainFileName,
                'registry_type' => $registryType,
                'version' => $this->zglv->version,
                'creation_date' => $this->zglv->data,
            ]);

            $zglv = Zglv::create([
                ...$this->zglv->toArray(),
                'registry_file_id' => $registryFile->id
            ]);

            $schet = Schet::create([
                ...$this->schet->toArray(),
                'registry_file_id' => $registryFile->id
            ]);

            $this->processZapInChunks(20, function (array $zapItems) use ($registryFile) {
                foreach ($zapItems as $zapItem) {
                    dd($zapItem);
                    $zapItem->createModels($registryFile);
                }
            });

//            foreach ($this->getZapItems() as $zapData) {
//                $zapData->createModels($registryFile);
//            }
        });
    }
}
