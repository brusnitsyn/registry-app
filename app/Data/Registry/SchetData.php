<?php

namespace App\Data\Registry;

use App\Models\RegistryFile;
use App\Models\Schet;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class SchetData extends Data
{
    public function __construct(
        public string $code,
        public string $code_mo,
        public string $year,
        public string $month,
        public string $nschet,
        public string $dschet,
        public string|Optional $plat,
        public float $summav,
        public string|Optional $coments,
        public float|Optional $summap,
        public float|Optional $sank_mek,
        public float|Optional $sank_mee,
        public float|Optional $sank_ekmp,
    ) {

    }

    public function createModel(RegistryFile $registryFile): void
    {
        Schet::create([
            ...$this->toArray(),
            'registry_file_id' => $registryFile->id
        ]);
    }
}
