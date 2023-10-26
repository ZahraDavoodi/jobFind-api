<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'advertisement_code',
        'name',
        'slug',
        'advertisement_type_id',
        'advertisement_catagory_id',
        'type_of_time_id',
        'gender_id',
         'company_id',
        'salary',
        'job_position',
        'important_skill',
        'duties',
        'status',
        'reviews',
        'created_at',
        'updated_at',
        'province_id',

        
    ];   
    public function advertisement_type()
    {
        return $this->hasOne(AdvertisementType::class,'id','advertisement_type_id')->where('status',1);
    }

    public function advertisement_catagory()
    {
        return $this->hasOne(AdvertisementCatagory::class,'id','advertisement_catagory_id');
    }  
    public function type_of_time()
    {
        return $this->hasOne(TypeOfTime::class,'id','type_of_time_id')->where('status',1);
    }  
    public function gender()
    {
        return $this->hasOne(Gender::class,'id','gender_id');
    }     
     public function province()
    {
        return $this->hasOne(Province::class,'id','province_id');
    }    
     public function company()
    {
        return $this->hasOne(Company::class,'id','company_id');
    } 
}
