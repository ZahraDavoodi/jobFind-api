<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',	
        'province',	
        'name',	
        'name_en',	
        'latitude',	
        'longitude',        
    ];
}
