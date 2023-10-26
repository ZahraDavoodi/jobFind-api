<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       
       
      
        return [
            'id'                    => $this -> id,
            'ticket_code'                => $this ->ticket_code,
            'company_id'                => $this -> company_id,
            'ticket_parent'                => $this ->ticket_parent,
            'description'                 => $this -> description,
            'file'               => $this -> file,
            'status'              => $this -> status,
            'created_at'            => $this->created_at->format('d/m/Y'),
            'updated_at'            => $this->updated_at->format('d/m/Y'),                        
        ];
    }
}
