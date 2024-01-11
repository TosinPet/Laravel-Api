<?php

namespace App\Models;

use App\Models\CustomerAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    // protected $table = 'customers';
    protected $guarded = [];

    public function account()
    {
        return $this->hasOne(CustomerAccount::class);
    }
}
