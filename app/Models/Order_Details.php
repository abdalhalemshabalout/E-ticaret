<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Details extends Model
{
    use HasFactory;
    protected $fillable = ['order_details_id', 'product_id', 'product_qty', 
                            'order_Id','subtotal'];

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
}
