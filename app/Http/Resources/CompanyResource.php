<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'id'            => $this->id,
            'name'          => $this->name,
            'logo'          => $this->logo,
            'cover'         => $this->cover,
            'phone'         => $this->phone,
            'email'         => $this->email,
            'description'   => $this->description,
            'status'        => $this->status,
            'created_at'    => $this->created_at->format('d/m/Y'),  
            'updated_at'    => $this->updated_at->format('d/m/Y'),
        ];
    }
}
