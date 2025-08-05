<?php

namespace App\Data\Registry\Onko;

use App\Models\LekPr;
use App\Models\OnkUsl;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class LekPrData extends Data
{
    public function __construct(
        public string|Optional $regnum,
        public string|Optional $regnum_dop,
        public string|Optional $code_sh,
        /** @var InjData[]|Optional */
        public array|Optional $inj,
    ) {}

    public function createModel(OnkUsl $onkUsl): void
    {
        $lekPr = LekPr::create([
            $this->except('inj')->toArray(),
            'onk_usl_id' => $onkUsl->id
        ]);
    }
}
