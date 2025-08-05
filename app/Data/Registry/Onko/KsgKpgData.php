<?php

namespace App\Data\Registry\Onko;

use App\Models\KsgKpg;
use App\Models\Sl;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class KsgKpgData extends Data
{
    public function __construct(
        public string|Optional $n_ksg,
        public string|Optional $ver_ksg,
        public string|Optional $ksg_pg,
        public string|Optional $n_kpg,
        public float|Optional $koef_z,
        public float|Optional $koef_up,
        public float|Optional $bztsz,
        public float|Optional $koef_d,
        public float|Optional $koef_u,
        public float|Optional $k_zp,
        public string|array|Optional $crit,
        public string|Optional $sl_k,
        public float|Optional $it_sl,
        /** @var SlKoefData[]|Optional */
        public SlKoefData|array|Optional $sl_koef,
    ) {

    }

    public function createModel(Sl $sl): void
    {
        $ksgKpg = KsgKpg::create([
            ...$this->except('sl_koef')->toArray(),
            'sl_id' => $sl->id
        ]);

        if ($this->sl_koef instanceof SlKoefData) {
            $this->sl_koef->createModel($ksgKpg);
        } else if (is_array($this->sl_koef)) {
            foreach ($this->sl_koef as $slKoef) {
                $slKoef->createModel($ksgKpg);
            }
        }
    }
}
