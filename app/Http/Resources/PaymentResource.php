<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'id'                => $this -> id,
            'company_id'        => $this -> company_id,
            'advertisement_id'  => $this -> advertisement_id,
            'pay'               => $this ->pay ,
            'status'            => $this -> status,
            'created_at'        => $this->created_at->format('d/m/Y'),
            'updated_at'        => $this->updated_at->format('d/m/Y'),           
        ];
    }
}
