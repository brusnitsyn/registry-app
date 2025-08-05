<?php

namespace App\Data\Registry\Onko;

use App\Models\Napr;
use App\Models\Sl;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class NaprData extends Data
{
    public function __construct(
        public string|Optional $napr_date,
        public string|Optional $napr_mo,
        public string|Optional $napr_v,
        public string|Optional $met_issl,
        public string|Optional $napr_usl,
    ) {

    }

    public function createModel(Sl $sl): void
    {
        $napr = Napr::create([
            $this->toArray(),
            'sl_id' => $sl->id
        ]);
    }
}
