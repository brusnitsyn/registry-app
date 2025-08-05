<?php

namespace App\Http\Controllers\Api\Registry;

use App\Events\ProgressParsing;
use App\Http\Controllers\Controller;
use App\Models\RegistryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class FileController extends Controller
{
    public function files()
    {
        return RegistryFile::all()->map(function ($item) {
            return [
                'label' => $item->name,
                'key' => $item->id,
            ];
        });
    }

    public function progress(Request $request)
    {
        $data = $request->validate([
            'message' => 'required|string',
            'type' => 'required|string',
            'loading' => 'required|boolean',
            'finally' => 'required|boolean',
        ]);
        broadcast(new ProgressParsing($data));
    }
}
