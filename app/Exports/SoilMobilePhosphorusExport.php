<?php

namespace App\Exports;

use App\Models\SoilMobilePhosphorusPointer;
use Maatwebsite\Excel\Concerns\FromCollection;

class SoilMobilePhosphorusExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return SoilMobilePhosphorusPointer::latest('id')->take(3)->get();
    }
}
