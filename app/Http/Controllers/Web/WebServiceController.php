<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\RegistryCase;
use App\Models\RegistryService;
use Inertia\Inertia;

class WebServiceController extends Controller
{
    public function services()
    {
        $graph = RegistryService::selectRaw('code, count(*)')
            ->groupBy('code')
            ->orderByRaw('count(*) desc')
            ->get();

//        $types = RegistryCase::selectRaw('treatment_type, COUNT(*) as count')
//            ->groupBy('treatment_type')
//            ->get()
//            ->map(function ($item) {
//                return [
//                    'type' => $item->treatment_type, // "амбулаторные", "стационарные" и т.д.
//                    'count' => $item->count
//                ];
//            });

        return Inertia::render('services/Index', [
            'chartData' => $graph->map(fn($item) => [
                'code' => $item->code,
                'count' => $item->count
            ]),
            'serviceCount' => RegistryService::count()
        ]);
    }

    public function graph()
    {
        $graph = RegistryService::selectRaw('count(*)')
            ->groupBy('code')
            ->orderByRaw('count(*)');
    }
}
