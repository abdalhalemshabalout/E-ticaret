<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['city_id', 'address', 'telephone', 'tax_number', 'created_at', 'updated_at'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function site()
    {
        return $this->hasMany(ECommerce::class);
    }
}
