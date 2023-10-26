<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Payment;
use App\Http\Resources\PaymentResource;
use Illuminate\Http\Request;
use Exception;
use Validator;
class PaymentController extends BaseController
{
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Payment::with('company','advertisement')->get();
        return $this->sendResponse(PaymentResource::collection($data), 'Payment retrieved successfully.');
       
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
            'company_id'                     => 'required',
            'advertisement_id'               => 'required',
            'pay'                            => 'required',
        ],[
            'company_id'                     => 'اسم شرکت اجباری است',
            'advertisement_id'               => 'اگهی اجباری است',
            'pay'                            => 'پرداخت اجباری است',
        ]);   
        return $validation;
    }

    public function store(Request $request)
    {

        $vali = $this->vali($request);

        if($vali->passes()){
            try {
                $inputs = $request->all();
                $data = Payment::create($inputs);                
                return $this->sendResponse(new PaymentResource($data), 'Payment created successfully.');
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
        $data = Payment::with('company','advertisement')->find($id);
        if (is_null($data)) {
            return $this->sendError('Payment not found.');
        }
        return $this->sendResponse(new PaymentResource($data), 'Payment retrieved successfully.'); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Payment::with('company','advertisement')->find($id);
        if (is_null($data)) {
            return $this->sendError('Payment not found.');
        }
        return $this->sendResponse(new PaymentResource($data), 'Payment retrieved successfully.'); 
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
                    //Move Uploaded File
                    $data = Payment::where('id',$id)->update($request);
                    return $this->sendResponse(new PaymentResource($data), 'Payment updated successfully.');

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
    public function destroy(Payment $payment)
    {
        $payment -> delete();
        return $this->sendResponse([], 'Payment deleted successfully.');
    }

}
