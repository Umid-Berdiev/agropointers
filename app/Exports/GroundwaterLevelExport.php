<?php

namespace App\Exports;

use App\Models\GroundwaterLevelPointer;
use Maatwebsite\Excel\Concerns\FromCollection;

class GroundwaterLevelExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return GroundwaterLevelPointer::latest('id')->take(2)->get();
    }
}
