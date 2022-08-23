<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;


class User extends Authenticatable
{
    /**
     * @OA\Schema(
     *     title="User",
     *     description="User model",
     *     schema="User"
     *      properties={
     *
     * @OA\Property(format="string", default="1", description="role_id", property="role_id"),
     * @OA\Property(format="string", default="8b84692d-8f90-42d0-bf85-f859dcab3d02, description="universityId", property="universityId"),
     * @OA\Property(format="string", default="xingxiang@spacebib.com", description="email", property="email"),
     * @OA\Property(format="string", default="string", description="name", property="name"),
     * @OA\Property(format="string", default="string", description="surname", property="surname"),
     * @OA\Property(format="string", default="string", description="telephone", property="telephone"),
     * @OA\Property(format="string", default="password", description="password", property="password"),
     * @OA\Property(format="string", default="password", description="password confirmation", property="password confirmation"),
     * @OA\Property(format="string", default="string", description="identityNumber", property="identityNumber"),
     *}
     *     )
     *
     */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'role_id',
        'site_id',
        'name',
        'surname',
        'telephone',
        'email',
        'password',
        'image',
        'identity_number',
        'isActive',
        'isDeleted'
    ];

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
    ];

    public function products()
    {
        return $this->belongsToMany(Products::class, 'customer_products', 'customer_id', 'product_id');
    }
    
    public function productWorker()
    {
        return $this->belongsToMany(Products::class, 'worker_products', 'worker_id', 'product_id');
    }
    public function product()
    {
        return $this->belongsToMany(User::class, 'products', 'worker_id', 'product_id');
    }
    public function userCustomer()
    {
        return $this->belongsToMany(User::class, 'users', 'id', 'role_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function site()
    {
        return $this->belongsTo(ECommerce::class);
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
