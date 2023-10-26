<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'phone1',
        'phone2',
        'phone3',
        'email',
        'address',
        'google_address',
        'facebook',
        'instagram',
        'telegram',
        'pinterest',
        'whatsapp',
        'seo_title',
        'key_words',
        'seo_description',
        'meta_data',
        'reviews',
        'created_at',
        'updated_at',
        
    ];
}
