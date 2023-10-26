<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'ticket_code',
        'company_id',
        'ticket_parent',
        'description',
        'file',
        'status',
        'created_at',
        'updated_at',
    ];    
    public function company()
    {
        return $this->hasOne(Company::class)->where('status',1);
    }     

}
