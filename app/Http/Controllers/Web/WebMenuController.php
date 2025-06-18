<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\RegistryFile;
use App\Models\WebMenuItem;

class WebMenuController extends Controller
{
    public function getMenuItems()
    {
        return WebMenuItem::orderBy('position', 'asc')->get();
    }
}
