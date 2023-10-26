<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementTypeResource extends JsonResource
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
            'id'=>                  $this->id,
            'name'=>                $this->name,
            'slug'=>                $this->slug,
            'seo_title'=>           $this->seo_title,
            'key_words'=>           $this->key_words,
            'seo_description'=>     $this->seo_description,
            'meta_data'=>           $this->meta_data,
            'reviews'=>             $this->reviews,
            'status'=>              $this->status,
            'created_at'=>          $this->created_at->format('d/m/Y'),  
            'updated_at'=>          $this->updated_at->format('d/m/Y'),
        ];
    }
}
