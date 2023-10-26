<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsResource extends JsonResource
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
            'id'            =>$this->id,
            'header'        =>$this->header,
            'small_article' =>$this->small_article,
            'title'         =>$this->title,
            'article'       =>$this->article,
            'image'         =>$this->image,
            'image_alt'     =>$this->image_alt,
            'slug'          =>$this->slug,
            'seo_title'     =>$this->seo_title,
            'key_words'     =>$this->key_words,
            'seo_description'=>$this->seo_description,
            'meta_data'     =>$this->meta_data,
            'reviews'       =>$this->reviews,
            'created_at'    => $this->created_at->format('d/m/Y'),
            'updated_at'    => $this->updated_at->format('d/m/Y'),
        ];
    }
}
