<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $pass = random_int(100000, 999999);
            $password = bcrypt($pass);
            $ref = 'CUS'.random_int(1000000000, 9999999999);

            if (!isset($row['full_name'])) {
                return null;
            }

            Customer::create([
                //
                'user_id' => auth()->user()->id,
                'full_name' => $row['full_name'],
                'address' => $row['address'],
                'year_of_business' => $row['year_of_business'],
                'business_type' => $row['business_type'],
                'business_name' => $row['business_name'],
                'phone' => $row['phone'],
                'state' => $row['state'],
                'lga' => $row['lga'],
                'customer_type' => $row['customer_type'],
                'reference_no'=> $ref,
                'active' => $row['active'],
                'suspend' => $row['suspend'],
                'guarantor_name' => $row['guarantor_name'],
                'guarantor_address' => $row['guarantor_address'],
                'guarantor_phone' => $row['guarantor_phone'],
                'relationship_with_applicant' => $row['relationship_with_applicant'],
                'years_of_relationship' => $row['years_of_relationship'],
                'password' => $password,
                'created_by' => auth()->user()->id,
            ]);

            User::create([
                'full_name' => $row['full_name'],
                'phone' => $row['phone'],
                'reference_no' => $ref,
                'password' => $password,
            ]);
        }
    }
}
