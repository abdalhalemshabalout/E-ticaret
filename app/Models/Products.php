<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use const http\Client\Curl\Features\UNIX_SOCKETS;

class Products extends Model
{
    use HasFactory;

    protected $fillable = ['site_id', 'product_code', 'product_name', 'product_image',
        'product_price','isActive', 'isDeleted', 'created_at', 'updated_at'];
    public $incrementing = false;
    protected $keyType = 'string';

    public function sity()
    {
        return $this->belongsTo(ECommerce::class);
    }

    public function workerId()
    {
        return $this->belongsToMany(User::class, 'customer_products', 'product_id', 'worker_id');
    }

    public function customertId()
    {
        return $this->belongsToMany(User::class, 'customer_products', 'product_id', 'customer_id');
    }

    public function announcement()
    {
        return $this->hasMany(Announcement::class);
    }


    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
