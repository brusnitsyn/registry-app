<?php

namespace Database\Seeders;

use App\Models\LibDepartmentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibDepartmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibDepartmentType::create([
            'code' => 0,
            'name' => 'Не определено'
        ]);
        LibDepartmentType::create([
            'code' => 1,
            'name' => 'Стационарно'
        ]);
        LibDepartmentType::create([
            'code' => 2,
            'name' => 'В дневном стационаре'
        ]);
        LibDepartmentType::create([
            'code' => 3,
            'name' => 'Амбулаторно'
        ]);
        LibDepartmentType::create([
            'code' => 4,
            'name' => 'Скорая помощь'
        ]);
    }
}
