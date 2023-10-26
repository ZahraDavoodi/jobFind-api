<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;

use App\Models\Advertisement;
use App\Models\AdvertisementCatagory;
use App\Models\ContactUs;
use App\Models\Province;
use App\Models\TypeOfTime;
use App\Models\LevelOfEducations;
use App\Models\Gender;
use App\Models\CvStatus;
use Illuminate\Http\Request;
use Exception;

class IndexController extends BaseController
{
    public function index()
    {
        $advs                   = Advertisement             :: with('advertisement_type','advertisement_catagory','type_of_time','gender')->where('status',1)->get();
        $adv_catagories         = AdvertisementCatagory     :: with('advertisement_type')->where('status',1)->get();
        $Province               = Province                  :: get();
        $TypeOfTime             = TypeOfTime                  :: get();
        $contact                = ContactUs                 :: get();

        $message = ' successfully.';
        return response()->json(['success' => true,'catagory'=>$adv_catagories,'advs'=>$advs,'province'=>$province,'contact'=>$contact,'TypeOfTime'=>$TypeOfTime,'message' => $message], 200);
    }
    
     public function TypeOfTime()
    {
               $TypeOfTime             = TypeOfTime                  :: get();
       

        $message = ' successfully.';
        return response()->json(['success' => true,'TypeOfTime'=>$TypeOfTime,'message' => $message], 200);
    }
    
    
      public function Province ()
    {
               $Province              = Province                   :: get();
       

        $message = ' successfully.';
        return response()->json(['success' => true,'Province '=>$Province ,'message' => $message], 200);
    }
    
    
      public function AdvertisementCatagory ()
    {
               $AdvertisementCatagory            = AdvertisementCatagory                :: get();
       

        $message = ' successfully.';
        return response()->json(['success' => true,'AdvertisementCatagory '=>$AdvertisementCatagory ,'message' => $message], 200);
    }
       public function level_of_education ()
    {
               $level_of_education            = LevelOfEducations              :: get();
       

        $message = ' successfully.';
        return response()->json(['success' => true,'level_of_education'=>$level_of_education ,'message' => $message], 200);
    }
    
           public function gender ()
    {
               $gender            = Gender              :: get();
       

        $message = ' successfully.';
        return response()->json(['success' => true,'gender'=>$gender ,'message' => $message], 200);
    }
    
              public function cvStatus ()
    {
               $s            = CvStatus             :: get();
       

        $message = ' successfully.';
        return response()->json(['success' => true,'data'=>$s ,'message' => $message], 200);
    }
    
}
