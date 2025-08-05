<?php

namespace App\Data\Registry\Base;

use App\Models\Pacient;
use App\Models\Zap;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PacientData extends Data
{
    public function __construct(
        public string|Optional $id_pac,
        public string|Optional $vpolis,
        public string|Optional $spolis,
        public string|Optional $npolis,
        public string|Optional $st_okato,
        public string|Optional $smo,
        public string|Optional $smo_ogrn,
        public string|Optional $smo_ok,
        public string|Optional $smo_nam,
        public string|Optional $inv,
        public string|Optional $mse,
        public string|Optional $novor,
        public float|Optional $vnov_d,
        public string|Optional $soc,
    ) {

    }

    public function createModel(Zap $zap): void
    {
        $pacient = Pacient::create([
            ...$this->toArray(),
            'zap_id' => $zap->id,
        ]);
    }
}
