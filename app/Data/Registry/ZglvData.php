<?php

namespace App\Data\Registry;

use App\Models\RegistryFile;
use App\Models\Zglv;
use Spatie\LaravelData\Data;

class ZglvData extends Data
{
    public function __construct(
        public string $version,
        public string $data,
        public string $filename,
        public string $sd_z
    ) {

    }

    public function createModel(RegistryFile $registryFile): void
    {
        Zglv::create([
            ...$this->toArray(),
            'registry_file_id' => $registryFile->id
        ]);
    }
}
