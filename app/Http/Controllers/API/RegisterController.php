<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\JobSeeker;
use App\Models\Cv;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Validator;
use Mail;
class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
    
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role'=>'required',
            
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
   
         if($request->role==2){
             
             $cv= Company::where('email',$request->email)->get()->count();
             $cv1= User::where('email',$request->email)->get()->count();
             if(!$cv && !cv1)
             {
          $input=$request->all();
       
        $input['password'] = bcrypt($request->password);
       // $input['remember_token'] = createToken('MyApp')->accessToken;
        
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        
      $user->remember_token = $success['token'];
    
             
             if($user->save()){
                $user1 = User::latest()->first();
       
       
             $input1['name']=$request->name.' '.$request->family;
             $input1['user_id']=$user1->id;
             $input1['email']=$user1->email;
             
          Company::create($input1); 
          
            $email=$user1->email;
      $body="ثبت نام شما در سامانه کاریابی انحام شد";
      $info = array('name' => $body);
      
              Mail::send('mails.mail', $info, function ($message) use($email)
        {
            $message->to($email, 'okshod')
                ->subject('ثبت نام');
          
        });
              
          return $this->sendResponse($input,'با موفقیت اضافه شد');
             }
         }
         else{
                 return $this->sendResponse(0, 'ایمیل تکراری است');
             }
         }
         
         if($request->role==1){
             
         $cv= JobSeeker::where('email',$request->email)->get()->count();
         $cv1= User::where('email',$request->email)->get()->count();
         
         if(!$cv && !$cv1){    
        
        $input=$request->all();
       
        $input['password'] = bcrypt($request->password);
      // $input['remember_token'] = createToken('MyApp')->accessToken;
        
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        
      $user->remember_token = $success['token'];
    
             
             if($user->save()){
      $user1 = User::latest()->first();
       
       
             $input1['name']=$request->name;
             $input1['last_name']=$request->family;
             $input1['user_id']=$user1->id;
             $input1['email']=$user1->email;
                $email=$user1->email;
      $body="ثبت نام شما در سامانه کاریابی انحام شد";
      $info = array('name' => $body);
      
              Mail::send('mails.mail', $info, function ($message) use($email)
        {
            $message->to($email, 'okshod')
                ->subject('ثبت نام');
          
        });
              
              
          JobSeeker::create($input1); 
          return $this->sendResponse($input, 'با موفقیت اضافه شد');
         }
         }
         else{
                 return $this->sendResponse(0,'ایمیل تکراری است');
             }
             
         }
         
         
        
        
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        
        if(Auth::attempt(['email' => $request->email, 'password' =>$request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['name'] =  $user->name;
            $success['email'] =  $user->email;
            $success['id'] =  $user->id;
            $success['role'] =  $user->role;
            
            $user->remember_token = $success['token'];
    
             $user->save();
            
            // $user->update($success);
        // User::where('id',$user->id)->update($success);
   
            return $this->sendResponse( $user , 0);
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
    
    
     public function token($token)
    {
        
      $data=User::where('remember_token',$token)->first();
      return $this->sendResponse($data, 'user retrieved successfully.');
    
    }
    
    function changePassword(Request $request) {
    //  $data = $request->all();
     $user= new User;
     
     
             $inputs = $request->all();
                    
     $inputs['password'] = bcrypt($request->password);
     $user = User::where('email',$request->email)->first();


                    $user->fill($inputs)->save();
     
     
     return $this->sendResponse($user, 'successfully.');
    

    
 }
}