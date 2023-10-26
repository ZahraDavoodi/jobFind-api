<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
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
            'id'                        => $this->id,
            'advertisement_code'        => $this->advertisement_code,
            'name'                      => $this->name,
            'advertisement_type_id'     => $this->advertisement_type_id,
            'advertisement_catagory_id' => $this->advertisement_catagory_id,
            'type_of_time_id'           => $this->type_of_time_id,
            'gender_id'                 => $this->gender_id,
            'salary'                    => $this->salary,
            'job_position'              => $this->job_position,
            'important_skill'           => $this->important_skill,
            'duties'                    => $this->duties,
            'status'                    => $this->status,
            'reviews'                   => $this->reviews,
            'created_at'                => $this->created_at->format('d/m/Y'),
            'updated_at'                => $this->updated_at->format('d/m/Y'),
            
        ];
    }
}
