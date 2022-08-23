<?php

namespace App\Models;

use App\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ECommerce extends Model
{
    use HasFactory;

    protected $fillable = ['address_id', 'name', 'email', 'website', 'logo', 'color1', 'color2', 'color3',
        'authorized_person', 'ip_adress', 'isActive', 'licence_start_date', 'licence_update_date', 'licence_end_date','created_at', 'updated_at'];

    public $incrementing = false;
    protected $keyType = 'string';
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function products()
    {
        return $this->hasMany(Products::class);
    }
    public function authority()
    {
        return $this->belongsToMany(Authority::class);
    }
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
