<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class OfferResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
        'id'=>$this->id,
        'title'=>$this->title,
        'description'=>$this->description,
        'thumbnail'=>$this->image['file_path_small'],
        'created_at'=>date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}