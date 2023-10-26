<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisementType extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'slug',
        'seo_title',
        'key_words',
        'seo_description',
        'meta_data',
        'reviews',
        'status',
        'created_at',
        'updated_at',
    ];    
}
