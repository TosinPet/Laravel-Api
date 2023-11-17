<?php

namespace App\Exports;

use App\Models\CustomerAccount;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportCustomerAccount implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CustomerAccount::select('customer_id', 'utilized_credit', 'credit_limit', 'credit_allowance')->get();
    }

    public function headings(): array
    {
        return[
            'Customer Id',
            'Utilized Credit',
            'Credit Limit',
            'Credit Allowance'
        ];
    }
}
