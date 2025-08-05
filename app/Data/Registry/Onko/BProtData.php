<?php

namespace App\Data\Registry\Onko;

use App\Models\BProt;
use App\Models\OnkSl;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class BProtData extends Data
{
    public function __construct(
        public string|Optional $prot,
        public string|Optional $d_prot,
    ) {

    }

    public function createModel(OnkSl $onkSl): void
    {
        $bProt = BProt::create([
            ...$this->toArray(),
            'onk_sl_id' => $onkSl->id,
        ]);
    }
}
