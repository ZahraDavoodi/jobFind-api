<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\ContactUs;
use App\Http\Resources\ContactUsResource;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Carbon;
use Validator;
class ContactUsController extends BaseController
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ContactUs::get();
        return $this->sendResponse(ContactUsResource::collection($data), 'Adertisment retrieved successfully.');
       
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
            'seo_title'                     => 'required',
            'key_words'                     => 'required',
            'seo_description'               => 'required',
            'meta_data'                     => 'required',

        ],[
            'seo_title.required'            =>'عنوان سئو اجباری است.',
            'key_words.required'            =>'کلمات کلیدی اجباری است.',
            'seo_description.required'      =>'توضیحات سئو اجباری است.',
            'meta_data.required'            =>'متا دیتا اجباری است.',  
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

              

                $data =ContactUs::create($input);                
                return $this->sendResponse(new ContactUsResource($data), 'About Us created successfully.');

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
        $data = ContactUs::find($id);
        if (is_null($data)) {
            return $this->sendError('Contact Us not found.');
        }
        return $this->sendResponse(new ContactUsResource($data), 'Contact Us retrieved successfully.'); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ContactUs::find($id);
        if (is_null($data)) {
            return $this->sendError('Contact Us not found.');
        }
        return $this->sendResponse(new ContactUsResource($data), 'Contact Us retrieved successfully.'); 
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
                $input = $request->all();
                $data  = ContactUs::find($id);
                $data  ->update($input);
                return $this->sendResponse(new ContactUsResource($data), 'Contact Us Updated successfully.');

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
    public function destroy($id)
    {
    }

}
