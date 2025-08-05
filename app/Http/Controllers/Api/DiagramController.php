<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RegistryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DiagramController extends Controller
{
    public function countUsls(Request $request)
    {
        $registryId = $request->get('registry', RegistryFile::latest('id')->first()->id);
        $currentCount = RegistryFile::whereId($registryId)->first()->usls()->count();
        $registryFiles = RegistryFile::all();
        $statistic = [];
        foreach ($registryFiles as $registryFile) {
            $statistic += [
                'month' => $registryFile->name,
                'count' => $registryFile->usls()->count()
            ];
        }

        return response()->json([
            'count' => $currentCount,
            'diagram' => [$statistic]
        ]);
    }

    public function countSingleUsls(Request $request)
    {
        $registryId = $request->get('registry', RegistryFile::latest('id')->first()->id);
        $currentCount = RegistryFile::whereId($registryId)->first()
            ->usls()->toQuery()
            ->whereHas('sl.zSl', function ($q) {
                $q->where('idsp', '29');
            })
            ->count();
        $registryFiles = RegistryFile::all();
        $statistic = [];
        foreach ($registryFiles as $registryFile) {
            $statistic += [
                'month' => $registryFile->name,
                'count' => $registryFile->usls()->toQuery()
                    ->whereHas('sl.zSl', function ($q) {
                        $q->where('idsp', '29');
                    })->count()
            ];
        }

        return response()->json([
            'count' => $currentCount,
            'diagram' => [$statistic]
        ]);
    }

    public function countUslsInStationarMis(Request $request)
    {
        $prevMonth = Carbon::now()->subMonth()->day(21)->toDateTimeLocalString();
        $now = Carbon::now()->toDateTimeLocalString();
        $usls = DB::connection('mis')->table('stt_MedServicePatient')
            ->select(['MedServicePatientID'])
            ->join('oms_ServiceMedical', 'oms_ServiceMedical.ServiceMedicalID', '=', 'stt_MedServicePatient.rf_ServiceMedicalID')
            ->whereBetween('Date', [$prevMonth, $now])
            ->where('oms_ServiceMedical.rf_kl_MedCareTypeID', 0)
            ->count();

        return response()->json([
            'count' => $usls
        ]);
    }

    public function countUslsInPolyclinicMis(Request $request)
    {
        $prevMonth = Carbon::now()->subMonth()->day(21)->toDateTimeLocalString();
        $now = Carbon::now()->toDateTimeLocalString();
        $usls = DB::connection('mis')->table('hlt_SMTAP')
            ->select(['SMTAPID'])
            ->whereBetween('DATE_P', [$prevMonth, $now])
            ->count();

        return response()->json([
            'count' => $usls
        ]);
    }
}
