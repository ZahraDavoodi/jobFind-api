<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'job_seeker_id',
        'advertisement_id',
        'cv_status_id',
        'created_at',
        'updated_at',
        
    ];    
    public function job_seeker()
    {
        return $this->hasOne(JobSeeker::class,'id','job_seeker_id');
    }
    public function advertisement()
    {
        return $this->hasOne(Advertisement::class,'id','advertisement_id');
    }   
    
    public function cv_status()
    {
        return $this->hasOne(CvStatus::class,'id','cv_status_id');
    }   
    

    
}
