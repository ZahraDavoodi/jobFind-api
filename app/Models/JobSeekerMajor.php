<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSeekerMajor extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'job_seeker_id',
        'name',
        'created_at',
        'updated_at',
        
    ];
    public function job_seekers()
    {
        return $this->hasMany(JobSeeker::class);
    }       
}
