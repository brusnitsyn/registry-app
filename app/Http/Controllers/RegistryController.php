<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessingRegistryRecord;
use App\Models\RegistryCase;
use App\Models\RegistryPatient;
use App\Models\RegistryService;
use Illuminate\Bus\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Throwable;

class RegistryController extends Controller
{
    public function parse(Request $request)
    {
        $request->validate(['registry' => 'required|file|mimes:zip']);

        $response = Http::timeout(600)
            ->attach('file', file_get_contents($request->file('registry')),
                $request->file('registry')->getClientOriginalName())
            ->post('http://localhost:8001/parse-registry');

        if ($response->successful()) {
            $data = $response->json();

            $jobs = [];
            foreach ($data['data'] as $fileData) {
                $jobs[] = new ProcessingRegistryRecord($fileData);
            }

            $batch = Bus::batch($jobs)
                ->before(function (Batch $batch) {})
                ->progress(function (Batch $batch) {})
                ->then(function (Batch $batch) {})
                ->catch(function (Batch $batch, Throwable $e) {})
                ->finally(function (Batch $batch) {})
                ->dispatch();
        }

        return response()->json(['error' => 'Processing failed'], 500);
    }
}
