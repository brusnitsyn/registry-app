<?php

namespace App\Data\Registry\Onko;

use App\Models\Sl;
use App\Models\ZSl;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;

class SlData extends Data
{
    public function __construct(
        public string $sl_id,
        public string|Optional $lpu_1,
        public string|Optional $podr,
        public string|Optional $profil,
        public string|Optional $profil_k,
        public string|Optional $det,
        public string|Optional $p_cel,
        public string|Optional $nhistory,
        public string|Optional $p_per,
        public string $date_1,
        public string $date_2,
        public int|Optional $kd,
        public string|Optional $ds0,
        public string $ds1,
        public string|array|Optional $ds2,
        public string|array|Optional $ds3,
        public string|Optional $c_zab,
        public string|Optional $ds_onk,
        public string|Optional $dn,
        public string|Optional $code_mes1,
        public string|Optional $code_mes2,
        /** @var NaprData[]|NaprData */
        public NaprData|array|Optional $napr,
        public ConsData|Optional $cons,
        public OnkSlData|Optional  $onk_sl,
        public KsgKpgData|Optional $ksg_kpg,
        public string|Optional     $reab,
        public string|Optional     $prvs,
        public string|Optional     $vers_spec,
        public string|Optional     $iddokt,
        public float|Optional      $ed_col,
        public float|Optional      $tarif,
        public float|Optional      $sum_m,
        /** @var UslData[] */
        public array       $usl,
        public string|Optional     $comentsl,
    ) {

    }

    public function createModels(ZSl $zSl): void
    {
        $sl = Sl::create([
            ...$this->except('napr', 'cons', 'onk_sl', 'ksg_kpg', 'usl')->toArray(),
            'z_sl_id' => $zSl->id
        ]);

        // Обработка направлений
        if ($this->napr instanceof NaprData) {
            $this->napr->createModel($sl);
        } else {
            foreach ($this->napr as $napr) {
                $napr->createModel($sl);
            }
        }

        if ($this->cons instanceof ConsData) {
            $this->cons->createModel($sl);
        }

        if ($this->onk_sl instanceof OnkSlData) {
            $this->onk_sl->createModel($sl);
        }

        if ($this->ksg_kpg instanceof KsgKpgData) {
            $this->ksg_kpg->createModel($sl);
        }

        if (is_array($this->usl)) {
            foreach ($this->usl as $uslData) {
                $uslData->createModel($sl);
            }
        }

//        if ($this->usl instanceof UslData) {
//            $this->usl->createModel($sl);
//        } else {
//            foreach ($this->usl as $uslData) {
//                $uslData->createModel($sl);
//            }
//        }
    }
}
