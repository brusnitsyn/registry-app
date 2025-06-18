<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Slugable
{
    public static function bootSlugable(): void
    {
        static::creating(function ($model) {
            $slug = Str::slug($model->{$model->getSlugField()});
            $model->{$model->getSlugColumn()} = $slug;
        });
    }

    // Геттеры для доступа к настройкам
    public function getSlugField(): string
    {
        return property_exists($this, 'slugField')
            ? $this->slugField
            : 'label';
    }

    public function getSlugColumn(): string
    {
        return property_exists($this, 'slugColumn')
            ? $this->slugColumn
            : 'slug';
    }
}
