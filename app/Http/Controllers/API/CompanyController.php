<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Company;
use Exception;
use Illuminate\Support\Carbon;
use Validator;
use App\Http\Resources\CompanyResource;
class CompanyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Company::with('user')->get();
        return $this->sendResponse($data, 'company retrieved successfully.');
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
            'logo'                              => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'cover'                             => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'phone'                             => 'required|unique:companies,phone',
            'email'                             => 'required|unique:companies,email',
            'description'                       => 'required',
        ],[
            'name.required'                     =>'هیدر اجباری است.',

            'logo.required'                     =>'لوگو اجباری است.',
            'logo.image'                        =>'لوگو باید عکس باشد .',
            'logo.max'                          =>'لوگو از ۲ mb بیشتر شده نمی تواند است.',
            'logo.mimes'                        =>'لوگو باید به فرمت های png jpg jepg باشد.',

            'cover.required'                    =>' کاور اجباری است.',
            'cover.image'                       =>' کاور باید عکس باشد .',
            'cover.max'                         =>' کاور از ۲ mb بیشتر شده نمی تواند است.',
            'cover.mimes'                       =>' کاور باید به فرمت های png jpg jepg باشد.',

            'phone.required'                    =>'شماره تمای اجباری است.',
            'phone.unique'                      =>'شماره تماس تکراری است.',

            'email.required'                    =>'ایمیل اجباری است.',
            'email.unique'                      =>'ایمیل تکراری است.',

            'description.required'              =>'توضیحات اجباری است.',
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
                $logoFile = $request->file('logo');
                $destinationPath = 'images/Company';
                $timestamp=Carbon::now()->format('Ymds');
                $image=$destinationPath.'/Logo'.$timestamp.'.'.$logoFile->getClientOriginalExtension();
                $logoFile->move($destinationPath,$image);   
    
                $coverFile = $request->file('cover');
                $destinationPath = 'images/Company';
                $timestamp=Carbon::now()->format('Ymds');
                $cover=$destinationPath.'/cover'.$timestamp.'.'.$coverFile->getClientOriginalExtension();
                $coverFile->move($destinationPath,$cover);  
    
                $inputs['logo'] = $image;
                $inputs['cover'] = $cover;
    
                $data = Company::create($inputs);
                return $this->sendResponse(new CompanyResource($data), 'Company created successfully.');

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
         $data = Company::with('user')->find($id);
         // $data = Company::where('user_id', $id)->first();
        if (is_null($data)) {
            return $this->sendError('Type not found.');
        }
        return $this->sendResponse($data, 'Type retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Company::find($id);
        if (is_null($data)) {
            return $this->sendError('Type not found.');
        }
        return $this->sendResponse(new CompanyResource($data), 'Type retrieved successfully.');
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

        $data = Company::find($id);
        if($data == null)
        {
            return response()->json('Not Found!', 404);         
        }
        else{
            $logoPath = $data->logo;
            $coverPath = $data->cover;
    
            if($vali->passes()){
                try {
                    //Move Uploaded File
                    if($logoPath == $request->logo){
                        $inputs['logo'] = $request->logo;
                    }
                    else{
                        if (file_exists($logoPath)) {
                            unlink($logoPath);
                        }   
                        else{
                            $logoFile = $request->file('logo');
                            $destinationPath = 'images/Company';
                            $timestamp=Carbon::now()->format('Ymds');
                            $image=$destinationPath.'/Logo'.$timestamp.'.'.$logoFile->getClientOriginalExtension();
                            $logoFile->move($destinationPath,$image);   
                        }                      
                    }
                    if($coverPath == $request->cover){
                        $inputs['cover'] = $request->cover;
                    }
                    else{
                        if (file_exists($coverPath)) {
                            unlink($coverPath);
                        } 
                        else{
                            $coverFile = $request->file('cover');
                            $destinationPath = 'images/Company';
                            $timestamp=Carbon::now()->format('Ymds');
                            $cover=$destinationPath.'/cover'.$timestamp.'.'.$coverFile->getClientOriginalExtension();
                            $coverFile->move($destinationPath,$cover);  
                        }                          
                    }
        
                    $inputs['logo'] = $image;
                    $inputs['cover'] = $cover;
        
                    $data = Company::where('id',$id)->update($inputs);
                    return $this->sendResponse(new CompanyResource($data), 'Company created successfully.');
    
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
    public function destroy(Company $company)
    {
        $company->delete();
        return $this->sendResponse([], 'Company deleted successfully.');
    }
    
    //////////////////////// front
     public function front_show($id)
    {
        // $data = Company::find($id);
          $data = Company::with('user')->where('user_id', $id)->first();
        if (is_null($data)) {
            return $this->sendError('Type not found.');
        }
        return $this->sendResponse($data, 'Type retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function front_edit($id)
    {
        $data = Company::where('user_id', $id)->first();
        if (is_null($data)) {
            return $this->sendError('Type not found.');
        }
        return $this->sendResponse(new CompanyResource($data), 'Type retrieved successfully.');
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
        $vali = $this->vali($request);

        Company::where('user_id', $id)->first();
        if($data == null)
        {
            return response()->json('Not Found!', 404);         
        }
        else{
            $logoPath = $data->logo;
            $coverPath = $data->cover;
    
            if($vali->passes()){
                try {
                    //Move Uploaded File
                    if($logoPath == $request->logo){
                        $inputs['logo'] = $request->logo;
                    }
                    else{
                        if (file_exists($logoPath)) {
                            unlink($logoPath);
                        }   
                        else{
                            $logoFile = $request->file('logo');
                            $destinationPath = 'images/Company';
                            $timestamp=Carbon::now()->format('Ymds');
                            $image=$destinationPath.'/Logo'.$timestamp.'.'.$logoFile->getClientOriginalExtension();
                            $logoFile->move($destinationPath,$image);   
                        }                      
                    }
                    if($coverPath == $request->cover){
                        $inputs['cover'] = $request->cover;
                    }
                    else{
                        if (file_exists($coverPath)) {
                            unlink($coverPath);
                        } 
                        else{
                            $coverFile = $request->file('cover');
                            $destinationPath = 'images/Company';
                            $timestamp=Carbon::now()->format('Ymds');
                            $cover=$destinationPath.'/cover'.$timestamp.'.'.$coverFile->getClientOriginalExtension();
                            $coverFile->move($destinationPath,$cover);  
                        }                          
                    }
        
                    $inputs['logo'] = $image;
                    $inputs['cover'] = $cover;
        
                    $data = Company::where('id',$id)->update($inputs);
                    return $this->sendResponse(new CompanyResource($data), 'Company created successfully.');
    
                } catch (Exception $erorrs ) {
                    return $this->sendError('Validation Error.', $erorrs);
                }
            }
            else{
                return $this->sendError('Validation Error.', $vali->errors());         
            }
        }


        
    }
}
