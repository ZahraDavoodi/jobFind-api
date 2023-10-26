<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\AdvertisementType;
use App\Http\Resources\AdvertisementTypeResource;
use Exception;
use Illuminate\Support\Carbon;
use Validator;
class AdvertisementTypeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AdvertisementType::get();
        return $this->sendResponse(AdvertisementTypeResource::collection($data), 'Type retrieved successfully.');
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
            'slug'                              => 'required',
            'seo_title'                         => 'required',
            'key_words'                         => 'required',
            'seo_description'                   => 'required',
            'meta_data'                         => 'required',
        ],[
            'name.required'                     =>'اسم اجباری است.',
            'slug.required'                     =>'سربرگ اجباری است.',
            'seo_title.required'                =>'موضوع سئو اجباری است.',
            'key_words.required'                =>'کلمات کلیدی اجباری است.',
            'seo_description.required'          =>'توضیحات سئو اجباری است.',
            'meta_data.required'                =>'مدیتا دیتا اجباری است.',
        ]);   
        return $validation;
    }

    public function store(Request $request)
    {

        $vali = $this->vali($request);

        if($vali->passes()){
            try {
                $input = $request->all();
                $data = AdvertisementType::create($input);                
                return $this->sendResponse(new AdvertisementTypeResource($data), 'Catagory created successfully.');

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
        $data = AdvertisementType::find($id);
        if (is_null($data)) {
            return $this->sendError('Type not found.');
        }
        return $this->sendResponse(new AdvertisementTypeResource($data), 'Type retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = AdvertisementType::find($id);
        if (is_null($data)) {
            return $this->sendError('Type not found.');
        }
        return $this->sendResponse(new AdvertisementTypeResource($data), 'Type retrieved successfully.');
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
                $data = AdvertisementType::where('id',$id)->update($input);
                return $this->sendResponse(new AdvertisementTypeResource($data), 'Type updated successfully.');
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
    public function destroy(AdvertisementType $advType)
    {
        $advType->delete();
        return $this->sendResponse([], 'Type deleted successfully.');
    }
}
