<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'logo',
        'cover',
        'phone',
        'user_id',
        'email',
        'description',
        'status',
        'created_at',
        'updated_at',
        

    ];    
     public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }  
}
