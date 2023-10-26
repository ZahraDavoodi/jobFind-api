<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'company_id',
        'advertisement_id',
        'pay',
        'status',
        'created_at',
        'updated_at',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class)->where('status',1);
    }    
    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class)->where('status',1);
    }       
}
