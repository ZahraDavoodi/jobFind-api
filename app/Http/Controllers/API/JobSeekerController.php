<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\JobSeeker;
use App\Models\Cv;
use App\Models\Company;
use App\Models\Advertisement;
use App\Http\Resources\JobSeekerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon; 
use Validator;
use Exception;

class JobSeekerController extends BaseController
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = JobSeeker::with('gender','province','type_of_time','level_of_education','user')->get();
        //$data = JobSeeker::with('gender')->get();
        return $this->sendResponse($data, 'Adertisment retrieved successfully.');

    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function vali($request)
    {
        $validation = Validator::make($request->all(), [
            'name'                              => 'required',
            'last_name'                         => 'required',

            'photo'                             => 'required|image|mimes:png,jpg,jpeg|max:2048',

            'phone'                             => 'required|unique:companies,phone',
            'email'                             => 'required|unique:companies,email',

            'gender_id'                         => 'required',
            'province_id'                       => 'required',
            'address'                           => 'required',
            'salary'                            => 'required',
            'type_of_time_id'                   => 'required',
            'level_of_education_id'             => 'required',
            'courses_details'                   => 'required',
            'resume'                            => 'required',
            'personal_details'                  => 'required',
        ],[
            'name.required'                     => 'اسم اجباری است.',
            'name.required'                     => 'تخلص اجباری است.',

            'photo.required'                     => 'لوگو اجباری است.',
            'photo.image'                        => 'لوگو باید عکس باشد .',
            'photo.max'                          => 'لوگو از ۲ mb بیشتر شده نمی تواند است.',
            'photo.mimes'                        => 'لوگو باید به فرمت های png jpg jepg باشد.',

            'phone.required'                    =>'شماره تمای اجباری است.',
            'phone.unique'                      =>'شماره تماس تکراری است.',

            'email.required'                    =>'ایمیل اجباری است.',
            'email.unique'                      =>'ایمیل تکراری است.',


            'gender_id.required'                 => 'جنسیت اجباری است',
            'province_id.required'               => 'شهر اجباری است',
            'address.required'                   => 'آدرس اجباری است',
            'salary.required'                    => 'حقوق اجباری است',
            'type_of_time_id.required'           => 'نوع همکار اجباری است',
            'level_of_education_id.required'     => 'میزان تحصیل اجباری است',
            'courses_details.required'           => 'رشته تحصیلی درمقاطع مختلف اجباری است',
            'resume.required'                    => 'شرح کامل دوره ها  اجباری است',
            'personal_details.required'          => 'توضیخات در مورد علائق شغلی و خصوصیات فردی اجباری است',

        ]);   
        return $validation;
    }

    public function store(Request $request)
    {

        $vali = $this->vali($request);

        if($vali->passes()){
            try {
                $inputs = $request->all();

                //Move Uploaded File
                $photoFile = $request->file('photo');
                $destinationPath = 'images/JobSeeker';
                $timestamp=Carbon::now()->format('Ymds');
                $image=$destinationPath.'/Photo'.$timestamp.'.'.$photoFile->getClientOriginalExtension();
                $photoFile->move($destinationPath,$image);   
    
                $inputs['photo'] = $image;
    
                $data = JobSeeker::create($inputs);
                return $this->sendResponse(new JobSeekerResource($data), 'JobSeeker Created successfully.');

            } catch (Exception $erorrs ) {
                return $this->sendError('Validation Error.', $erorrs);  
            }
        }
        else{
            return $this->sendError('Validation Error.', $vali->errors());     
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $data = JobSeeker::with('gender','province','type_of_time','level_of_education')->find($id);
         $data = JobSeeker::with('gender','province','type_of_time','level_of_education','user')->find($id);
        // $data = JobSeeker::where('user_id', $id)->first();
        if (is_null($data)) {
            return $this->sendError('JobSeeker not found.');
        }
        return $this->sendResponse($data, 'JobSeeker retrieved successfully.'); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = JobSeeker::with('gender','province','type_of_time','level_of_education')->find($id);
        if (is_null($data)) {
            return $this->sendError('JobSeeker not found.');
        }
        return $this->sendResponse(new JobSeekerResource($data), 'JobSeeker retrieved successfully.'); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $vali = $this->vali($request);

        $data = JobSeeker::find($id);
        if($data == null)
        {
            return $this->sendError('JobSeeker not found.');   
        }
        else{
            $photoPath = $data->photo;
    
            if($vali->passes()){
                try {
                    //Move Uploaded File
                    if($photoPath == $request->photo){
                        $inputs['photo'] = $request->photo;
                    }
                    else{
                        if (file_exists($photoPath)) {
                            unlink($photoPath);
                        }   
                        else{
                            $photoFile = $request->file('photo');
                            $destinationPath = 'images/JobSeeker';
                            $timestamp=Carbon::now()->format('Ymds');
                            $image=$destinationPath.'/Photo'.$timestamp.'.'.$photoFile->getClientOriginalExtension();
                            $photoFile->move($destinationPath,$image);   
                        }                      
                    }
        
                    $inputs['photo'] = $image;
        
                    $data = JobSeeker::where('id',$id)->update($inputs);
                    return $this->sendResponse(new JobSeekerResource($data), 'JobSeeker Updated successfully.');

                } catch (Exception $erorrs ) {
                    return $this->sendError('Validation Error.', $erorrs);  
                }
            }
            else{
                return $this->sendError('Validation Error.', $vali->errors());     
            }
        }


        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobSeeker $job_seeker)
    {
        $job_seeker->delete();
        return $this->sendResponse([], 'JoobSeeker deleted successfully.');

    }
    
    
    
    ////////////////////// from front 
    
     public function front_show($id)
    {
        // $data = JobSeeker::with('gender','province','type_of_time','level_of_education')->find($id);
        // $data = JobSeeker::find($id);
         $data = JobSeeker::with('gender','province','type_of_time','level_of_education','user')->where('user_id', $id)->first();
        if (is_null($data)) {
            return $this->sendError('JobSeeker not found.');
        }
        return $this->sendResponse($data, 'JobSeeker retrieved successfully.'); 
    }
    
     public function jobseeker_show($id)
    {
        // $data = JobSeeker::with('gender','province','type_of_time','level_of_education')->find($id);
        // $data = JobSeeker::find($id);
         $data = JobSeeker::with('gender','province','type_of_time','level_of_education','user')->where('id', $id)->first();
        if (is_null($data)) {
            return $this->sendError('JobSeeker not found.');
        }
        return $this->sendResponse($data, 'JobSeeker retrieved successfully.'); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function front_edit($id)
    {
       // $data = JobSeeker::with('gender','province','type_of_time','level_of_education')->find($id);
         $data = JobSeeker::with('gender','province','type_of_time','level_of_education','user')->where('user_id', $id)->first();
        if (is_null($data)) {
            return $this->sendError('JobSeeker not found.');
        }
        return $this->sendResponse($data, 'JobSeeker retrieved successfully.'); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function front_update(Request $request, $id)
    {
        
        
             $inputs = $request->all();
                    
                //     $jobseeker= new JobSeeker;
                    
                    
                //     $jobseeker->name = $inputs['name'];
                //     $jobseeker->last_name = $inputs['last_name'];
                //     $jobseeker->phone = $inputs['phone'];
                //     $jobseeker->email = $inputs['email'];
                //     $jobseeker->gender_id = $inputs['gender_id'];
                //     $jobseeker->province_id = $inputs['province_id'];
                //     // $jobseeker->address = $inputs['address'];
                //     $jobseeker->type_of_time_id = $inputs['type_of_time_id'];
                //     $jobseeker->salary = $inputs['salary'];
                //     $jobseeker->level_of_education_id = $inputs['level_of_education_id'];
                //     $jobseeker->courses_details = $inputs['courses_details'];
                //     $jobseeker->personal_details = $inputs['personal_details'];
                //     $jobseeker->readt_to_work = $inputs['readt_to_work'];
                //   $jobseeker->save();
       
                   //  $data = JobSeeker::where('user_id',$id)->update($inputs);
                   $user = JobSeeker::where('user_id',$id)->first();

                    $user->fill($inputs)->save();
                    return $this->sendResponse($user, 'JobSeeker Updated successfully.');

                
        // $vali = $this->vali($request);

        //$data = JobSeeker::find($id);
        // $data = JobSeeker::where('user_id', $id)->first();
        // if($data == null)
        // {
        //     return $this->sendError('JobSeeker not found.');   
        // }
        // else{
            // $photoPath = $data->photo;
    
            // if($vali->passes()){
                // try {
                    //Move Uploaded File
                    // if($photoPath == $request->photo){
                    //     $inputs['photo'] = $request->photo;
                    // }
                    // else{
                        // if (file_exists($photoPath)) {
                        //     unlink($photoPath);
                        // }   
                        // else{
                        //     $photoFile = $request->file('photo');
                        //     $destinationPath = 'images/JobSeeker';
                        //     $timestamp=Carbon::now()->format('Ymds');
                        //     $image=$destinationPath.'/Photo'.$timestamp.'.'.$photoFile->getClientOriginalExtension();
                        //     $photoFile->move($destinationPath,$image);   
                        // }                      
                    // }
                //      $inputs = $request->all();
                //     $image="1";
        
                //     $inputs['photo'] = $image;
        
                //     $data = JobSeeker::where('user_id',$id)->update($inputs);
                //     return $this->sendResponse($inputs, 'JobSeeker Updated successfully.');

                // } catch (Exception $erorrs ) {
                //     return $this->sendError('Validation Error.', $erorrs);  
                // }
            // }
            // else{
            //     return $this->sendError('Validation Error.', $vali->errors());     
            // }
        // }


        
    }
    ////////////////////// front
     public function jobseeker_list($id)
    {
        $company= Company::where('user_id',$id)->first();
        $adv_ids = Advertisement::where('company_id',$company->id)->pluck('id')->toArray();
        $jobseeker_ids = CV::whereIn('advertisement_id',$adv_ids)->pluck('job_seeker_id')->toArray();
        
    $advs = CV::with('job_seeker','advertisement','cv_status')->whereIn('id',$jobseeker_ids)->get();

        $data = JobSeeker::with('gender','province','type_of_time','level_of_education','user')->whereIn('id',$jobseeker_ids)->get();
        //$data = JobSeeker::with('gender')->get();
        return $this->sendResponse($data,$advs, 'Adertisment retrieved successfully.');

    }
    
    

}
