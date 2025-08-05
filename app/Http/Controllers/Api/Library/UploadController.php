<?php

namespace App\Http\Controllers\Api\Library;

use App\Http\Controllers\Controller;
use App\Imports\LibraryMultiSheetImporter;
use App\Imports\LibServiceImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            $import = new LibServiceImport();
            $result = Excel::import($import, $request->file('file'));
            return response()->json([
                'status' => 'success',
                'message' => 'Файл успешно импортирован'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ошибка импорта: '.$e->getMessage()
            ]);
        }
    }
}
