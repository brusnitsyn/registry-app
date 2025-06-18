<?php

namespace App\Http\Controllers\Api\Registry;

use App\Http\Controllers\Controller;
use App\Models\RegistryFile;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function files()
    {
        return RegistryFile::get();
    }
}
