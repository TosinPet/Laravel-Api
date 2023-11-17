<?php

namespace App\Imports;

use App\Models\CustomerAccount;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersAccountImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!isset($row['customer_id'])) {
            return null;
        }

        CustomerAccount::create([
            //
            'customer_id' => $row['customer_id'],
            'utilized_credit' => $row['utilized_credit'],
            'credit_limit' => $row['credit_limit'],
            'credit_allowance' => $row['credit_allowance'],
        ]);
    }
}
