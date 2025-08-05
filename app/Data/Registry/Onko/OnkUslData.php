<?php

namespace App\Data\Registry\Onko;

use App\Models\OnkSl;
use App\Models\OnkUsl;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class OnkUslData extends Data
{
    public function __construct(
        public string|Optional $usl_tip,
        public string|Optional $hir_tip,
        public string|Optional $lek_tip_l,
        public string|Optional $lek_tip_v,
        public LekPrData|Optional $lek_pr,
        public string|Optional $pptr,
        public string|Optional $luch_tip,
    ) {

    }

    public function createModel(OnkSl $onkSl)
    {
        $onkUsl = OnkUsl::create([
            ...$this->except('lek_pr')->toArray(),
            'onk_sl_id' => $onkSl->id,
        ]);

        if ($this->lek_pr instanceof LekPrData) {
            $this->lek_pr->createModel($onkUsl);
        }
    }
}
