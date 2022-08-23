<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable=
    ['id',
     'roles_name'] ;


    public function User(){
        return $this->hasMany(User::class,'role_id','id');
    }

    public $timestamps=true;


}
