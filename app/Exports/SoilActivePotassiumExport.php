<?php

namespace App\Exports;

use App\Models\SoilActivePotassiumPointer;
use Maatwebsite\Excel\Concerns\FromCollection;

class SoilActivePotassiumExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return SoilActivePotassiumPointer::latest('id')->take(3)->get();
    }
}
