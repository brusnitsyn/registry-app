<?php

namespace App\Data\Registry\Onko;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class InjData extends Data
{
    public function __construct(
        public string|Optional $date_inj,
        public float|Optional $kv_inj,
        public float|Optional $kiz_inj,
        public float|Optional $s_inj,
        public float|Optional $sv_inj,
        public float|Optional $siz_inj,
        public string|Optional $red_inj,
    ) {

    }
}
