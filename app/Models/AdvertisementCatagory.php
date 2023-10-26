<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisementCatagory extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'advertisement_type_id',
        'status',
        'slug',
        'seo_title',
        'key_words',
        'seo_description',
        'meta_data',
        'reviews',
        'created_at',
        'updated_at',
    ];    
    
    
   
    public function advertisement_type()
    {
        return $this->hasOne(AdvertisementType::class,'id','advertisement_type_id')->where('status',1);
    }
}
