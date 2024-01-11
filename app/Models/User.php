<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public function suspend()
    {
		  return ($this->suspend == true) ? true : false;
    }

    public function admin()
    {
		  return ($this->admin == true && ($this->account == 5)) ? true : false;
    }

    public function isActive()
    {
		  return ($this->active == true) ? true : false;
    }

    public function superAdmin()
    {
        return ($this->admin == true && ($this->account == 9) && $this->is_root == false) ? true : false;
    }

    public function rootUser()
    {
		  return ($this->admin == true && $this->account == 9 && $this->is_root == true) ? true : false;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function favorites() 
    {
        return $this->belongsToMany(Product::class, 'favorites');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'purchase_id');
    }
}
