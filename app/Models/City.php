<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function address()
    {
        return $this->hasMany(Address::class);
    }

    public function country()
    {
        return $this->belongsTo(City::class);
    }
}
