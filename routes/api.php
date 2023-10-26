<?php
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\IndexController;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\PostController;

use App\Http\Controllers\API\JobSeekerInfoController;

use App\Http\Controllers\API\AboutUsController;
use App\Http\Controllers\API\ContactUsController;

use App\Http\Controllers\API\AdvertisementController;
use App\Http\Controllers\API\AdvertisementTypeController;
use App\Http\Controllers\API\AdvertisementCatagoryController;

use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\JobSeekerController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\TicketController;
use App\Http\Controllers\API\CvController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware(['cors:api'])->group( function () {

Route::get('/',         [IndexController::class, 'index']);
Route::get('/Province',         [IndexController::class, 'Province']);
Route::get('/AdvertisementCatagory',         [IndexController::class, 'AdvertisementCatagory']);
Route::get('/TypeOfTime',         [IndexController::class, 'TypeOfTime']);
Route::get('/majors',         [IndexController::class, 'level_of_education']);
Route::get('/gender',         [IndexController::class, 'gender']);
Route::get('/cvStatus',         [IndexController::class, 'cvStatus']);
Route::get('/sendBefore/{id}',         [CVController::class, 'sendBefore']);


Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login',    [RegisterController::class, 'login']);
Route::post('/changePassword',    [RegisterController::class, 'cjangePassword']);


Route::get('/contactUs',         [ContactUsController::class, 'index']);
Route::get('/aboutUs',         [AboutUsController::class, 'index']);
Route::get('/jobs',         [AdvertisementController::class, 'index']);
Route::get('/jobInfo/{id}',         [AdvertisementController::class, 'adv_show']);
Route::get('/jobSeekerInfo/{id}',         [JobSeekerController::class, 'jobseeker_show']);

Route::get('/jobsTypes',         [AdvertisementTypeController::class, 'index']);
Route::get('/jobsCategories',         [AdvertisementCatagoryController::class, 'index']);
Route::get('/review_plus/{id}',         [AdvertisementController::class, 'review_plus']);
Route::post('/search',   [AdvertisementController::class, 'search']);
Route::get('/jobs/category/{id}',   [AdvertisementController::class, 'search_cat']);
Route::get('/jobcategory/{id}',   [AdvertisementCatagoryController::class, 'show']);

Route::get('/token/{token}',   [RegisterController::class, 'token']);
Route::get('/logout',   [RegisterController::class, 'logout']);
Route::post('/changePassword',   [RegisterController::class, 'changePassword']);

// Route::middleware('auth:api')->group( function () {
// Route::middleware(['auth:api','is_jobseeker'])->group( function () {
    


  Route::get('/my_cv/{id}',         [JobSeekerController::class, 'front_show']);
  Route::post('/my_cv_edit/{id}',         [JobSeekerController::class, 'front_update']);
  
  Route::get('/my_send_cvs/{jobseeker_id}/{slug}',         [CvController::class, 'send_cvs']);
  
    Route::get('/sendResume/{userId}/{advId}',         [CvController::class, 'send_Resume']);
  
  
 

// });



// Route::middleware(['auth:api','is_company'])->group( function () {


    /* Start Site Routes */
   Route::get('/company_cv/{id}',         [CompanyController::class, 'front_show']);
  Route::post('/company_edit/{id}',         [CompanyController::class, 'front_update']);
  Route::post('/adv_store',         [AdvertisementController::class, 'adv_store']);
  
   Route::get('/adv_list/{id}',         [AdvertisementController::class, 'adv_list']);
    Route::get('/jobseeker_list/{id}',         [JobSeekerController::class, 'jobseeker_list']);
        Route::get('/jobseeker_all',         [JobSeekerController::class, 'index']);
     
Route::get('/changeCvStatus/{id}/{status}/{adv_id}',         [CvController::class, 'changeCvStatus']);
Route::get('/cvNumber/{id}',         [CVController::class, 'CVNumber']);
Route::get('/sendCvStaus/{id}',         [CVController::class, 'sendCvStaus']);




// });

// Route::middleware(['auth:api','is_admin'])->group( function () {


    /* Start Site Routes */
    Route::get('job_seeker',                   [JobSeekerInfoController::class,'index']);
    Route::get('job_seeker_cvs',               [JobSeekerInfoController::class,'show']);



    /* End Site Routes */
    
    Route::apiResource('posts',                 PostController::class);
    Route::apiResource('about_us',              AboutUsController::class);
    Route::apiResource('contact_us',            ContactUsController::class);
    Route::apiResource('advs',                  AdvertisementController::class);
    Route::apiResource('advTypes',              AdvertisementTypeController::class);
    Route::apiResource('advCatagories',         AdvertisementCatagoryController::class);
    
    Route::apiResource('companies',             CompanyController::class);
    Route::apiResource('job_seekers',          JobSeekerController::class);
    Route::apiResource('payments',              PaymentController::class);
     Route::apiResource('tickets',              TicketController::class);
      Route::apiResource('cvs',              CvController::class);
          Route::get('/list_cv_status',         [CvController::class, 'list_cv_status']);
      

// });