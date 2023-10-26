<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Ticket;

use App\Http\Resources\TicketResource;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Carbon;
use Validator;
class TicketController extends BaseController
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Ticket::get();
        return $this->sendResponse(TicketResource::collection($data), 'Adertisment retrieved successfully.');
       
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
            'ticket_code'                     => 'required',
            'description'                     => 'required',
            'company_id'               => 'required',
            'status'                     => 'required',

        ],[
            'ticket_code.required'            =>'کد تیکت اجباری است.',
            'descriptions.required'            =>'توضیحات  اجباری است.',
            'company_id.required'      =>'ایدی شرکت  اجباری است.',
            'status.required'            =>'متا دیتا ری است.',  
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

              

                $data =Ticket::create($input);                
                return $this->sendResponse(new TicketResource($data), ' created successfully.');

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
        $data = Ticket::find($id);
        if (is_null($data)) {
            return $this->sendError('Contact Us not found.');
        }
        return $this->sendResponse(new TicketResource($data), ' retrieved successfully.'); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Ticket::find($id);
        if (is_null($data)) {
            return $this->sendError('Contact Us not found.');
        }
        return $this->sendResponse(new TicketResource($data), ' retrieved successfully.'); 
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
                $data  = Ticket::find($id);
                $data  ->update($input);
                return $this->sendResponse(new TicketResource($data), ' Updated successfully.');

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
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return $this->sendResponse([], 'deleted successfully.');

    }

}
