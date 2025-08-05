<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LibDepartment;
use App\Models\LibDepartmentType;
use App\Models\LibService;
use App\Models\RegistryFile;
use App\Models\RegistryService;
use App\Models\Sl;
use App\Models\Usl;
use App\Models\Zglv;
use App\Queries\RegistryDataQuery;
use App\Queries\RegistryDiagramQuery;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;

class WebServiceController extends Controller
{
    public function services(Request $request)
    {
        $searchValue = $request->query('search');
        $registryFile = RegistryFile::whereId($request->query('registry', RegistryFile::first()->id))->first();
        $zglvQuery = $request->query('zglv', [$registryFile->zglvs()->first()->id]);

        if (is_string($zglvQuery)) {
            $zglvQuery = collect(explode(',', $zglvQuery))->map(function ($item) {
                return intval($item);
            })->toArray();
        }

//        if (Str::contains($zglvQuery, ',')) {
//            $zglvQuery = explode(',', $zglvQuery);
//            $zglvQuery = Arr::map($zglvQuery, function ($item) {
//                return intval($item);
//            });
//        }

        $zglvIds = Zglv::whereIn('id', $zglvQuery)->get()->map(function ($item) {
            return $item->id;
        })->toArray();

        $placeholders = implode(',', array_fill(0, count($zglvIds), '?'));
        $sql = RegistryDataQuery::getQuery();
        $sql = str_replace('zap.zglv_id IN (?)', 'zap.zglv_id IN ('.$placeholders.')', $sql);
        $sql = str_replace('u.code_usl LIKE (?)', 'u.code_usl LIKE \''.$searchValue.'%\'', $sql);
        $reportData = DB::select($sql, $zglvIds);

        $servicesInPodr = Arr::map($reportData, function ($item)
        {
            return [
                'all' => $item->total_patients,
                'department' => $item->department_name,
                'department_code' => $item->department_code,
                'patients_by_types' => [
                    'det' => $item->child_patients,
                    'old' => $item->adult_patients,
                ],
                'usls_by_types' => [
                    'det' => $item->child_usl_total,
                    'old' => $item->adult_usl_total,
                ],
                'bed_days_by_types' => [
                    'det' => $item->child_kd,
                    'old' => $item->adult_kd,
                ],
                'sum_by_types' => [
                    'det' => number_format($item->child_sum, 2, '.', ' '),
                    'old' => number_format($item->adult_sum, 2, '.', ' '),
                ]
            ];
        });

        $statistic = array_reduce($reportData, function ($result, $item) {
            $result['patients_by_types.det'] += $item->child_patients;
            $result['patients_by_types.old'] += $item->adult_patients;
            $result['usls_by_types.det'] += $item->child_usl_total;
            $result['usls_by_types.old'] += $item->adult_usl_total;
            $result['bed_days_by_types.det'] += $item->child_kd;
            $result['bed_days_by_types.old'] += $item->adult_kd;
            $result['sum_by_types.det'] += $item->child_sum;
            $result['sum_by_types.old'] += $item->adult_sum;

            return $result;
        }, [
            'patients_by_types.det' => 0,
            'patients_by_types.old' => 0,
            'usls_by_types.det' => 0,
            'usls_by_types.old' => 0,
            'bed_days_by_types.det' => 0,
            'bed_days_by_types.old' => 0,
            'sum_by_types.det' => 0.00,
            'sum_by_types.old' => 0.00,
        ]);

        $statistic['sum_by_types.det'] = number_format($statistic['sum_by_types.det'], 2, '.', ' ');
        $statistic['sum_by_types.old'] = number_format($statistic['sum_by_types.old'], 2, '.', ' ');

//        $sls = Sl::whereHas('zSl.zap.zglv', function ($query) use ($zglv) {
//            $query->where('id', $zglv->id);
//        })
//            ->with(['department:id,name,podr', 'usl:id,sl_id,date_in,date_out,ds,code_usl,kol_usl,sumv_usl,det'])
//            ->get(['id', 'det', 'podr', 'sum_m', 'kd']);
//
//        // Предварительно загружаем данные для parsed_department
//        $departments = LibDepartmentType::all()
//            ->pluck('name', 'code');
//
//        // Группировка по department.name с предварительным подсчетом
//        $servicesInPodr = $sls->groupBy('department.name')
//            ->map(function ($sls, $group) {
//
//                $detSl = $sls->where('det', 1);
//                $oldSl = $sls->where('det', 0);
//
//                $detPatients = $detSl->count();
//                $oldPatients = $oldSl->count();
//
//                $detKd = $detSl->sum('kd');
//                $oldKd = $oldSl->sum('kd');
//
//                $detSum = number_format($detSl->sum('sum_m'), 2, '.', ' ');
//                $oldSum = number_format($oldSl->sum('sum_m'), 2, '.', ' ');
//
//                // Собираем услуги с предварительной фильтрацией
//                $usls = $sls->flatMap(function ($sl) {
//                    return $sl->usl->map(function ($usl) {
//                        return [
//                            'date_in' => $usl->date_in,
//                            'date_out' => $usl->date_out,
//                            'ds' => $usl->ds,
//                            'code_usl' => $usl->code_usl,
//                            'kol_usl' => $usl->kol_usl,
//                            'sumv_usl' => $usl->sumv_usl,
//                            'is_det' => $usl->det,
//                        ];
//                    });
//                });
//
//                $detUsls = $usls->where('is_det', 1)->count();
//                $oldUsls = $usls->where('is_det', 0)->count();
//
//                return [
//                    'all' => $sls->count(),
//                    'department' => empty($group) ? 'Не указан код отделения [PODR]' : $group,
//                    'patients_by_types' => [
//                        'det' => $detPatients,
//                        'old' => $oldPatients,
//                    ],
//                    'usls_by_types' => [
//                        'det' => $detUsls,
//                        'old' => $oldUsls,
//                    ],
//                    'bed_days_by_types' => [
//                        'det' => $detKd,
//                        'old' => $oldKd,
//                    ],
//                    'sum_by_types' => [
//                        'det' => $detSum,
//                        'old' => $oldSum,
//                    ],
//                    'usls' => $usls
//                ];
//            })
//            ->values();
//
//        // Оптимизированный подсчет статистики
//        $statistic = [
//            'patients_by_types.det' => $sls->where('det', 1)->count(),
//            'patients_by_types.old' => $sls->where('det', 0)->count(),
//            'usls_by_types.det' => $sls->sum(fn($sl) => $sl->usl->where('det', 1)->count()),
//            'usls_by_types.old' => $sls->sum(fn($sl) => $sl->usl->where('det', 0)->count()),
//            'bed_days_by_types.det' => $sls->where('det', 1)->sum('kd'),
//            'bed_days_by_types.old' => $sls->where('det', 0)->sum('kd'),
//            'sum_by_types.det' => number_format($sls->where('det', 1)->sum('sum_m'), 2, '.', ' '),
//            'sum_by_types.old' => number_format($sls->where('det', 0)->sum('sum_m'), 2, '.', ' '),
//        ];

        // Оптимизированная группировка по parsed_department
        $totalUslCount = Usl::whereHas('sl.ZSl.zap.zglv', function ($query) use ($zglvIds) {
            $query->whereIn('id', $zglvIds);
        })->count();

//        $groupedServices = $sls
//            ->groupBy(fn ($sl) => $sl->getParsedDepartmentAttribute())
//            ->map(function ($group, $key) use ($sls) {
//                $percentageMin = 1;
//                $count = 0;
//                $total = Usl::count(); // Общее количество услуг
//
//                foreach ($group as $sl) {
//                    $count += $sl->usl()->count();
//                }
//
//                $percentage = round(($count / $total) * 100, 2); // Округляем до 2 знаков
//
//                if (0.10 > $percentage) {
//                    $percentage *= 40;
//                } else if ($percentageMin > $percentage) {
//                    $percentage *= 20;
//                }
//
//                $departmentName = LibDepartmentType::where('code', $key)->first()->name;
//                return [
//                    'department' => $departmentName,
//                    'count' => $count,
//                    'percentage' => $percentage,
//                ];
//            })
//            ->values()
//            ->toArray();

        $placeholders = implode(',', array_fill(0, count($zglvIds), '?'));
        $sql = RegistryDiagramQuery::getQuery();
        $sql = str_replace('zap.zglv_id IN (?)', 'zap.zglv_id IN ('.$placeholders.')', $sql);
        $groupedServices = DB::select($sql, $zglvIds);

//        $groupedServices = DB::select(RegistryDiagramQuery::getQuery(), [implode(',', $zglvIds)]);

        return Inertia::render('services/Index', [
            'servicesWithDepartment' => $groupedServices,
            'serviceCount' => $totalUslCount,
            'servicesInPodr' => $servicesInPodr,
            'statistic' => $statistic
        ]);
//        $sls = Sl::query()->with(['department', 'usl'])->get();
//
//        $servicesInPodr = $sls->groupBy('department.name')
//            ->map(function ($sls, $group) {
//                $allCount = $sls->count();
//                $detPatients = $sls->where('det', 1)->count();
//                $oldPatients = $sls->where('det', 0)->count();
//                $detKd = 0;
//                $oldKd = 0;
//                $detSum = number_format($sls->where('det', 1)->sum('sum_m'), 2, '.', ' ');
//                $oldSum = number_format($sls->where('det', 0)->sum('sum_m'), 2, '.', ' ');
//                $usls = collect();
//
//                foreach ($sls as $sl) {
//                    $sl->det === 1 ? $detKd += $sl->kd : $oldKd += $sl->kd;
//                    foreach ($sl->usl as $usl) {
//                        $usls->push([
//                            'date_in' => $usl->date_in,
//                            'date_out' => $usl->date_out,
//                            'ds' => $usl->ds,
//                            'code_usl' => $usl->code_usl,
//                            'kol_usl' => $usl->kol_usl,
//                            'sumv_usl' => $usl->sumv_usl,
//                            'is_det' => $usl->det === 1,
//                        ]);
//                    }
//                }
//
//                $detUsls = $usls->where('is_det', true)->count();
//                $oldUsls = $usls->where('is_det', false)->count();
//
//                return [
//                    'all' => $allCount,
//                    'department' => $group,
//                    'patients_by_types' => [
//                        'det' => $detPatients,
//                        'old' => $oldPatients,
//                    ],
//                    'usls_by_types' => [
//                        'det' => $detUsls,
//                        'old' => $oldUsls,
//                    ],
//                    'bed_days_by_types' => [
//                        'det' => $detKd,
//                        'old' => $oldKd,
//                    ],
//                    'sum_by_types' => [
//                        'det' => $detSum,
//                        'old' => $oldSum,
//                    ],
//                    'usls' => $usls
//                ];
//            })
//            ->values();
//
//        $statistic = [
//            'patients_by_types.det' => 0,
//            'patients_by_types.old' => 0,
//            'usls_by_types.det' => 0,
//            'usls_by_types.old' => 0,
//            'bed_days_by_types.det' => 0,
//            'bed_days_by_types.old' => 0,
//            'sum_by_types.old' => 0.0,
//            'sum_by_types.det' => 0.0,
//        ];
//
//        foreach ($servicesInPodr as $item) {
//            foreach (['patients_by_types', 'usls_by_types', 'bed_days_by_types'] as $field) {
//                $statistic[$field . '.det'] += $item[$field]['det'];
//                $statistic[$field . '.old'] += $item[$field]['old'];
//            }
//
//            $statistic['sum_by_types.det'] += (float)str_replace([' ', ','], ['', '.'], $item['sum_by_types']['det']);
//            $statistic['sum_by_types.old'] += (float)str_replace([' ', ','], ['', '.'], $item['sum_by_types']['old']);
//        }
//
//        // Форматирование суммы обратно в строку с пробелами
//        $statistic['sum_by_types.det'] = number_format($statistic['sum_by_types.det'], 2, '.', ' ');
//        $statistic['sum_by_types.old'] = number_format($statistic['sum_by_types.old'], 2, '.', ' ');
//
//        $groupedServices = $sls
//            ->groupBy(fn ($sl) => $sl->getParsedDepartmentAttribute())
//            ->map(function ($group, $key) use ($sls) {
//                $percentageMin = 1;
//                $count = 0;
//                $total = Usl::count(); // Общее количество услуг
//
//                foreach ($group as $sl) {
//                    $count += $sl->usl()->count();
//                }
//
//                $percentage = round(($count / $total) * 100, 2); // Округляем до 2 знаков
//
//                if (0.10 > $percentage) {
//                    $percentage *= 40;
//                } else if ($percentageMin > $percentage) {
//                    $percentage *= 20;
//                }
//
//                $departmentName = LibDepartmentType::where('code', $key)->first()->name;
//                return [
//                    'department' => $departmentName,
//                    'count' => $count,
//                    'percentage' => $percentage,
//                ];
//            })
//            ->values()
//            ->toArray();
//
//        return Inertia::render('services/Index', [
//            'servicesWithDepartment' => $groupedServices,
//            'serviceCount' => Usl::count(),
//            'servicesInPodr' => $servicesInPodr,
//            'statistic' => $statistic
//        ]);
    }

