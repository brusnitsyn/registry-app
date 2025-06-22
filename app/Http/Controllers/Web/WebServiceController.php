<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\RegistryCase;
use App\Models\LibDepartmentType;
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

        $services = RegistryService::query()->get();
        $groupedServices = $services
            ->groupBy(fn ($service) => $service->parsed_department)
            ->map(function ($group, $key) use ($services) {
                $percentageMin = 1;
                $total = $services->count(); // Общее количество услуг
                $count = $group->count();
                $percentage = round(($count / $total) * 100, 2); // Округляем до 2 знаков

                if (0.10 > $percentage) {
                    $percentage *= 40;
                } else if ($percentageMin > $percentage) {
                    $percentage *= 20;
                }

                $departmentName = LibDepartmentType::where('code', $key)->first()->name;
                return [
                    'department' => $departmentName,
                    'count' => $group->count(),
                    'percentage' => $percentage,
                ];
            })
            ->values()
            ->toArray();

        return Inertia::render('services/Index', [
//            'chartData' => $graph->map(fn($item) => [
//                'code' => $item->code,
//                'count' => $item->count
//            ]),
            'servicesWithDepartment' => $groupedServices,
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
