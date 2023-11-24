<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerAccount extends Model
{
    use HasFactory;
    protected $table = 'customer_account';
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
}