    public function details(Request $request)
    {
        $searchValue = $request->query('search');
        $searchValue = $request->query('search');
        $registryId = $request->query('registry', 1);
        $zglvIds = $request->query('zglv', [1]);
        if (is_string($zglvIds)) {
            $zglvIds = collect(explode(',', $zglvIds))->map(function ($item) {
                return intval($item);
            })->toArray();
        }
        $podr = $request->query('podr', 1);

        $currentPage = $request->query('page', 1);
        $perPage = intval($request->query('per_page', 15));

        $department = LibDepartment::wherePodr($podr)->first();

        $usls = Usl::whereHas('sl.ZSl.zap.zglv', function ($q) use ($zglvIds) {
            $q->whereIn('id', $zglvIds);
        })->where('fake_podr', $podr);

        $countSingleUsls = $usls->clone()->whereHas('sl.zSl', function ($q) {
            $q->where('idsp', '29');
        })->count();
        $countServicesSurgical = $usls->clone()->whereLike('code_usl', 'A16%')
            ->count();

        $widgets = [];

        $widgets[] = [
            'title' => 'Всего услуг',
            'count' => $usls->count()
        ];

        if ($countSingleUsls > 0) {
            $widgets[] = [
                'title' => 'Разовых услуг',
                'count' => $countSingleUsls
            ];
        }

        if ($countServicesSurgical > 0) {
            $widgets[] = [
                'title' => 'Операций',
                'count' => $countServicesSurgical
            ];
        }

        $usls = $usls
            ->clone()
            ->whereLike('code_usl', "$searchValue%")
            ->get()
            ->load('sl.zglv')
            ->groupBy('code_usl')
            ->map(function ($items, $group) {
                $adultCount = 0;
                $childCount = 0;
                $adultUslCosts = 0;
                $childUslCosts = 0;

                foreach ($items as $item) {
                    if (intval($item->det) == 0) {
                        $adultCount += 1;
                        $adultUslCosts += floatval($item->tarif);
                    } else {
                        $childCount += 1;
                        $childUslCosts += floatval($item->tarif);
                    }
                }

    //            "id" => 37501
    //            "idserv" => "C38CD339-B3FE-43CB-9735-5EAAAE212235"
    //            "lpu" => "280003"
    //            "lpu_1" => "0108002"
    //            "podr" => "2800033002"
    //            "profil" => "77"
    //            "vid_vme" => "B01.040.001"
    //            "det" => "0"
    //            "date_in" => "2025-07-08"
    //            "date_out" => "2025-07-08"
    //            "ds" => "M05.8"
    //            "code_usl" => "001371"
    //            "kol_usl" => "1.00"
    //            "tarif" => "1016.00"
    //            "sumv_usl" => "1016.00"
    //            "prvs" => null
    //            "p_otk" => null
    //            "code_md" => null
    //            "npl" => null
    //            "comentu" => null
    //            "sl_id" => 21154
    //            "created_at" => null
    //            "updated_at" => null

                return [
                    'usl' => $group,
                    'usl_name' => LibService::where('code', $group)->first()?->name,
                    'adult_patient_count' => $adultCount,
                    'adult_usl_costs' => number_format($adultUslCosts, 2, '.', ' '),
                    'child_patient_count' => $childCount,
                    'child_usl_costs' => number_format($childUslCosts, 2, '.', ' '),
                ];
        })
            ->sortBy('usl');

        $paginatedUsls = new LengthAwarePaginator(
            $usls->forPage($currentPage, $perPage),
            $usls->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );

        return Inertia::render('services/Details', [
            'department_name' => $department->name,
            'usls' => $paginatedUsls->values(),
            'pagination' => [
                'page' => intval($currentPage),
                'pageSize' => $perPage,
                'pageSizes' => [15, 50, 100],
                'showSizePicker' => true,
                'total' => $paginatedUsls->total(),
                'pageCount' => $paginatedUsls->lastPage(),
            ],
            'widgets' => $widgets
        ]);
    }

//    private function
}
