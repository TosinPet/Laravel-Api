<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportCustomer implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Customer::select('user_id', 'full_name', 'address', 'year_of_business', 'business_type', 'business_name', 'phone', 'state', 'lga', 'state', 'customer_type', 'reference_no', 'account', 'active', 'suspend', 'guarantor_name', 'guarantor_address', 'guarantor_phone', 'relationship_with_applicant', 'years_of_relationship')->get();
    }

    public function headings(): array
    {
        return[
            'User Id', 
            'Full Name', 
            'Address', 
            'Year of Business', 
            'Business Type', 
            'Business Name', 
            'Phone', 
            'State', 
            'Lga', 
            'Customer Type', 
            'Reference No', 
            'Account', 
            'Active', 
            'Suspend', 
            'Guarantor Name', 
            'Guarantor Address', 
            'Guarantor Phone', 
            'Relationship with Applicant', 
            'Years of Relationship'
        ];
    }
}
