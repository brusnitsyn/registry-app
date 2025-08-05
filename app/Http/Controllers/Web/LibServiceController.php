<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LibService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LibServiceController extends Controller
{
    public function services(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $services = LibService::paginate($perPage);
        $columns = [
            [
                'title' => 'Код услуги',
                'key' => 'code'
            ],
            [
                'title' => 'Наименование услуги',
                'key' => 'name'
            ],
            [
                'title' => 'Дата начала',
                'key' => 'begin_at'
            ],
            [
                'title' => 'Дата окончания',
                'key' => 'end_at'
            ],
        ];

        return Inertia::render('libs/Index', [
            'title' => 'Справочник: Медицинские услуги',
            'items' => $services->items(),
            'columns' => $columns,
            'paginate' => []
        ]);
    }
}
