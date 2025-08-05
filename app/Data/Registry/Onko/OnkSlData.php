<?php

namespace App\Data\Registry\Onko;

use App\Models\OnkSl;
use App\Models\Sl;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class OnkSlData extends Data
{
    public function __construct(
        public string|Optional $ds1_t,
        public string|Optional $stad,
        public string|Optional $onk_t,
        public string|Optional $onk_n,
        public string|Optional $onk_m,
        public string|Optional $mtstz,
        public float|Optional $sod,
        public int|Optional $k_fr,
        public float|Optional $wei,
        public float|Optional $hei,
        public float|Optional $bsa,
        public BDiagData|Optional $b_diag,
        public BProtData|Optional $b_prot,
        public OnkUslData|Optional $onk_usl,
    ) {

    }

    public function createModel(Sl $sl)
    {
        $onkSl = OnkSl::create([
            ...$this->except('b_diag', 'b_prot', 'onk_usl')->toArray(),
            'sl_id' => $sl->id
        ]);

        if ($this->b_diag instanceof BDiagData) {
            $this->b_diag->createModel($onkSl);
        }

        if ($this->b_prot instanceof BProtData) {
            $this->b_prot->createModel($onkSl);
        }

        if ($this->onk_usl instanceof OnkUslData) {
            $this->onk_usl->createModel($onkSl);
        }
    }
}
