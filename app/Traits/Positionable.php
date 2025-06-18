<?php

namespace App\Traits;

trait Positionable
{
    public static function bootPositionable(): void
    {
        static::deleted(function ($model) {
            self::where('position', '>', $model->position)
                ->decrement('position');
        });

        static::creating(function ($model) {
            $maxPosition = self::max('position');
            $model->position = $maxPosition ? $maxPosition + 1 : 1;
        });
    }

    public static function reorder(): void
    {
        $models = self::orderBy('position')->get();

        foreach ($models as $index => $model) {
            $model->position = $index + 1;
            $model->save();
        }
    }
}
