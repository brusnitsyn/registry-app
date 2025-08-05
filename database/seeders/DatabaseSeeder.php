<?php

namespace Database\Seeders;

use App\Models\RegistryType;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Web
            WebSeeder::class,

            // Registry
            RegistryTypeSeeder::class,

            // Library
            LibDepartmentTypeSeeder::class,
            LibDepartmentSeeder::class,
        ]);
    }
}
