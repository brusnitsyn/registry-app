<?php

namespace App\Data\Registry;

use Spatie\LaravelData\Data;

class ZapData extends Data
{
    public function __construct(
        public string $n_zap,
        public string $pr_nov,
    ) {

    }
}
