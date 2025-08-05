<?php

namespace App\Data\Registry\Onko;

use App\Models\Cons;
use App\Models\Sl;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class ConsData extends Data
{
    public function __construct(
        public string|Optional $pr_cons,
        public string|Optional $dt_cons,
    ) {

    }

    public function createModel(Sl $sl): void
    {
        $cons = Cons::create([
            ...$this->toArray(),
            'sl_id' => $sl->id
        ]);
    }
}
