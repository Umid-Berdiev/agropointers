<?php

namespace App\Exports;

use App\Models\SoilAppraisalPointer;
use Maatwebsite\Excel\Concerns\FromCollection;

class SoilAppraisalExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return SoilAppraisalPointer::latest('id')->take(3)->get();
    }
}
