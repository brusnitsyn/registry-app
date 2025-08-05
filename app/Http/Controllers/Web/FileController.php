<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\RegistryFile;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function files(Request $request)
    {
        $registryFileId = $request->query('registry');
        $registryFile = RegistryFile::whereId($registryFileId)->first();
        return $registryFile->zglvs;
    }

    public function registries()
    {
        return RegistryFile::all();
    }
}
