<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;
    protected $fillable = [
        'header',
        'small_article',
        'title',
        'article',
        'image',
        'image_alt',
        'slug',
        'seo_title',
        'key_words',
        'seo_description',
        'meta_data',
        'reviews',
        'created_at',
        'updated_at',
    ];
}
