<?php

namespace App\Data\Registry;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class RegistryData extends Data
{
    public function __construct(
        public string|Optional $general,
        public ZglvData $zglv,
        public SchetData $schet,
        /** @var ZapData[] **/
        public array $zap
    ) {

    }
}
