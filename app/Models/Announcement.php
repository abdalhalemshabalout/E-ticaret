<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Announcement extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = ['worker_id', 'product_id', 'head', 'body',
                                'deleted_at','isActive','created_at', 'updated_at'];

    public function workerId(){
        return $this->belongsTo(User::class);
    }
    public function product(){
        return$this->belongsTo(Lessons::class);
    }
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
