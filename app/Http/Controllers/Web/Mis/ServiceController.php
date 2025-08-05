<?php

namespace App\Http\Controllers\Web\Mis;

use App\Http\Controllers\Controller;
use App\Models\Mis\OmsDepartment;
use App\Models\MisStationarMedicalService;
use App\Models\Usl;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ServiceController extends Controller
{
    public function services(Request $request)
    {
        $startAt = Carbon::parse('20250701')->toDateTimeLocalString();
        $endAt = Carbon::parse('20250715')->toDateTimeLocalString();
        $beforeDate = Carbon::parse('22220101')->toDateTimeLocalString();
        $servicesByDepartments = MisStationarMedicalService::query()
            ->with(['medicalHistory', 'serviceMedical', 'stationarBranch.department'])
            ->join('stt_MedicalHistory as mh', 'mh.MedicalHistoryID', '=', 'stt_MedServicePatient.rf_MedicalHistoryID')
            ->join('oms_ServiceMedical as omServ', 'stt_MedServicePatient.rf_ServiceMedicalID', '=', 'omServ.ServiceMedicalID')
            ->join('stt_StationarBranch as branch', 'stt_MedServicePatient.rf_StationarBranchID', '=', 'branch.StationarBranchID')
            ->join('oms_Department as department', 'branch.rf_DepartmentID', '=', 'department.DepartmentID')
            ->select([
                'department.DepartmentID as department_id',
                'department.DepartmentNAME as department_name',
                // Общие показатели
                DB::raw('COUNT(DISTINCT mh.MedicalHistoryID) as patient_count'),
                DB::raw('COUNT(DISTINCT stt_MedServicePatient.UGUID) as service_count'),
                DB::raw('SUM(mh.DurationHosp) as total_bed_days'),
                // Пациенты по возрасту
                DB::raw('COUNT(DISTINCT CASE WHEN DATEDIFF(YEAR, mh.BD, stt_MedServicePatient.Date) < 18 THEN mh.MedicalHistoryID END) as child_patient_count'),
                DB::raw('COUNT(DISTINCT CASE WHEN DATEDIFF(YEAR, mh.BD, stt_MedServicePatient.Date) >= 18 THEN mh.MedicalHistoryID END) as adult_patient_count'),
                // Услуги по возрасту
                DB::raw('COUNT(DISTINCT CASE WHEN DATEDIFF(YEAR, mh.BD, stt_MedServicePatient.Date) < 18 THEN stt_MedServicePatient.UGUID END) as child_service_count'),
                DB::raw('COUNT(DISTINCT CASE WHEN DATEDIFF(YEAR, mh.BD, stt_MedServicePatient.Date) >= 18 THEN stt_MedServicePatient.UGUID END) as adult_service_count'),
                // Койко-дни по возрасту
                DB::raw('SUM(CASE WHEN DATEDIFF(YEAR, mh.BD, stt_MedServicePatient.Date) < 18 THEN mh.DurationHosp ELSE 0 END) as child_bed_days'),
                DB::raw('SUM(CASE WHEN DATEDIFF(YEAR, mh.BD, stt_MedServicePatient.Date) >= 18 THEN mh.DurationHosp ELSE 0 END) as adult_bed_days'),
                // Стоимость услуг
                DB::raw('SUM(CASE WHEN DATEDIFF(YEAR, mh.BD, stt_MedServicePatient.Date) < 18 THEN stt_MedServicePatient.Sum_Usl ELSE 0 END) as child_service_costs'),
                DB::raw('SUM(CASE WHEN DATEDIFF(YEAR, mh.BD, stt_MedServicePatient.Date) >= 18 THEN stt_MedServicePatient.Sum_Usl ELSE 0 END) as adult_service_costs'),
            ])
            ->whereBetween('stt_MedServicePatient.Date', [$startAt, $endAt])
            ->whereDate('mh.DateExtract', '<', $beforeDate)
            ->groupBy('department.DepartmentNAME')
            ->groupBy('department.DepartmentID')
            ->orderBy('department.DepartmentNAME')
            ->get();

//        dd($servicesByDepartments);

        return Inertia::render('mis/services/Index', [
            'stationarServices' => $servicesByDepartments,
        ]);
    }

    public function details(Request $request)
    {
        $page = $request->query('page', 1);
        $departmentId = $request->query('department', 1);
        $startAt = Carbon::parse('20250701')->toDateTimeLocalString();
        $endAt = Carbon::parse('20250714')->toDateTimeLocalString();

        $department = OmsDepartment::where('DepartmentID', $departmentId)->first();

        $paginate = MisStationarMedicalService::with([
            'stationarBranch.department',
            'serviceMedical',
            'registryUsl.sl.zSl.zap.zglv.registryFile'
        ])->whereHas('stationarBranch.department', function ($query) use ($departmentId) {
            $query->where('DepartmentID', $departmentId);
        })->whereHas('serviceMedical', function ($query) {
                $query->where('rf_kl_MedCareTypeID', 0);
            })
            ->whereBetween('DateEnd', [$startAt, $endAt])
            ->paginate(page: intval($page))
            ->through(function (MisStationarMedicalService $item) {
                $usl = Usl::whereIdserv($item->UGUID)->first();
                $item->in_registry = !is_null($usl);
                $item->registry_name = $item->in_registry
                    ? $usl->sl->zSl->zap->zglv->registryFile->name : 'Нет связи с реестром';
                return $item;
            });

        return Inertia::render('mis/services/details/Index', [
            'department_name' => $department->DepartmentNAME,
            'data' => $paginate->items(),
            'pagination' => [
                'page' => $paginate->currentPage(),
                'pageSize' => $paginate->perPage(),
                'pageSizes' => [15, 50, 100],
                'showSizePicker' => true,
                'total' => $paginate->total(),
                'pageCount' => $paginate->lastPage(),
            ]
        ]);
    }
}
