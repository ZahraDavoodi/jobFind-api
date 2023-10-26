<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketAnswer extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'ticket_id',
        'user_id',
        'description',
        'file',
        'created_at',
        'updated_at',
    ];   
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }   
    public function user()
    {
        return $this->hasOne(User::class);
    }         
}
