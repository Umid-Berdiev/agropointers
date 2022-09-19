<?php

namespace App\Http\Controllers;

use App\Models\PopulatedArea;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StaticDataController extends Controller
{
    public function index(Request $request)
    {
        // $populated_area = PopulatedArea::latest('id')->first();

        return Inertia::render('Admin/StaticData', [
            // 'populatedArea' => $populated_area
        ]);
    }
}
