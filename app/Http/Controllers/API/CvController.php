<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Cv;
use App\Models\CvStatus;
use App\Models\JobSeeker;
use App\Models\Advertisement;
use App\Http\Resources\CvResource;
use Exception;
use Illuminate\Support\Carbon;
use Validator;
use Mail;
class CvController extends BaseController
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Cv::get();
        return $this->sendResponse(CvResource::collection($data), ' successfully.');

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
            'advertisement_id'                        => 'required',
    
            'job_seeker_id'                          => 'required',
           

        ],[
            'advertisement_id.required'               =>'شناسه آگهی اجباری است.',
            'job_seeker_id.required'        =>'شناسه کارجو اجباری است.',
          
           
        ]);   
        return $validation;
    }

    public function store(Request $request)
    {

        $vali = $this->vali($request);
          var_dump($vali);
        if($vali->passes() ){
            try {
                $input = $request->all();

            

                $data = Cv::create($input);                
                return $this->sendResponse(new CvResource($data), 'About Us created successfully.');

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
        $data = Cv::find($id);
        if (is_null($data)) {
            return $this->sendError('About Us not found.');
        }
        return $this->sendResponse(new CvResource($data), ' retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Cv::find($id);
        if (is_null($data)) {
            return $this->sendError('About Us not found.');
        }
        return $this->sendResponse(new CvResource($data), ' retrieved successfully.');
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

        $company = Cv::find($id);
        if($company == null)
        {
            return response()->json('Not Found!', 404);         
        }
        else{
            $imagePath = $company->image;
    
            if($vali->passes()){
                try {
                   
        
                    $data = Cv::where('id',$id)->update($input);
                    return $this->sendResponse(new CvResource($data), ' created successfully.');
                } catch (Exception $erorrs ) {
                    return $this->sendError('Server Error.', $erorrs); 
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
    public function destroy($id)
    {   
        $Cv = Cv::find($id);
        $Cv->delete();
        return $this->sendResponse([], 'deleted successfully.');

    }
    
      public function list_cv_status()
    {
        $data = CvStatus::get();
        return $this->sendResponse($data, ' successfully.');

    }
    
    public function send_cvs($jobseeker_id, $cv_status)
    {
        $user= JobSeeker::where('user_id',$jobseeker_id)->first();
        
        if($cv_status=='all'){
             $data = Cv::with('job_seeker','advertisement')->where('job_seeker_id',$user->id)->get();
        }else{
            $data = CvStatus::where('slug',$cv_status)->first();
         
         $status_id=$data->id;
        ///$status_id=1;
         
          $data = Cv::with('job_seeker','advertisement')->where('cv_status_id',$status_id)->where('job_seeker_id',$user->id)->get();
        }
        
         
        return $this->sendResponse($data, ' successfully.');

    }
    
    
  
    
    public function send_Resume($userId, $advId){
              $user= JobSeeker::where('user_id',$userId)->first();
              $adv= Advertisement::where('id',$advId)->first();
              $cv = new Cv;
              
              $cv->job_seeker_id=$user->id;
              $cv->advertisement_id=$advId;
              $cv->cv_status_id=1;
              
              $cv->save();
              
        
        
      
      $email=$user->email;
      $body="رزومه شما با موفقیت برای ";
      $body.=' '.$adv->name;
      $body.=' ارسال شد. به محض بررسی توسط کارفرما به شما اطلاع داده خواهد شد .';
      $info = array('name' => $body);
      
      
        Mail::send('mails.mail', $info, function ($message) use ($email)
        {
            $message->to($email, 'کاریابی') ->subject('ارسال روزمه');
        });
              
          return $this->sendResponse($cv, ' successfully.');

    }
    
    public function changeCvStatus($userId, $status,$adv_id){
              $user= JobSeeker::where('user_id',$userId)->first();
              
            //   $cv = new Cv;
              
            //   $cv->job_seeker_id=$user->id;
            //   $cv->cv_status_id=$status;
              
            //   $cv->save();
            $cv=  CV::where('job_seeker_id',$user->id)->where('advertisement_id',$adv_id)->update(
         ['cv_status_id' => $status]
         
      );
      
      $email=$user->email;
      $body="وضعیت رزومه شما به تغییر یافت";
      $info = array('name' => $body);
      
              Mail::send('mails.mail', $info, function ($message) use($email)
        {
            $message->to($email, 'okshod')
                ->subject('تغییر وضعیت رزومه ارسالی');
          
        });
              
          return $this->sendResponse($cv, ' successfully.');

    }
    
    
       public function CVNumber($id){
        
           $cv= CV::where('advertisement_id',$id)->get()->count();
              
          return $this->sendResponse($cv, ' successfully.');

    }
    
    
     public function sendCvStaus($adv_id,$job_seeker_id){
        
        
           $cv= CV::where('advertisement_id',$adv_id)->where('job_seeker_id',$job_seeker_id)->get();
              
          return $this->sendResponse($cv, ' successfully.');

    }
    
    
    public function sendBefore($id){
              $user= JobSeeker::where('user_id',$id)->first();
        
           $cv= CV::where('job_seeker_id',$user->id)->get()->count();
              
          return $this->sendResponse($cv, ' successfully.');

    }
    
    
    
    
}
