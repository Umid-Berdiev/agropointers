<?php

namespace App\Exports;

use App\Models\GumusPointer;
use Maatwebsite\Excel\Concerns\FromCollection;

class HumusDataExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return GumusPointer::latest('id')->take(3)->get();
    }
}
