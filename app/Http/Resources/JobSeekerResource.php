<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobSeekerResource extends JsonResource
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
            'id'                            => $this-> id,
            'name'                          => $this-> name,
            'photo'                         => $this-> photo,
            'last_name'                     => $this-> last_name,
            'phone'                         => $this-> phone,
            'email'                         => $this-> email,
            'gender_id'                     => $this-> gender_id,
            'province_id'                   => $this-> province_id,
            'address'                       => $this-> address,
            'salary'                        => $this-> salary,
            'type_of_time_id'               => $this-> type_of_time_id,
            'level_of_education_id'         => $this-> level_of_education_id,
            'courses_details'               => $this-> courses_details,
            'resume'                        => $this-> resume,
            'personal_details'              => $this-> personal_details,
            'status'                        => $this-> status,
            'ready_to_work'                 => $this-> ready_to_work,
            'created_at'                    => $this->created_at->format('d/m/Y'),
            'updated_at'                    => $this->updated_at->format('d/m/Y'),                         
        ];
    }
}
