<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\RegistryFile;
use App\Models\WebMenuItem;
use Illuminate\Http\Request;

class WebMenuController extends Controller
{
    public function getMenuItems(Request $request)
    {
        $viewType = $request->session()->get('view_type', 'registry');
        return WebMenuItem::whereType($viewType)
            ->orderBy('position', 'asc')
            ->get();
    }
}
