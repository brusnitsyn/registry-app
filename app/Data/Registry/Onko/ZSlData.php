<?php

namespace App\Data\Registry\Onko;

use App\Models\Zap;
use App\Models\ZSl;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class ZSlData extends Data
{
    public function __construct(
        public string|Optional $idcase,
        public string|Optional $usl_ok,
        public string|Optional $vidpom,
        public string|Optional $for_pom,
        public string|Optional $npr_mo,
        public string|Optional $npr_date,
        public string|Optional $lpu,
        public string|Optional $date_z_1,
        public string|Optional $date_z_2,
        public int|Optional $kd_z,
        public float|Optional $vnov_m,
        public string|Optional $rslt,
        public string|Optional $ishod,
        public string|array|Optional $os_sluch,
        public string|Optional $vb_p,
        public SlData $sl,
        public string|Optional $idsp,
        public float|Optional $sumv,
        public string|Optional $oplata,
        public float|Optional $sump,
//        public Sank|Optional $sank,
        public float|Optional $sank_it,
    ) {

    }

    public function createModels(Zap $zap): void
    {
        $zSl = ZSl::create([
            ...$this->except('sl')->toArray(),
            'zap_id' => $zap->id
        ]);

        // Случай лечения
        $this->sl->createModels($zSl);
    }
}
