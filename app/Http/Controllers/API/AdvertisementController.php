<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\AdvertisementCatagory;
use App\Models\TypeOfTime;
use App\Models\Company;
use App\Models\Province;
use App\Http\Resources\AdvertisementResource;
use Exception;
use Illuminate\Support\Carbon;
use Validator;
use DB;
class AdvertisementController extends BaseController
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Advertisement::with('advertisement_catagory','type_of_time','gender','province','company')->paginate(12);
        // $data = Advertisement::with('advertisement_catagory','type_of_time','gender','province','company')->get();
        // $data = Advertisement::where('status', 1)->get()->advertisement_catagory;
        
       // $data1 = AdvertisementCatagory::where('status', 1)->get();
       //$data=$data->advetisement_category->name;
       
    //   $data = Advertisement::join('advertisement_catagories', 'advertisement_catagories.id', '=', 'advertisements.advertisement_catagory_id')->join('provinces', 'provinces.id', '=', 'advertisements.province_id')->join('type_of_times', 'type_of_times.id', '=', 'advertisements.type_of_time_id')->get(['advertisements.*','advertisement_catagories.name as catagory_name','provinces.name as province_name','type_of_times.name as 	type_of_times_name']);

        return $this->sendResponse($data, 'Adertisment retrieved successfully.');
       // return $this->sendResponse($data->advertisement_catagory, 'Adertisment retrieved successfully.');
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
            'name'=>                                    'required',
            'advertisement_catagory_id'=>               'required',
            'type_of_time_id'=>                         'required',
            'gender_id'=>                               'required',
            'salary'=>                                  'required',

            'status'=>                                  'required',
        ],[
            'name.required'=>                            'اسم اجباری است',
            'advertisement_type_id.required'=>           'نوعیت آگهی اجباری است',
            'advertisement_catagory_id.required'=>       'دسته بندی آگهی اجباری است ',
            'type_of_time_id.required'=>                 'نوع همکاری اجباری است',
            'gender_id.required'=>                       'جنسیت اجباری است',
            'salary.required'=>                          'حقوق اجباری است',
            'job_position.required'=>                    'موقعیت شغلی اجباری است',
            'important_skill.required'=>                 'مهارت های اجباری است',
            'duties.required'=>                          'وظایف اجباری است',
            'status.required'=>                          'حالت آگهی اجباری است',
        ]);   
        return $validation;
    }

    public function store(Request $request)
    {

        $vali = $this->vali($request);

        if($vali->passes()){
            try {
                 $input = $request->all();
                $data = Advertisement::create($input);                
                return $this->sendResponse(new AdvertisementResource($data), 'Advertisement created successfully.');
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
        $data = Advertisement::with('advertisement_catagory','type_of_time','gender','province','company')->find($id);
        if (is_null($data)) {
            return $this->sendError('Advertisement not found.');
        }
        return $this->sendResponse($data, 'Advertisement retrieved successfully.');        

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Advertisement::with('advertisement_type','advertisement_catagory','type_of_time','gender','province')->find($id);
        if (is_null($data)) {
            return $this->sendError('Advertisement not found.');
        }
        return $this->sendResponse(new AdvertisementResource($data), 'Advertisement retrieved successfully.');  
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
        if($vali->passes()){
            try {
                $data = Advertisement::where('id',$id)->update($request);
                return $this->sendResponse(new AdvertisementResource($data), 'Advertisment updated successfully.');

            } catch (Exception $erorrs ) {
                return $this->sendError('Validation Error.', $erorrs);  
            }
        }
        else{
            return $this->sendError('Validation Error.', $vali->errors());     
        }
    }

 

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advertisement $adv)
    {
        $adv->delete();
        return $this->sendResponse([], 'Advertisment deleted successfully.');
    }
    
    
    ////////////////////////// front
     public function adv_list($id)
    {
        $company= Company::where('user_id',$id)->first();
        $data = Advertisement::with('advertisement_type','advertisement_catagory','type_of_time','gender','province')->where('company_id',$company->id)->get();
        return $this->sendResponse($data, 'Adertisment retrieved successfully.');
    }


      public function adv_show($slug)
    {
        $data = Advertisement::with('advertisement_catagory','type_of_time','gender','province','company')->where('slug',$slug)->get();
        if (is_null($data)) {
            return $this->sendError('Advertisement not found.');
        }
        return $this->sendResponse($data, 'Advertisement retrieved successfully.');        

    }
    
    public function adv_store(Request $request)
    {
         $input = $request->all();
    
                $data = Advertisement::create($input); 
                      return $this->sendResponse($input, 'Advertisement created successfully.');


        // $vali = $this->vali($request);
         
        // if($vali->passes()){
        //     // try {
        //     //      $input = $request->all();
                 
        //     //     $data = Advertisement::create($input);                
        //     //     return $this->sendResponse($data, 'Advertisement created successfully.');
        //     // } catch (Exception $erorrs ) {
        //     //     return $this->sendError('Validation Error.', $erorrs);    
        //     // }
        // }
        // else{
        //     return $this->sendError('Validation Error.', $vali->errors());     
        // }
    }
    
    
     public function review_plus($id)
    {
       
                $data = Advertisement::where('id',$id)->increment('reviews');
                
                return $this->sendResponse($data, 'Advertisment updated successfully.');

           
        
    }
    public function search(Request $request)
    {
       $type_of_time_id= $request->type_of_time_id;
       $province_id= $request->province_id;
       $advertisement_catagory_id=$request->advertisement_catagory_id;
       
        if($type_of_time_id==0 &&  $province_id==0 && $advertisement_catagory_id==0){
             $data = Advertisement::with('advertisement_type','advertisement_catagory','type_of_time','gender','province','company')->paginate(12);
        }
        elseif($type_of_time_id==0 &&  $province_id==0){
                    $data = Advertisement::with('advertisement_type','advertisement_catagory','type_of_time','gender','province','company')->where('advertisement_catagory_id',$advertisement_catagory_id)->paginate(12);

            
        }elseif( $province_id==0 && $advertisement_catagory_id==0){
                    $data = Advertisement::with('advertisement_type','advertisement_catagory','type_of_time','gender','province','company')->where('type_of_time_id',$type_of_time_id)->paginate(12);

            
        }elseif($type_of_time_id==0 &&   $advertisement_catagory_id==0){
                    $data = Advertisement::with('advertisement_type','advertisement_catagory','type_of_time','gender','province','company')->where('province_id',$province_id)->paginate(12);

        }elseif($type_of_time_id==0){
                    $data = Advertisement::with('advertisement_type','advertisement_catagory','type_of_time','gender','province','company')->where('type_of_time_id',$type_of_time_id)->paginate(12);

            
        } elseif( $province_id==0){
                    $data = Advertisement::with('advertisement_type','advertisement_catagory','type_of_time','gender','province','company')->where('type_of_time_id',$type_of_time_id)->where('advertisement_catagory_id',$advertisement_catagory_id)->paginate(12);

            
        } elseif($advertisement_catagory_id==0){
                    $data = Advertisement::with('advertisement_type','advertisement_catagory','type_of_time','gender','province','company')->where('type_of_time_id',$type_of_time_id)->where('province_id',$province_id)->paginate(12);

            
        }
        
        else{  
        $data = Advertisement::with('advertisement_type','advertisement_catagory','type_of_time','gender','province','company')->where('type_of_time_id',$type_of_time_id)->where('province_id',$province_id)->where('advertisement_catagory_id',$advertisement_catagory_id)->paginate(12);
        }
        if (is_null($data)) {
            return $this->sendError('Advertisement not found.');
        }
        return $this->sendResponse($data, 'Advertisement retrieved successfully.');        

    }
    public function search_cat(Request $request,$cat)
    {
       
       $advertisement_catagory_id=$cat;
          
        $data = Advertisement::with('advertisement_type','advertisement_catagory','type_of_time','gender','province','company')->where('advertisement_catagory_id',$advertisement_catagory_id)->paginate(12);
        if (is_null($data)) {
            return $this->sendError('Advertisement not found.');
        }
        return $this->sendResponse($data, 'Advertisement retrieved successfully.');        

    }
   
}




