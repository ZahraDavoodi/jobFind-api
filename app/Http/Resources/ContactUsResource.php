<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactUsResource extends JsonResource
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
            'phone1'                => $this -> phone1,
            'phone2'                => $this -> phone2,
            'phone3'                => $this ->phone3,
            'email'                 => $this -> email,
            'address'               => $this -> address,
            'google_address'        => $this -> google_address,
            'facebook'              => $this -> facebook,
            'instagram'             => $this -> instagram,
            'telegram'              => $this ->telegram ,
            'pinterest'             => $this -> pinterest,
            'whatsapp'              => $this -> whatsapp,
            'seo_title'             => $this -> seo_title,
            'key_words'             => $this -> key_words,
            'seo_description'       => $this -> seo_description,
            'meta_data'             => $this -> meta_data,
            'reviews'               => $this -> reviews,
            'created_at'            => $this->created_at->format('d/m/Y'),
            'updated_at'            => $this->updated_at->format('d/m/Y'),                        
        ];
    }
}
