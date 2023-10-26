<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\JobSeeker;
use App\Http\Resources\JobSeekerResource;
use App\Models\Cv;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon; 
use Validator;
use Exception;
use Illuminate\Support\Facades\Auth;

class JobSeekerInfoController extends BaseController
{
    public function index()
    {
        $data = JobSeeker::with('gender','province','type_of_time','level_of_education')->get();
        return $this->sendResponse(JobSeekerResource::collection($data), 'Adertisment retrieved successfully.');

    }
    public function show()
    {
        $user_id = Auth::user()->id;
        echo $user_id;
        $data = CV ::with('job_seeker','advertisement')->where('job_seeker_id',$user_id)->get();
        return $this->sendResponse(JobSeekerResource::collection($data), 'Adertisment retrieved successfully.');

    }    
}
