<?php

namespace App\Data\Registry\Onko;

use App\Models\BDiag;
use App\Models\OnkSl;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class BDiagData extends Data
{
    public function __construct(
        public string|Optional $diag_date,
        public string|Optional $diag_tip,
        public string|Optional $diag_code,
        public string|Optional $diag_rslt,
        public string|Optional $rec_rslt,
    ) {

    }

    public function createModel(OnkSl $onkSl): void
    {
        $bDiag = BDiag::create([
            ...$onkSl->toArray(),
            'onk_sl_id' => $onkSl->id
        ]);
    }
}
