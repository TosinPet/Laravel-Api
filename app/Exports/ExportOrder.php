<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportOrder implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::select('user_id', 'phone', 'order_number', 'order_date', 'shipping_address', 'subtotal', 'total_amount', 'status', 'payment_status',)->get();
    }

    public function headings(): array
    {
        return[
            'User_id', 
            'Phone No', 
            'Order_number', 
            'Order_date', 
            'Shipping_address', 
            'Subtotal', 
            'Total_amount', 
            'Status', 
            'Payment_status', 
        ];
    }
}
