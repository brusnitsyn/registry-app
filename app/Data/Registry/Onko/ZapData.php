<?php

namespace App\Data\Registry\Onko;

use App\Data\Registry\Base\PacientData;
use App\Models\RegistryFile;
use App\Models\Zap;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class ZapData extends Data
{
    public function __construct(
        public string|Optional $n_zap,
        public string|Optional $pr_nov,
        public PacientData $pacient,
        public ZSlData $z_sl,
    ) {

    }

    public function createModels(RegistryFile $registryFile): void
    {
        $zap = Zap::create([
            ...$this->except('pacient', 'z_sl')->toArray(),
            'registry_file_id' => $registryFile->id
        ]);

        $this->pacient->createModel($zap);

        // Законченный случай
        $this->z_sl->createModels($zap);
    }
}
