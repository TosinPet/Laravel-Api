<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportSku implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        return Product::select('name', 'reference_number', 'price', 'quantity', 'cases',)->get();
    }

    public function headings(): array
    {
        return[
            'Name', 
            'Internal Reference', 
            'Cost', 
            'Quantity', 
            'Cases', 
        ];
    }
}
