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
            'key' => Str::slug('Медицинские услуги')
        ], [
            'label' => 'Медицинские услуги',
            'href' => 'registry.services'
        ]);
        WebMenuItem::updateOrcreate([
            'key' => Str::slug('Справочники')
        ], [
            'label' => 'Справочники'
        ]);
    }
}
