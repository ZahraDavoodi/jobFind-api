<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyTelephone extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'company_id',
        'telephone',
        'created_at',
        'updated_at',
        
    ];  
    public function companies()
    {
        return $this->hasMany(Company::class);
    }       
}
