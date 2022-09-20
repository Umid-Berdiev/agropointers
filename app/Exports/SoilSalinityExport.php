<?php

namespace App\Exports;

use App\Models\SoilSalinityPointer;
use Maatwebsite\Excel\Concerns\FromCollection;

class SoilSalinityExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return SoilSalinityPointer::latest('id')->take(3)->get();
    }
}
