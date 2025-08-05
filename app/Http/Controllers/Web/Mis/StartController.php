<?php

namespace App\Http\Controllers\Web\Mis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StartController extends Controller
{
    public function home(Request $request)
    {
        return Inertia::render('mis/Home', []);
    }
}
