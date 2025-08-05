<?php

namespace Database\Seeders;

use App\Models\WebMenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WebSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WebMenuItem::updateOrCreate([
            'key' => Str::slug('Реестр: Медицинские услуги')
        ], [
            'type' => 'registry',
            'label' => 'Медицинские услуги',
            'href' => 'registry.services'
        ]);
        WebMenuItem::updateOrcreate([
            'key' => Str::slug('Реестр: Справочники')
        ], [
            'type' => 'registry',
            'label' => 'Справочники',
            'href' => 'libs.index'
        ]);

        WebMenuItem::updateOrCreate([
            'key' => Str::slug('МИС: Медицинские услуги')
        ], [
            'type' => 'mis',
            'label' => 'Медицинские услуги',
            'href' => 'mis.services'
        ]);
        WebMenuItem::updateOrcreate([
            'key' => Str::slug('МИС: Справочники')
        ], [
            'type' => 'mis',
            'label' => 'Справочники'
        ]);
    }
}
