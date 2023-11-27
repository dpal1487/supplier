<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['address', 'city', 'state', 'country_id', 'pincode' , 'entity_id','entity_type'];

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
}
