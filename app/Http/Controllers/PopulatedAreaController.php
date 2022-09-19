<?php

namespace App\Http\Controllers;

// Register autoloader
// require_once(base_path() . '/vendor/php-shapefile/src/Shapefile/ShapefileAutoloader.php');

use App\Http\Requests\StorePopulatedAreaRequest;
use App\Http\Requests\UpdatePopulatedAreaRequest;
use App\Models\PopulatedArea;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Shapefile\Shapefile;
use Shapefile\ShapefileAutoloader;
use Shapefile\ShapefileException;
use Shapefile\ShapefileReader;

ShapefileAutoloader::register();

class PopulatedAreaController extends Controller
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
     * @param  \App\Http\Requests\StorePopulatedAreaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePopulatedAreaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PopulatedArea  $populatedArea
     * @return \Illuminate\Http\Response
     */
    public function show(PopulatedArea $populatedArea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PopulatedArea  $populatedArea
     * @return \Illuminate\Http\Response
     */
    public function edit(PopulatedArea $populatedArea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePopulatedAreaRequest  $request
     * @param  \App\Models\PopulatedArea  $populatedArea
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePopulatedAreaRequest $request, PopulatedArea $populatedArea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PopulatedArea  $populatedArea
     * @return \Illuminate\Http\Response
     */
    public function destroy(PopulatedArea $populatedArea)
    {
        //
    }

    public function importShapefile(Request $request)
    {
        $extracted_file_path = base_path("storage/app/uploads/unzip");

        try {
            $zipfile = $request->file("zip");
            $zipfile_name = pathinfo($zipfile->getClientOriginalName(), PATHINFO_FILENAME);
            $is_extracted = extractUploadedZip($zipfile);
            $shape_file = "$extracted_file_path/$zipfile_name/$zipfile_name.shp";
            // dd($shape_file);

            if ($is_extracted) {
                $Shapefile = new ShapefileReader($shape_file);
                dd($Shapefile);
                // Read all the records
                while ($Geometry = $Shapefile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }

                    // Print Geometry as an Array
                    print_r($Geometry->getArray());

                    // Print Geometry as WKT
                    print_r($Geometry->getWKT());

                    // Print Geometry as GeoJSON
                    print_r($Geometry->getGeoJSON());

                    // Print DBF data
                    print_r($Geometry->getDataArray());

                    // PopulatedArea::create([
                    //     'model' => 'PopulatedArea',
                    //     'lat' => '',
                    //     'long' => '',
                    // ]);
                }
            }
        } catch (ShapefileException $e) {
            // Print detailed error information
            // echo "Error Type: " . $e->getErrorType()
            //     . "\nMessage: " . $e->getMessage()
            //     . "\nDetails: " . $e->getDetails();

            throw ValidationException::withMessages([
                'zip' => __($e->getMessage() . "\nDetails: " . $e->getDetails()),
            ]);
        }

        // return back()
        //     ->with('success', 'Data successfully imported!');
    }
}
