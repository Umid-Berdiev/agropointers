<?php

namespace App\Exports;

use App\Models\SoilMineralStructurePointer;
use Maatwebsite\Excel\Concerns\FromCollection;

class SoilMineralStructureExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return SoilMineralStructurePointer::latest('id')->take(3)->get();
    }
}
