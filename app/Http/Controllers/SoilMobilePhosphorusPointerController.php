<?php

namespace App\Http\Controllers;

use App\Exports\SoilMobilePhosphorusExport;
use App\Imports\SoilMobilePhosphorusPointerImport;
use App\Models\SoilDataLog;
use App\Models\SoilMobilePhosphorusPointer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class SoilMobilePhosphorusPointerController extends Controller
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
     * @param  \App\Models\SoilMobilePhosphorusPointer  $soilMobilePhosphorusPointer
     * @return \Illuminate\Http\Response
     */
    public function show(SoilMobilePhosphorusPointer $soilMobilePhosphorusPointer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SoilMobilePhosphorusPointer  $soilMobilePhosphorusPointer
     * @return \Illuminate\Http\Response
     */
    public function edit(SoilMobilePhosphorusPointer $soilMobilePhosphorusPointer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SoilMobilePhosphorusPointer  $soilMobilePhosphorusPointer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SoilMobilePhosphorusPointer $soilMobilePhosphorusPointer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SoilMobilePhosphorusPointer  $soilMobilePhosphorusPointer
     * @return \Illuminate\Http\Response
     */
    public function destroy(SoilMobilePhosphorusPointer $soilMobilePhosphorusPointer)
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

        Excel::import(new SoilMobilePhosphorusPointerImport, $request->file('import_file'));

        SoilDataLog::create([
            'type' => 'SoilMobilePhosphorusPointer',
            'comment' => 'Soil mobile phosphorus pointer data imported from excel file'
        ]);

        return Redirect::route('admin.soil_data');
    }

    public function export()
    {
        $dateStr = now()->format('d_m_Y');
        return Excel::download(new SoilMobilePhosphorusExport, "mobile_phosphorus_$dateStr.xlsx");
    }
}
