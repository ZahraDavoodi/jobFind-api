<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSeeker extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'photo',
        'last_name',
        'phone',
        'email',
        'gender_id',
        'province_id',
        'user_id',
        'address',
        'salary',
        'type_of_time_id',
        'level_of_education_id',
        'courses_details',
        'resume',
        'personal_details',
        'status',
        'ready_to_work',
        'created_at',
        'updated_at',
        
    ];
    public function gender()
    {
         return $this->hasOne(Gender::class,'id','gender_id');
         //return $this->hasOne(Gender::class);
    }   
    public function province()
    {
        return $this->hasOne(Province::class,'id','province_id');
    }  
    public function type_of_time()
    {
        return $this->hasOne(TypeOfTime::class,'id','type_of_time_id');
    }     
    public function level_of_education()
    {
        return $this->hasOne(LevelOfEducations::class,'id','level_of_education_id');
    }      
     public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }  
}
