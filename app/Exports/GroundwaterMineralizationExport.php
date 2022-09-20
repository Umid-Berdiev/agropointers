<?php

namespace App\Exports;

use App\Models\GroundwaterMineralizationPointer;
use Maatwebsite\Excel\Concerns\FromCollection;

class GroundwaterMineralizationExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return GroundwaterMineralizationPointer::latest('id')->take(3)->get();
    }
}
