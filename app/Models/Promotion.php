<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function brand()
    {
        return $this->hasMany(Brand::class, 'brand_id');
    }

    public function isActive()
    {
		  return ($this->status == true) ? true : false;
    }
}
