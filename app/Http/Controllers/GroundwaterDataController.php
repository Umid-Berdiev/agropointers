<?php

namespace App\Http\Controllers;

use App\Models\GroundwaterDataLog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GroundwaterDataController extends Controller
{
    public function index(Request $request)
    {
        $logs = GroundwaterDataLog::latest('id')->paginate(5);

        return Inertia::render('Admin/GroundwaterData', [
            'logs' => $logs
        ]);
    }
}
