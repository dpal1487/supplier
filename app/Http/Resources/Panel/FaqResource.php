<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class FaqResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
        'id'=>$this->id,
        'category'=>$this->faqCategory['title'],
        'title'=>$this->title,
        'sub_title'=>$this->sub_title,
        'message'=>$this->message,
        'status'=>$this->status,
        'created_at'=>$this->created_at,
        'updated_at'=>$this->updated_at,
        ];
    }
}