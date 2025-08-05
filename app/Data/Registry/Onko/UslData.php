<?php

namespace App\Data\Registry\Onko;

use App\Models\Sl;
use App\Models\Usl;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UslData extends Data
{
    public function __construct(
        public string|Optional $idserv,
        public string|Optional $lpu,
        public string|Optional $lpu_1,
        public string|Optional $podr,
        public string|Optional $profil,
        public string|Optional $vid_vme,
        public string|Optional $det,
        public string|Optional $date_in,
        public string|Optional $date_out,
        public string|Optional $ds,
        public string|Optional $code_usl,
        public int|Optional $kol_usl,
        public float|Optional $tarif,
        public float|Optional $sumv_usl,
        public string|Optional $prvs,
        public string|Optional $code_md,
        public string|Optional $npl,
        public string|Optional $comentu,
    ) {

    }

    public function createModel(Sl $sl): void
    {
        $usl = Usl::create([
            ...$this->toArray(),
            'sl_id' => $sl->id
        ]);
    }
}
