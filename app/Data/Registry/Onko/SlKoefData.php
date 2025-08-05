<?php

namespace App\Data\Registry\Onko;

use App\Models\KsgKpg;
use App\Models\SlKoef;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class SlKoefData extends Data
{
    public function __construct(
        public string|Optional $idsl,
        public float|Optional $z_sl,
    ) {}

    public function createModel(KsgKpg $ksgKpg)
    {
        $slKoef = SlKoef::create([
            ...$this->toArray(),
            'ksg_kpg_id' => $ksgKpg->id
        ]);
    }
}
