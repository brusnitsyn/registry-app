<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'podr' => '2800031015',
                'name' => 'Онкологическое',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031002',
                'name' => 'Гастроэнтерологии',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031003',
                'name' => 'Гематологии',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031004',
                'name' => 'Гинекологии',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031006',
                'name' => 'Для беременных и рожениц',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031008',
                'name' => 'Кардиологии',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031009',
                'name' => 'Кардиологии для больных с острым инфарктом миокарда',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031010',
                'name' => 'Неврологии',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031011',
                'name' => 'Неврологии для больных с острыми нарушениями мозгового кровообращения',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031012',
                'name' => 'Нейрохирургии',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031013',
                'name' => 'Нефрологическое',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031014',
                'name' => 'Ожоговое',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031016',
                'name' => 'Ортопедии',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031017',
                'name' => 'Оториноларингологии',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031019',
                'name' => 'Патологии беременности',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031020',
                'name' => 'Патологии новорожденных и недоношенных детей',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031022',
                'name' => 'Проктологии',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031023',
                'name' => 'Пульмонологии',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031026',
                'name' => 'Реабилитации соматические',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031027',
                'name' => 'Сердечно-сосудистой хирургии',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031030',
                'name' => 'Торакальной хирургии',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031031',
                'name' => 'Травматологии (в том числе сочетанная травма)',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031032',
                'name' => 'Урологии',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031033',
                'name' => 'Хирургии',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031034',
                'name' => 'Челюстно-лицевой хирургии',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031035',
                'name' => 'Эндокринологии',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031037',
                'name' => 'Ревматологии',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800031038',
                'name' => 'Терапия (педиатрия) участковая больница',
                'department_type_id' => 1,
            ],
            [
                'podr' => '2800032003',
                'name' => 'Гинекологии для вспомогательных репродуктивных технологий',
                'department_type_id' => 2,
            ],
            [
                'podr' => '2800032040',
                'name' => 'Терапия (педиатрия) участковая больница',
                'department_type_id' => 2,
            ],
            [
                'podr' => '2800033001',
                'name' => 'Нефрологическое',
                'department_type_id' => 3,
            ],
            [
                'podr' => '2800033002',
                'name' => 'Амбулаторно-поликлиническое',
                'department_type_id' => 3,
            ],
            [
                'podr' => '2800033003',
                'name' => 'Стоматологии',
                'department_type_id' => 3,
            ],
            [
                'podr' => '2800034001',
                'name' => 'Скорой медицинской помощи',
                'department_type_id' => 4,
            ],
            [
                'podr' => '2800035015',
                'name' => 'Терапии при поликлинике',
                'department_type_id' => 2,
            ],
        ];

        DB::table('lib_departments')->insert($departments);
    }
}
