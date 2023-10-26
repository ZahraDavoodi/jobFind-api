<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\AboutUs;
use App\Http\Resources\AboutUsResource;
use Exception;
use Illuminate\Support\Carbon;
use Validator;
class AboutUsController extends BaseController
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AboutUs::get();
        return $this->sendResponse(AboutUsResource::collection($data), 'About Us retrieved successfully.');

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
            'header'                        => 'required',
            'small_article'                 => 'required',
            'slug'                          => 'required',
           
            'image_alt'                     => 'required',
            'title'                         => 'required',
            'article'                       => 'required',
            'seo_title'                     => 'required',
            'key_words'                     => 'required',
            'seo_description'               => 'required',
            'meta_data'                     => 'required',

        ],[
            'header.required'               =>'اسم درباره ما اجباری است.',
            'small_article.required'        =>'مقاله کوچک اجباری است.',
            'slug.required'                 =>'عنوان نمایش در سربرگ اجباری است.',
            'image.required'                =>'تصویر درباره ما اجباری است.',
            'image.image'                   =>'تصویر درباره ما باید عکس باشد است.',
            'image.max'                     =>'تصویر درباره ما از ۲ mb بیشتر شده نمی تواند است.',
            'image.mimes'                   =>'تصویر درباره ما باید به فرمت های png jpg jepg باشد.',
            'image_alt.required'            =>'عنوان تصویر درباره ما اجباری است.',
            'title.required'                =>'عنوان مقاله اجباری است.',
            'article.required'              =>'مقاله اجباری است.',
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

                // Move Uploaded File
                $imageFile = $request->file('image');
                $destinationPath = 'images/AboutUs';
                $timestamp=Carbon::now()->format('Ymds');
                $image=$destinationPath.'/AboutUs'.$timestamp.'.'.$imageFile->getClientOriginalExtension();
                $imageFile->move($destinationPath,$image); 

                $input['image'] = $image;

                $data = AboutUs::create($input);                
                return $this->sendResponse(new AboutUsResource($data), 'About Us created successfully.');

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
        $data = AboutUs::find($id);
        if (is_null($data)) {
            return $this->sendError('About Us not found.');
        }
        return $this->sendResponse(new AboutUsResource($data), 'About Us retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = AboutUs::find($id);
        if (is_null($data)) {
            return $this->sendError('About Us not found.');
        }
        return $this->sendResponse(new AboutUsResource($data), 'About Us retrieved successfully.');
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

        $company = AboutUs::find($id);
        if($company == null)
        {
            return response()->json('Not Found!', 404);         
        }
        else{
            $imagePath = $company->image;
    
            if($vali->passes()){
                try {
                    //Move Uploaded File
                    if($imagePath == $request->image){
                        $input['image'] = $request->image;
                    }
                    else{
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }   
                        else{
                            $imageFile = $request->file('image');
                            $destinationPath = 'images/AboutUs';
                            $timestamp=Carbon::now()->format('Ymds');
                            $image=$destinationPath.'/AboutUs'.$timestamp.'.'.$imageFile->getClientOriginalExtension();
                            $imageFile->move($destinationPath,$image);   
                        }                      
                    }
        
                    $input['image'] = $image;
        
                    $data = AboutUs::where('id',$id)->update($input);
                    return $this->sendResponse(new AboutUsResource($data), 'About Us created successfully.');
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
        $aboutUs = AboutUs::find($id);
        $aboutUs->delete();
        return $this->sendResponse([], 'About Us deleted successfully.');

    }
}
