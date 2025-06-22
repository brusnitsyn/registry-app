<?php

namespace Database\Seeders;

use App\Models\RegistryType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegistryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RegistryType::create([
            'code' => 'MAIN_REGISTRY',
            'letters' => 'HM',
            'comment' => 'Основной реестр'
        ]);
        RegistryType::create([
            'code' => 'ONCOLOGY_REGISTRY',
            'letters' => 'CM',
            'comment' => 'Онкологический реестр'
        ]);
        RegistryType::create([
            'code' => 'HIGHTECH_CARE',
            'letters' => 'TM',
            'comment' => 'ВМП (высокотехнологичная медпомощь)'
        ]);

        RegistryType::create([
            'code' => 'STAGE1_ADULT',
            'letters' => 'DPM',
            'comment' => '1 этап диспансеризации взрослых'
        ]);
        RegistryType::create([
            'code' => 'STAGE2_ADULT',
            'letters' => 'DVM',
            'comment' => '2 этап диспансеризации взрослых'
        ]);
        RegistryType::create([
            'code' => 'ADULT_CHECKUPS',
            'letters' => 'DOM',
            'comment' => 'Профосмотры взрослых'
        ]);
        RegistryType::create([
            'code' => 'MINORS_CHECKUPS',
            'letters' => 'DFM',
            'comment' => 'Профосмотры несовершеннолетних'
        ]);
        RegistryType::create([
            'code' => 'ORPHANS_SCREENING',
            'letters' => 'DSM',
            'comment' => 'Диспансеризация детей-сирот'
        ]);
        RegistryType::create([
            'code' => 'WARDS_SCREENING',
            'letters' => 'DUM',
            'comment' => 'Диспансеризация детей без попечения'
        ]);
        RegistryType::create([
            'code' => 'STAGE1_ADVANCED',
            'letters' => 'DAM',
            'comment' => '1 этап углубленной диспансеризации'
        ]);
        RegistryType::create([
            'code' => 'STAGE2_ADVANCED',
            'letters' => 'DBM',
            'comment' => '2 этап углубленной диспансеризации'
        ]);
        RegistryType::create([
            'code' => 'STAGE1_REPRODUCTIVE',
            'letters' => 'DDM',
            'comment' => '1 этап диспансеризации репродуктивного здоровья'
        ]);
        RegistryType::create([
            'code' => 'STAGE2_REPRODUCTIVE',
            'letters' => 'DEM',
            'comment' => '2 этап диспансеризации репродуктивного здоровья'
        ]);
    }
}
