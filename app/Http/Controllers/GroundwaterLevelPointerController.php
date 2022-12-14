<?php

namespace App\Http\Controllers;

use App\Exports\GroundwaterLevelExport;
use App\Imports\GroundwaterLevelPointerImport;
use App\Models\GroundwaterDataLog;
use App\Models\GroundwaterLevelPointer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class GroundwaterLevelPointerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GroundwaterLevelPointer  $groundwaterLevelPointer
     * @return \Illuminate\Http\Response
     */
    public function show(GroundwaterLevelPointer $groundwaterLevelPointer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GroundwaterLevelPointer  $groundwaterLevelPointer
     * @return \Illuminate\Http\Response
     */
    public function edit(GroundwaterLevelPointer $groundwaterLevelPointer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GroundwaterLevelPointer  $groundwaterLevelPointer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GroundwaterLevelPointer $groundwaterLevelPointer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GroundwaterLevelPointer  $groundwaterLevelPointer
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroundwaterLevelPointer $groundwaterLevelPointer)
    {
        //
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'import_file' => ['required']
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages([
                'import_file' => __('file_not_found'),
            ]);
        }

        Excel::import(new GroundwaterLevelPointerImport, $request->file('import_file'));

        GroundwaterDataLog::create([
            'type' => 'GroundwaterLevelPointer',
            'comment' => 'Groundwater level pointer data imported from excel file'
        ]);

        return Redirect::route('admin.groundwater_data');
    }

    public function export()
    {
        $dateStr = now()->format('d_m_Y');
        return Excel::download(new GroundwaterLevelExport, "level_$dateStr.xlsx");
    }
}
