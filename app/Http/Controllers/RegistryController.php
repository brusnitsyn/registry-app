<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class RegistryController extends Controller
{
    public function prepare(Request $request)
    {
        // Валидируем входной файл
        $request->validate(['registry' => 'required|file|mimes:zip,xml']);

        $registryFile = $request->file('registry');
        $fileName = $registryFile->getClientOriginalName();

        try {
            $response = Http::timeout(600)
                ->attach('file', $registryFile->getContent(), $fileName)
                ->post(config('services.parser.url') . "/api/v1/parse");
        } catch (ConnectionException $connectionException) {
            Log::error($connectionException->getMessage());
            return response()->setStatusCode(500);
        }

        return response()->json([
            'status' => 'ok',
            'message' => 'Файл отправлен на обработку',
        ]);
    }
}
